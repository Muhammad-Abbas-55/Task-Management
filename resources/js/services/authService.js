import axios from "axios";

const api = axios.create({
    baseURL: "http://task-management.test/api",
    headers: { "Content-Type": "application/json" },
    withCredentials: true, // Enables cookies (needed for Sanctum authentication)
});

// Get Auth Headers
const authHeader = () => {
    const token = localStorage.getItem("token");
    return token ? { Authorization: `Bearer ${token}` } : {};
};

// Auth APIs
export const register = (userData) => api.post("/register", userData);
export const login = (userData) => api.post("/login", userData);
export const logout = () => api.post("/logout", {}, { headers: authHeader() });
export const getUser = () => api.get("/user", { headers: authHeader() });

// Task APIs
export const getTasks = () => api.get("/tasks", { headers: authHeader() });
export const getTask = (id) => api.get(`/tasks/${id}`, { headers: authHeader() });
export const createTask = (task) => api.post("/tasks", task, { headers: authHeader() });
export const updateTask = (id, task) => api.put(`/tasks/${id}`, task, { headers: authHeader() });
export const deleteTask = (id) => api.delete(`/tasks/${id}`, { headers: authHeader() });
