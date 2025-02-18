<template>
  <main>
    <div class="form-login-box">
      <h2 class="title">Login</h2>
      <form @submit.prevent="login">
        <label for="email">Email:</label>
        <input v-model="email" type="email" id="email" name="email" required />

        <label for="password">Password:</label>
        <input v-model="password" type="password" id="password" name="password" required />

        <button type="submit">Iniciar sesión</button>
      </form>
    </div>
  </main>
</template>

<script>
import { mapActions } from 'vuex';
import axios from '../service/axios.js';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    ...mapActions(['login']),
    async login() {
      try {
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password
        });

        if (response.data.token) {
          // Usar el store para manejar el estado de autenticación
          this.$store.dispatch('login', {
            user: response.data.user,
            token: response.data.token
          });

          // Redirigir al usuario a la página de inicio
          this.$router.push('/index');
        } else {
          alert('Error de login: ' + (response.data.message || 'Credenciales inválidas'));
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
      }
    }
  }
};
</script>

<style scoped src="@/assets/styles/login.css"></style>