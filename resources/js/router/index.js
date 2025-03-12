import { createRouter, createWebHistory } from "vue-router";
import Login from "@/components/Login.vue";
import Register from "@/components/Register.vue";
import Dashboard from "@/components/Dashboard.vue";
import TaskList from "@/components/tasks/TaskList.vue";
import TaskForm from "@/components/tasks/TaskForm.vue";

const routes = [
    { path: "/", component: Login },
    { path: "/register", component: Register },
    { path: "/dashboard", component: Dashboard, meta: { requiresAuth: true } },

    { path: "/tasks", component: TaskList },
    { path: "/create-task", component: TaskForm },
    { path: "/edit-task/:id", component: TaskForm, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Authentication Guard
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem("token");
    if (to.meta.requiresAuth && !isAuthenticated) {
        next("/");
    } else {
        next();
    }
});

export default router;
