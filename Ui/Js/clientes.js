// =======================
// Funciones para Clientes
// =======================

// Verifica si hay un token de autenticación
document.addEventListener("DOMContentLoaded", function() {
  const token = localStorage.getItem('token');
  if (!token) {
    window.location.href = 'login.html';
    return; 
  }
  console.log('Sesión válida. Cargando clientes...');
  fetchClients(); 
});

// Intercepta el evento de envío del formulario 
document.getElementById('search-form-clientes').addEventListener('submit', function(e) {
  e.preventDefault();
  searchClient();  
});

// Realiza la petición fetch al servidor para obtener los datos de los clientes.
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
        <div class="action-buttons">
            <button class="btn-view" onclick="viewClient(${client.id})">Ver</button>
            <button class="btn-edit" onclick="editClient(${client.id})">Editar</button>
            <button class="btn-delete" onclick="deleteClient(${client.id})">Eliminar</button>
        </div>
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

// Obtiene el nombre ingresado en el formulario de búsqueda
function searchClient() {
  const name = document.getElementById("name-clientes").value.trim();
  if (!name) {
    alert("Por favor, ingresa un nombre para buscar.");
    return;
  }
  fetchClients(name);
}

// Obtiene los detalles de un cliente específico
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

// Obtiene los datos de un cliente específico para permitir su edición
function editClient(id) {
  fetch(`http://localhost:8000/api/clients/${id}`, {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al obtener el cliente para editar.');
      }
      return response.json();
    })
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
            name: document.getElementById('swal-input1').value.trim(),
            email: document.getElementById('swal-input2').value.trim(),
            phone: document.getElementById('swal-input3').value.trim(),
            address: document.getElementById('swal-input4').value.trim(),
          };
        }
      }).then(result => {
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
            .then(response => {
              if (!response.ok) {
                throw new Error('Error al actualizar el cliente.');
              }
              return response.json();
            })
            .then(data => {
              Swal.fire('Actualizado!', 'El cliente ha sido actualizado.', 'success');
              fetchClients(); 
            })
            .catch(error => {
              console.error('Error al actualizar el cliente:', error);
              Swal.fire('Error', 'No se pudo actualizar el cliente.', 'error');
            });
        }
      }).catch(error => {
        console.error('Error al mostrar la ventana de edición:', error);
        Swal.fire('Error', 'No se pudo editar el cliente.', 'error');
      });
    })
    .catch(error => {
      console.error('Error al obtener el cliente para editar:', error);
      Swal.fire('Error', 'No se pudo obtener el cliente.', 'error');
    });
}

// Función para eliminar un cliente
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
            Swal.fire('Eliminado!', 'El cliente ha sido eliminado.', 'success');
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

// Función para agregar cliente nuevo
function createClient() {
  Swal.fire({
    title: 'Crear nuevo cliente',
    html: `
      <input id="swal-input-name" class="swal2-input" placeholder="Nombre">
      <input id="swal-input-email" class="swal2-input" placeholder="Email">
      <input id="swal-input-phone" class="swal2-input" placeholder="Teléfono">
      <input id="swal-input-address" class="swal2-input" placeholder="Dirección">
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Crear',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
      const name = document.getElementById('swal-input-name').value.trim();
      const email = document.getElementById('swal-input-email').value.trim();
      const phone = document.getElementById('swal-input-phone').value.trim();
      const address = document.getElementById('swal-input-address').value.trim();
      
      if (!name || !email || !phone || !address) {
        Swal.showValidationMessage('Por favor, completa todos los campos requeridos.');
        return false;
      }
      
      return { name, email, phone, address };
    }
  }).then(result => {
    if (result.isConfirmed && result.value) {
      const newClient = result.value;
      fetch("http://localhost:8000/api/clients", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(newClient)
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => Promise.reject(err));
        }
        return response.json();
      })
      .then(data => {
        if (data.message === 'cliente registrado satisfactoriamente') {
          Swal.fire('Creado!', 'El cliente ha sido creado exitosamente.', 'success');
          fetchClients();  // Recargar la lista de clientes
        } else {
          Swal.fire('Error', 'Hubo un problema al crear el cliente.', 'error');
        }
      })
      .catch(error => {
        console.error('Error al crear el cliente:', error);
        Swal.fire('Error', 'No se pudo crear el cliente.', 'error');
      });
    }
  }).catch(error => {
    console.error('Error al mostrar el formulario de creación:', error);
    Swal.fire('Error', 'No se pudo mostrar el formulario de creación.', 'error');
  });
}
