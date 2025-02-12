// Función para abrir el sidebar
function openNav() {
    document.getElementById("sidebar").style.width = "250px";
    document.getElementById("menu-toggle").style.display = "none";
}

// Función para cerrar el sidebar
function closeNav() {
    document.getElementById("sidebar").style.width = "0";
    document.getElementById("menu-toggle").style.display = "block";
}

// Función para mostrar/ocultar el dropdown
function toggleDropdown() {
    var dropdown = event.target.nextElementSibling;
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}
