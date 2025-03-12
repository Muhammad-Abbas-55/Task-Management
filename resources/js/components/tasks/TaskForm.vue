<template>
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-xl p-6 mt-10">
        <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">
            {{ isEditing ? "Edit Task" : "Create Task" }}
        </h2>

        <form @submit.prevent="handleSubmit" class="space-y-4">
            <div>
                <label class="block text-gray-600 font-medium">Title</label>
                <input
                    v-model="task.title"
                    type="text"
                    placeholder="Enter Task Title"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"
                />
            </div>

            <div>
                <label class="block text-gray-600 font-medium">Description</label>
                <textarea
                    v-model="task.description"
                    placeholder="Enter Task Description"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"
                ></textarea>
            </div>

            <div>
                <label class="block text-gray-600 font-medium">Priority</label>
                <select
                    v-model="task.priority"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"
                >
                    <option disabled>Choose Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-600 font-medium">Status</label>
                <select
                    v-model="task.status"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"
                >
                    <option disabled>Choose Status</option>
                    <option :value="0">Pending</option>
                    <option :value="1">Completed</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-600 font-medium">Upload Image</label>
                <input
                    type="file"
                    @change="handleFileUpload"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"
                />
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-300"
            >
                {{ isEditing ? "Update Task" : "Create Task" }}
            </button>
        </form>
    </div>
</template>

<script>
import { createTask, updateTask, getTask } from "@/services/api";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
export default {
    props: ["taskId"],
    data() {
        return {
            task: {
                title: "",
                description: "",
                priority: "Medium",
                status: 0,
                image_path: null,
            },
            isEditing: false,
        };
    },
    async created() {
        if (this.taskId) {
            this.isEditing = true;
            try {
                const response = await getTask(this.taskId);
                this.task = response.data;
            } catch (error) {
                console.error("Error fetching task:", error);
            }
        }
    },
    methods: {
        handleFileUpload(event) {
            this.task.image_path = event.target.files[0];
        },
        async handleSubmit() {
            try {
                const formData = new FormData();
                formData.append("title", this.task.title);
                formData.append("description", this.task.description);
                formData.append("priority", this.task.priority);
                formData.append("status", this.task.status);

                if (this.task.image_path) {
                    formData.append("image_path", this.task.image_path);
                }

                if (this.isEditing) {
                    await updateTask(this.taskId, formData);
                    alert("Task updated successfully!");
                } else {
                    await createTask(formData);
                    alert("Task created successfully!");
                }
            } catch (error) {
                console.error("Error saving task:", error);
                if (error.response && error.response.status === 401) {
                    alert("Session expired. Please log in again.");
                    localStorage.removeItem("token");
                    this.$router.push("/login");
                }
            }
        },
    },
};
</script>

<style scoped>
/* Styling handled by Tailwind, no extra CSS needed */
</style>
