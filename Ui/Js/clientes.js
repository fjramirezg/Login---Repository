document.addEventListener("DOMContentLoaded", function() {
  const token = localStorage.getItem('token');

  if (!token) {
    window.location.href = 'login.html';
    return; 
  }

  console.log('Sesión válida. Cargando clientes...');
  fetchClients(); 
});

document.getElementById('search-form-clientes').addEventListener('submit', function(e) {
  e.preventDefault();
  searchClient();  
});

// Función para obtener y mostrar los clientes
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
            <td>
              <button onclick="viewClient(${client.id})">Ver</button>
              <button onclick="editClient(${client.id})">Editar</button>
              <button onclick="deleteClient(${client.id})">Eliminar</button>
            </td>
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
  const name = document.getElementById("name-clientes").value.trim();
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
      Swal.fire({
        title: 'Detalles del cliente',
        html: `
          <p><strong>ID:</strong> ${data.id}</p>
          <p><strong>Nombre:</strong> ${data.name}</p>
          <p><strong>Email:</strong> ${data.email}</p>
          <p><strong>Teléfono:</strong> ${data.phone}</p>
          <p><strong>Dirección:</strong> ${data.address}</p>
        `,
        icon: 'info'
      });
    })
    .catch(error => {
      console.error("Error al obtener los detalles del cliente:", error);
      Swal.fire('Error', 'No se pudo obtener los detalles del cliente.', 'error');
    });
}

function editClient(id) {
  fetch(`http://localhost:8000/api/clients/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
    .then(response => response.json())
    .then(cliente => {
      Swal.fire({
        title: 'Editar cliente',
        html: `
          <input id="swal-input1" class="swal2-input" placeholder="Nombre" value="${cliente.name}">
          <input id="swal-input2" class="swal2-input" placeholder="Email" value="${cliente.email}">
          <input id="swal-input3" class="swal2-input" placeholder="Teléfono" value="${cliente.phone}">
          <input id="swal-input4" class="swal2-input" placeholder="Dirección" value="${cliente.address}">
        `,
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
          return {
            name: document.getElementById('swal-input1').value,
            email: document.getElementById('swal-input2').value,
            phone: document.getElementById('swal-input3').value,
            address: document.getElementById('swal-input4').value,
          }
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const updatedData = result.value;
          fetch(`http://localhost:8000/api/clients/${id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(updatedData)
          })
            .then(response => response.json())
            .then(data => {
              Swal.fire('Actualizado!', 'El cliente ha sido actualizado.', 'success');
              fetchClients(); // Recargar clientes después de actualizar
            })
            .catch(error => {
              console.error('Error al actualizar el cliente:', error);
              Swal.fire('Error', 'No se pudo actualizar el cliente.', 'error');
            });
        }
      });
    })
    .catch(error => {
      console.error("Error al obtener el cliente para editar:", error);
      Swal.fire('Error', 'No se pudo obtener el cliente.', 'error');
    });
}

function deleteClient(id) {
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
      fetch(`http://localhost:8000/api/clients/${id}`, {
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
              'El cliente ha sido eliminado.',
              'success'
            );
            fetchClients(); // Recargar clientes después de eliminar
          } else {
            throw new Error('Error en la eliminación');
          }
        })
        .catch(error => {
          console.error('Error al eliminar el cliente:', error);
          Swal.fire('Error', 'No se pudo eliminar el cliente.', 'error');
        });
    }
  });
}
