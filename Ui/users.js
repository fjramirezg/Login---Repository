document.addEventListener("DOMContentLoaded", function() {
  const token = localStorage.getItem('token');

  if (!token) {
    window.location.href = 'login.html';
    return; 
  }

  console.log('Sesión válida. Cargando clientes...');
  fetchClients(); 
});

document.getElementById('search-form').addEventListener('submit', function(e) {
  e.preventDefault();
  searchClient();  
});

function fetchClients(name = "") {
  let url = "http://localhost:8000/api/clients";
  if (name) {
    url += `?name=${encodeURIComponent(name)}`;
  }
  console.log("Consultando clientes en:", url);
  
  fetch(url, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
    .then(response => response.json())
    .then(data => {
      const clientTable = document.getElementById("client-table");
      clientTable.innerHTML = ""; 
      if (Array.isArray(data) && data.length > 0) {
        console.log("Datos de clientes:", data);
        
        data.forEach(client => {
          let row = `<tr>
            <td>${client.id}</td>
            <td>${client.name}</td>
            <td>${client.email}</td>
            <td>${client.phone}</td>
            <td>${client.address}</td>
            <td><button onclick="viewClient(${client.id})">Ver</button></td>
          </tr>`;
          clientTable.innerHTML += row;
        });
      } else {
        console.log("No se encontraron clientes.");
        alert(`No se encontraron clientes con el nombre: ${name}`);
      }
    })
    .catch(error => {
      console.error("Error al obtener los clientes:", error);
      alert("Error al obtener los clientes. Intenta nuevamente.");
    });
}

function searchClient() {
  const name = document.getElementById("name").value.trim();
  
  if (!name) {
    alert("Por favor, ingresa un nombre para buscar.");
    return;
  }

  fetchClients(name);
}

function viewClient(id) {
  fetch(`http://localhost:8000/api/clients/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
    .then(response => response.json())
    .then(data => {
      console.log("Detalles del cliente:", data);
      // Aquí puedes manejar la visualización de los detalles del cliente
    })
    .catch(error => {
      console.error("Error al obtener los detalles del cliente:", error);
      alert("Error al obtener los detalles del cliente.");
    });
}
