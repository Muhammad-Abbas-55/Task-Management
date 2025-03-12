import axios from "axios";

const api = axios.create({
    baseURL: "http://task-management.test/api",
    withCredentials: true, // Ensures Laravel Sanctum works
});

// Get Auth Headers
const authHeader = () => {
    const token = localStorage.getItem("token");
    return token ? { Authorization: `Bearer ${token}` } : {};
};

// Create Task (POST)
export const createTask = (taskData) => 
    api.post("/tasks", taskData, {
        headers: { ...authHeader(), "Content-Type": "multipart/form-data" },
    });

// Update Task (PUT via FormData)
export const updateTask = (id, taskData) => 
    api.post(`/tasks/${id}?_method=PUT`, taskData, {
        headers: { ...authHeader(), "Content-Type": "multipart/form-data" },
    });

// Fetch Task
export const getTask = (id) => 
    api.get(`/tasks/${id}`, { headers: authHeader() });
