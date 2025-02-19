<template>
  <form @submit.prevent="handleLogin">
    <label for="email">Email:</label>
    <input type="email" id="email" v-model="email" required />

    <label for="password">Password:</label>
    <input type="password" id="password" v-model="password" required />

    <button type="submit">Iniciar sesión</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const email = ref('');
const password = ref('');

const handleLogin = async () => {
  try {
    const response = await store.dispatch('login', {
      email: email.value,
      password: password.value,
    });
    if (response) {
      router.push('/');
    }
  } catch (error) {
    console.error('Error de login:', error);
    alert('Error al iniciar sesión');
  }
};
</script>

<style scoped>
</style>