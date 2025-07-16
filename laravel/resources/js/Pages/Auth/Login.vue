<template>
    <form @submit.prevent="login">
        <div class="mx-auto w-1/2">
            <div>
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
                <button class="w-full btn-primary" type="submit">Login</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
const form = useForm({
    email: null,
    password: null
})

const login = () => form.post(route('login.store'));

</script>

<style lang="scss" scoped></style>
