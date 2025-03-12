<template>
    <div>
        <!-- Toggle Button -->
        <button class="toggle-btn" @click="toggleSidebar">
            ☰
        </button>

        <!-- Sidebar -->
        <aside :class="['sidebar', { 'sidebar-collapsed': !isOpen }]">
            <h2>Task Manager</h2>
            <router-link to="/tasks" class="sidebar-link">📋 Tasks</router-link>
            <router-link to="/create-task" class="sidebar-link">➕ Add Task</router-link>
        </aside>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: window.innerWidth > 768,
        };
    },
    methods: {
        toggleSidebar() {
            this.isOpen = !this.isOpen;
            this.$emit("toggle", this.isOpen);
        },
        handleResize() {
            this.isOpen = window.innerWidth > 768;
            this.$emit("toggle", this.isOpen);
        },
    },
    mounted() {
        window.addEventListener("resize", this.handleResize);
    },
    beforeUnmount() {
        window.removeEventListener("resize", this.handleResize);
    },
};
</script>

<style scoped>
/* Sidebar Styles */
.sidebar {
    width: 250px;
    background: #1e1e2f;
    color: white;
    padding: 20px;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: start;
    position: fixed;
    left: 0;
    top: 0;
    transition: transform 0.3s ease-in-out;
}

/* Collapsed Sidebar */
.sidebar-collapsed {
    transform: translateX(-100%);
}

/* Toggle Button */
.toggle-btn {
    position: fixed;
    top: 15px;
    left: 15px;
    background: #1e1e2f;
    color: white;
    border: none;
    font-size: 22px;
    padding: 10px;
    cursor: pointer;
    z-index: 1000;
    border-radius: 5px;
}

/* Sidebar Links */
.sidebar h2 {
    font-size: 22px;
    margin-bottom: 20px;
    text-align: center;
    width: 100%;
}

.sidebar-link {
    color: white;
    text-decoration: none;
    font-size: 18px;
    margin: 10px 0;
    padding: 10px;
    display: block;
    width: 100%;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.sidebar-link:hover {
    background: #33334d;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar-collapsed {
        transform: translateX(0);
    }
}
</style>
