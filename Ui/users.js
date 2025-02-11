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

function fetchUsers(name = "") {
  let url = "http://localhost:8000/api/users";
  if (name) {
    url += `?name=${encodeURIComponent(name)}`;
  }
  console.log("Consultando usuarios  en:", url);
  
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
        
        data.forEach(users => {
          let row = `<tr>
            <td>${users.username}</td>
            <td>${users.email}</td>
            <td><button onclick="viewClient(${users.id})">Ver</button></td>
          </tr>`;
          userTable.innerHTML += row;
        });
      } else {
        console.log("No se encontraron usuarios.");
        alert(`No se encontraron usuarios con el nombre: ${username}`);
      }
    })
    .catch(error => {
      console.error("Error al obtener los usuarios:", error);
      alert("Error al obtener los usuarios Intenta nuevamente.");
    });
}

function searchUsers() {
  const name = document.getElementById("nameU").value.trim();
  
  if (!name) {
    alert("Por favor, ingresa un nombre para buscar.");
    return;
  }
  fetchUsers(name);
}


function viewUsers(id) {
  fetch(`http://localhost:8000/api/users/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
    .then(response => response.json())
    .then(data => {
      console.log("Detalles del cliente:", data);
    })
    .catch(error => {
      console.error("Error al obtener los detalles del cliente:", error);
      alert("Error al obtener los detalles del cliente.");
    });
}