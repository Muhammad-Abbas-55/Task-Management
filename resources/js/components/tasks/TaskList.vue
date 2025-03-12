<template>
    <div :class="['dashboard-container', { 'sidebar-collapsed': !isSidebarOpen }]">
        <!-- Sidebar Component -->
        <Sidebar ref="sidebar" @toggle="toggleSidebar" />
        
        <!-- Main Content -->
        <main class="dashboard-content">
            <Navbar />
            <div class="task-container">
                <h2>Task List</h2>
                <router-link to="/create-task" class="add-button">+ Add Task</router-link>

                <div v-if="tasks.length" class="task-list">
                    <div v-for="task in tasks" :key="task.id" class="task-card">
                        <h3>{{ task.title }}</h3>
                        <p>{{ task.description }}</p>
                        <p><strong>Priority:</strong> {{ task.priority }}</p>
                        <p><strong>Status:</strong> {{ task.status ? "Completed" : "Pending" }}</p>
                        <img 
                            v-if="task.image_path" 
                            :src="getImageUrl(task.image_path)" 
                            alt="Task Image" 
                            class="task-image" 
                        />
                        <div class="task-actions">
                            <router-link :to="`/edit-task/${task.id}`">✏️ Edit</router-link>
                            <button @click="removeTask(task.id)">🗑️ Delete</button>
                        </div>
                    </div>
                </div>
                
                <p v-else class="no-tasks">No tasks available.</p>
            </div>
        </main>
    </div>
</template>

<script>
import { getTasks, deleteTask } from "@/services/authService";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";

export default {
    components: { Navbar, Sidebar },
    data() {
        return {
            tasks: [],
            isSidebarOpen: true, // Sidebar state
        };
    },
    async mounted() {

        try {
        const response = await getTasks();
        this.tasks = response.data; // Make sure response.data contains tasks
    } catch (error) {
        console.error("Error fetching tasks:", error);
    }
    },
    methods: {
        async fetchTasks() {
            try {
                const response = await getTasks();
                this.tasks = response.data; // Ensure data is properly assigned
            } catch (error) {
                console.error("Error fetching tasks:", error);
            }
        },
        async removeTask(id) {
            if (confirm("Are you sure you want to delete this task?")) {
                try {
                    await deleteTask(id);
                    this.tasks = this.tasks.filter(task => task.id !== id); // Remove deleted task from list
                } catch (error) {
                    console.error("Error deleting task:", error);
                }
            }
        },
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        },
        // 🔹 Added method to generate full image path
        getImageUrl(imagePath) {
            return `${import.meta.env.VITE_API_BASE_URL}/storage/${imagePath}`;
        },
    },
};
</script>

<style scoped>

/* 🔹 Added styling for Task Image */
.task-image {
    width: 100%;
    max-height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}
/* Layout */
.dashboard-container {
    display: flex;
    height: 100vh;
}

/* Sidebar Collapsed State */
.sidebar-collapsed .dashboard-content {
    margin-left: 0;
}

/* Main Content */
.dashboard-content {
    flex-grow: 1;
    padding: 20px;
    margin-left: 250px;
    text-align: center;
    background: #f4f4f9;
    transition: margin-left 0.3s ease;
}

/* Task Container */
.task-container {
    max-width: 800px;
    margin: auto;
    text-align: center;
}

/* Task List */
.task-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Task Card */
.task-card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Buttons */
.add-button {
    display: inline-block;
    padding: 10px 15px;
    background: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 15px;
}

.task-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.task-actions a {
    text-decoration: none;
    color: #007bff;
}

.task-actions button {
    background: red;
    color: white;
    border: none;
    padding: 5px;
    cursor: pointer;
}

/* No Tasks */
.no-tasks {
    font-size: 18px;
    color: #555;
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-content {
        margin-left: 0;
        width: 100%;
    }
}
</style>
