<template>
    <nav>
        <router-link to="/dashboard">Dashboard</router-link>
        <button @click="handleLogout">Logout</button>
    </nav>
</template>

<script>
import { logout } from "../services/authService";

export default {
    methods: {
        async handleLogout() {
            try {
                await logout();
                localStorage.removeItem("token");
                this.$router.push("/");
            } catch (error) {
                alert("Logout failed!");
            }
        },
    },
};
</script>

<style scoped>
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #333;
    padding: 10px;
}
nav a {
    color: white;
    text-decoration: none;
    /* margin-right: 15px; */
    font-weight: bold;
    padding-left: 32px;;
}
button {
    background: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
</style>
