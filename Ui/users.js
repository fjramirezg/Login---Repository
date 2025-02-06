document.addEventListener("DOMContentLoaded", function() {
  if (!sessionStorage.getItem('auth')) {
    window.location.href = 'index.html';
    return; 
}
    fetchClients();
});

function fetchClients(name = "") {
  let url = "http://localhost:8000/api/clients";
  if (name) {
    url += `?name=${encodeURIComponent(name)}`;
  }
  console.log("Consultando clientes en:", url);

  fetch(url)
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
  fetch(`http://localhost:8000/api/clients/${id}`)
    .then(response => response.json())
    .then(client => {
      alert(`ID: ${client.id}\nNombre: ${client.name}\nEmail: ${client.email}`);
    })
    .catch(error => {
      console.error("Error al obtener el cliente:", error);
    });
}

function searchClient() {
  const name = document.getElementById("search-input").value.trim();
  fetchClients(name);
}
