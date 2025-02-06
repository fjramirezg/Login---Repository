
document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (response.ok) {

           // Si la autenticación fue exitosa -  Redirigir al usuario a la página de usuarios
            window.location.href = 'index.html';
                           
        } else {
            // Si hay un error de autenticación
            console.error('Error de login:', data);
            alert(data.message || 'Error al iniciar sesión');
        }

    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
});