       function searchRoles() {
                  
           fetch('http://localhost:8000/api/clients/${rol} ', {
                method: 'GET',
                headers: { 
                 'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}` 
                }
            })
            .then(response => response.json())
            .then(data => {
                const userRole = data.role;
    
                if (userRole === 'admin') {
                    document.getElementById('client-table');
                    document.getElementById('user-table');
                } else if (userRole === 'user') {
                    document.getElementById('user-table').style.display = 'block';
                } else {
                    alert('No tienes permisos para ver esta sección.');
                }
            })
            .catch(error => {
                console.error('Error fetching user role:', error);
                alert('Error al obtener el rol del usuario.');
            });
       }
