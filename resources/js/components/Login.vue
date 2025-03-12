<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-sm p-6 bg-white rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700">Login</h2>

            <form @submit.prevent="handleLogin" class="mt-6 space-y-4">
                <input
                    v-model="email"
                    type="email"
                    placeholder="Email"
                    required
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                />
                <input
                    v-model="password"
                    type="password"
                    placeholder="Password"
                    required
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                />
                <button
                    type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Login
                </button>
            </form>

            <p class="mt-4 text-sm text-center text-gray-600">
                Don't have an account?
                <router-link to="/register" class="text-blue-600 hover:underline">Register</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import { login } from "../services/authService";

export default {
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        async handleLogin() {
            try {
                const response = await login({ email: this.email, password: this.password });
                localStorage.setItem("token", response.data.access_token);
                this.$router.push("/dashboard");
            } catch (error) {
                alert(error.response?.data.error || "Login failed!");
            }
        },
    },
};
</script>

<style scoped>
/* Custom styles (if needed) */
</style>
