<template>
    <form @submit.prevent="register">
        <div class="mx-auto w-1/2">
            <div>
                <label for="name" class="label">Your Name</label>
                <input type="text" id="name" v-model="form.name" class="input">
                <div v-if="form?.errors?.name" class="input-error">
                    {{ form.errors.name }}
                </div>
            </div>
            <div class="mt-4">
                <label for="email" class="label">E-Mail</label>
                <input type="text" id="email" v-model="form.email" class="input">
                <div v-if="form?.errors?.email" class="input-error">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input type="password" id="password" v-model="form.password" class="input">
                <div class="input-error" v-if="form.errors?.password">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label">Password confirmation </label>
                <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="input">
            </div>
            <div class="mt-4">
                <button class="w-full btn-primary" type="submit">Create Account</button>
                <div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-gray-500 text-sm">Or log in!</Link>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
})

const register = () => form.post(route('user-account.store'));

</script>

<style lang="scss" scoped></style>
