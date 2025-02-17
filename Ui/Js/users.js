document.addEventListener("DOMContentLoaded", function() { 
  const token = localStorage.getItem('token');

  if (!token) {
    window.location.href = 'login.html';
    return; 
  }
  console.log('Sesión válida. Cargando Usuarios...');
  fetchUsers(); 
});

document.getElementById('search-form-users').addEventListener('submit', function(e) {
  e.preventDefault(); 
  searchUsers();  
});

// Función para obtener y mostrar los usuarios
function fetchUsers(name = "") {
  let url = "http://localhost:8000/api/users";
  if (name) {
    url += `?name=${encodeURIComponent(name)}`;
  }
  console.log("Consultando usuarios en:", url);
  
  fetch(url, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}` 
    }
  })
    .then(response => response.json()) 
    .then(data => {
      const userTable = document.getElementById("user-table");
      userTable.innerHTML = ""; 
      
      if (Array.isArray(data) && data.length > 0) {
        console.log("Datos de Usuarios:", data);
        
        data.forEach(user => {
          let row = `<tr>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>
              <button onclick="viewUsers(${user.id})">Ver</button>
              <button onclick="editUser(${user.id})">Editar</button>
              <button onclick="deleteUser(${user.id})">Eliminar</button>
            </td>
          </tr>`;
          userTable.innerHTML += row;
        });
      } else {
        console.log("No se encontraron usuarios.");
        alert(`No se encontraron usuarios con el nombre: ${name}`);
      }
    })
    .catch(error => {
      console.error("Error al obtener los usuarios:", error);
      alert("Error al obtener los usuarios. Intenta nuevamente.");
    });
}

// Función para buscar usuarios según el nombre ingresado
function searchUsers() {
  const username = document.getElementById("name-users").value.trim();
  if (!username) {
    alert("Por favor, ingresa un nombre para buscar.");
    return;
  }
  fetchUsers(username);
}

// Función para ver detalles del usuario (utilizando SweetAlert2)
function viewUsers(id) {
  fetch(`http://localhost:8000/api/users/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}` 
    }
  })
    .then(response => response.json()) 
    .then(data => {
      console.log("Detalles del usuario:", data);
      Swal.fire({
        title: 'Detalles del Usuario',
        html: `<p><strong>Username:</strong> ${data.username}</p>
               <p><strong>Email:</strong> ${data.email}</p>`,
        icon: 'info'
      });
    })
    .catch(error => {
      console.error("Error al obtener los detalles del usuario:", error);
      Swal.fire('Error', 'Error al obtener los detalles del usuario.', 'error');
    });
}

function editUser(id) {
  fetch(`http://localhost:8000/api/users/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
  .then(response => response.json())
  .then(user => {
    Swal.fire({
      title: 'Editar Usuario',
      html: `
        <input id="swal-input1" class="swal2-input" placeholder="Nombre" value="${user.username}">
        <input id="swal-input2" class="swal2-input" placeholder="Email" value="${user.email}">
        <input id="swal-input3" type="password" class="swal2-input" placeholder="Nueva Contraseña">
        <select id="swal-input4" class="swal2-input">
          <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
          <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
        </select>
      `,
      focusConfirm: false,
      showCancelButton: true,
      preConfirm: () => {
        const username = document.getElementById('swal-input1').value.trim();
        const email    = document.getElementById('swal-input2').value.trim();
        const password = document.getElementById('swal-input3').value.trim();
        const role     = document.getElementById('swal-input4').value;

        if (!username || !email || !role) {
          Swal.showValidationMessage('Todos los campos requeridos deben ser completados.');
          return false;
        }
        // Siempre enviar el role, aunque no se haya cambiado
        return { username, email, password, role };
      }
    }).then((result) => {
      if (result.isConfirmed && result.value) {
        fetch(`http://localhost:8000/api/users/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify(result.value)
        })
        .then(response => {
          if (!response.ok) {
            return response.json().then(error => Promise.reject(error));
          }
          return response.json();
        })
        .then(data => {
          Swal.fire('¡Actualizado!', 'El usuario ha sido actualizado.', 'success');
          fetchUsers(); 
        })
        .catch(error => {
          console.error('Error al actualizar el usuario:', error);
          let errorMessage = 'No se pudo actualizar el usuario.';
          if (error.message) {
            errorMessage += ` ${error.message}`;
          }
          Swal.fire('Error', errorMessage, 'error');
        });
      }
    });
  })
  .catch(error => {
    console.error("Error al obtener el usuario para editar:", error);
    Swal.fire('Error', 'No se pudo obtener el usuario.', 'error');
  });
}


// Función para eliminar un usuario utilizando SweetAlert2
function deleteUser(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Esta acción no se puede revertir.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminarlo!'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`http://localhost:8000/api/users/${id}`, {
        method: 'DELETE',
        headers: {
          'Accept': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}` 
        }
      })
      .then(response => {
        if (response.ok) {
          Swal.fire(
            'Eliminado!',
            'El usuario ha sido eliminado.',
            'success'
          );
          fetchUsers();
        } else {
          throw new Error('Error en la eliminación');
        }
      })
      .catch(error => {
        console.error('Error al eliminar el usuario:', error);
        Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
      });
    }
  });
}

// Función para crear un nuevo usuario
function createUser() {
  Swal.fire({
    title: 'Crear Usuario',
    html: `
      <input id="swal-input-name" class="swal2-input" placeholder="Nombre de usuario">
      <input id="swal-input-email" class="swal2-input" placeholder="Email">
      <input id="swal-input-password" type="password" class="swal2-input" placeholder="Contraseña">
      <select id="swal-input-role" class="swal2-input">
        <option value="admin">Admin</option>
        <option value="user" selected>User</option>
      </select>
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Crear',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
      const username = document.getElementById('swal-input-name').value.trim();
      const email    = document.getElementById('swal-input-email').value.trim();
      const password = document.getElementById('swal-input-password').value.trim();
      const role     = document.getElementById('swal-input-role').value;
      
      if (!username || !email || !password || !role) {
        Swal.showValidationMessage('Por favor, completa todos los campos requeridos.');
        return false; 
      }
      
      return { username, email, password, role };
    }
  }).then((result) => {
    if (result.isConfirmed && result.value) {
      fetch('http://localhost:8000/api/users', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(result.value)
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => Promise.reject(err));
        }
        return response.json();
      })
      .then(data => {
        Swal.fire('¡Creado!', 'El usuario se creó satisfactoriamente.', 'success');
        fetchUsers();
      })
      .catch(error => {
        console.error('Error al crear el usuario:', error);
        let errorMessage = 'No se pudo crear el usuario.';
        if (error.message) {
          errorMessage += ` ${error.message}`;
        }
        Swal.fire('Error', errorMessage, 'error');
      });
    }
  });
}

