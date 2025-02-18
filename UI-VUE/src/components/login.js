import axios from '../service/axios.js';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password
        });

        if (response.data.token) {
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.user));

          this.$router.push('/dashboard');
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