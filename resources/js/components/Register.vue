<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-sm p-6 bg-white rounded-2xl shadow-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700">Register</h2>

            <form @submit.prevent="handleRegister" class="mt-6 space-y-4">
                <div>
                    <input
                        v-model="name"
                        type="text"
                        placeholder="Name"
                        class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    />
                    <p v-if="errors.name" class="text-red-500 text-sm mt-1">
                        {{ errors.name[0] }}
                    </p>
                </div>

                <div>
                    <input
                        v-model="email"
                        type="text"
                        placeholder="Email"
                        
                        class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    />
                    <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</p>
                </div>

                <div>
                    <input
                        v-model="password"
                        type="password"
                        placeholder="Password"
                        
                        class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    />
                    <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password[0] }}</p>
                </div>

                <div>
                    <input
                        v-model="password_confirmation"
                        type="password"
                        placeholder="Confirm Password"
                        
                        class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    />
                    <p v-if="errors.password_confirmation" class="text-red-500 text-sm mt-1">
                        {{ errors.password_confirmation[0] }}
                    </p>
                </div>

                <button
                    type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Register
                </button>
            </form>

            <p class="mt-4 text-sm text-center text-gray-600">
                Already have an account?
                <router-link to="/" class="text-blue-600 hover:underline">Login</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import { register } from "../services/authService";

export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            errors: {},
        };
    },
    methods: {
        async handleRegister() {
            try {
                this.errors = {}; // Clear previous errors
                await register({
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
                this.$router.push("/");
            } catch (error) {
                if (error.response?.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    alert("Registration failed!");
                }
            }
        },
    },
};
</script>
