document.addEventListener("DOMContentLoaded", function() {
  const auth = localStorage.getItem('auth');
  console.log('Valor de auth en localStorage:', auth);

//    if (!auth) {
//      window.location.href = 'login.html';
//       return; 
//     }

  console.log('Sesión válida. Cargando clientes...');
  fetchClients();
});

document.getElementById('search-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  searchClient(e);
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
      'Authorization': `Bearer ${localStorage.getItem('auth')}`
    }
  })
    .then(response => response.json())
    .then(data => {
      console.log("Datos de clientes:", data);
      const clientTable = document.getElementById("client-table");
      clientTable.innerHTML = ""; 
      
      data.forEach(client => {
        let row = `<tr>
          <td>${client.id}</td>
          <td>${client.name}</td>
          <td>${client.email}</td>
          <td><button onclick="viewClient(${client.id})">Ver</button></td>
        </tr>`;
        clientTable.innerHTML += row;
      });
    })
    .catch(error => {
      console.error("Error al obtener los clientes:", error);
    });
}

function viewClient(id) {
  fetch(`http://localhost:8000/api/clients/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('auth')}`
    }
  })
    .then(response => response.json())
    .then(client => {
      alert(`ID: ${client.id}\nNombre: ${client.name}\nEmail: ${client.email}`);
    })
    .catch(error => {
      console.error("Error al obtener el cliente:", error);
    });
}

function searchClient(event) {
  event.preventDefault();
  const name = document.getElementById("name").value.trim();
  fetchClients(name);
}
