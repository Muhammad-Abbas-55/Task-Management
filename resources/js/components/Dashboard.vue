<template>
    <div :class="['dashboard-container', { 'sidebar-collapsed': !isSidebarOpen }]">
        <!-- Sidebar Component -->
        <Sidebar ref="sidebar" @toggle="toggleSidebar" />

        <!-- Main Content -->
        <main class="dashboard-content">
            <Navbar />
            <h1>Welcome to Task Management Dashboard</h1>
        </main>
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/Sidebar.vue";

export default {
    components: { Navbar, Sidebar },
    data() {
        return {
            isSidebarOpen: window.innerWidth > 768, // Sidebar open by default on large screens
        };
    },
    methods: {
        toggleSidebar(isOpen) {
            this.isSidebarOpen = isOpen;
        },
        handleResize() {
            this.isSidebarOpen = window.innerWidth > 768;
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
.dashboard-container {
    display: flex;
    height: 100vh;
    transition: all 0.3s ease-in-out;
}

/* When sidebar is open */
/* .dashboard-container:not(.sidebar-collapsed) .dashboard-content {
    margin-left: 250px;
} */

/* Full-width content when sidebar is collapsed */
.sidebar-collapsed .dashboard-content {
    margin-left: 0;
    width: 100%;
}

/* Main content styling */
.dashboard-content {
    flex-grow: 1;
    padding: 20px;
    text-align: center;
    background: #f4f4f9;
    transition: margin-left 0.3s ease-in-out;
}

h1 {
    font-size: 30px;
    font-weight: 600;
    padding: 15px;
}
</style>
