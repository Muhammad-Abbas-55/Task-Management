<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. List All Tasks
    public function index()
    {
        return response()->json(Task::where('user_id', Auth::id())->get());
    }

    // 2. Store a New Task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|integer|in:0,1',
            'priority' => 'required|string',
            'image_path' => 'nullable|image|mimes:png,jpg,svg|max:2048',
        ]);
    
        if ($request->hasFile('image_path')) {
            $filename = time() . '_' . $request->file('image_path')->getClientOriginalName();
            $filepath = $request->file('image_path')->storeAs('task_images', $filename, 'public');
            $validated['image_path'] = 'storage/' . $filepath;
        }
    
        $task = $request->user()->tasks()->create($validated);
        return response()->json($task, 201);
    }
    // 3. Show a Single Task
    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($task);
    }

    // 4. Update a Task
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|integer|in:0,1', // 0 = Pending, 1 = Completed
            'priority' => 'required|string',
            'image_path' => 'nullable|image|mimes:png,jpg,svg|max:2048',
        ]);

        // Handle image update
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            if ($task->image_path && File::exists(public_path($task->image_path))) {
                File::delete(public_path($task->image_path));
            }

            // Upload new image
            $filename = uniqid() . '_' . $request->file('image_path')->getClientOriginalName();
            $request->file('image_path')->move(public_path('task_images'), $filename);
            $validated['image_path'] = 'task_images/' . $filename;
        }

        // Update task
        $task->update($validated);

        return response()->json($task, 200);
    }

    // 5. Delete a Task
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
