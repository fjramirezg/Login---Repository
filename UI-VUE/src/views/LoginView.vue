<template>
  <div class="login-view">
    <LoginForm />
  </div>
</template>

<script setup>
import LoginForm from '../components/LoginForm'';
</script>

<style scoped>
.login-view {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
</style>