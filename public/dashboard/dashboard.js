document.addEventListener('DOMContentLoaded', async () => {
    const token = localStorage.getItem('authToken');
    const userEmail = localStorage.getItem('userEmail');

    // Protección de ruta: Si no hay token, fuera.
    if (!token) {
        window.location.href = '/public/index.html';
        return;
    }

    document.getElementById('userDisplay').innerText = userEmail;

    //Cargar vuelos desde la API
    try {
        const response = await fetch('/vuelos', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });

        if (response.status === 401) {
            throw new Error("Sesión expirada");
        }

        const flights = await response.json();
        renderTable(flights);

    } catch (error) {
        console.error(error);
        alert("Error al cargar vuelos: " + error.message);
        localStorage.clear();
        window.location.href = 'index.html';
    }
});

function renderTable(flights) {
    const tbody = document.getElementById('flightsTable');
    const safe = value => value ?? '-';
    const formatPrice = value => value != null ? `$${value}` : '-';

    tbody.innerHTML = flights.map(f => `
        <tr>
            <td>${safe(f.numero)}</td>
            <td>${safe(f.aerolinea)}</td>
            <td>${safe(f.aeropuertoSalida)}</td>
            <td>${safe(f.aeropuertoLlegada)}</td>
            <td>${safe(f.fechaCompra)}</td>
            <td>${safe(f.fechaSalida)}</td>
            <td>${safe(f.fechaLlegada)}</td>
            <td>${safe(f.agenciaViajes)}</td>
            <td>${safe(f.avion)}</td>
            <td>${safe(f.cliente)}</td>
            <td>${safe(f.piloto)}</td>
            <td>${safe(f.puesto)}</td>
            <td>${safe(f.estado)}</td>
            <td>${formatPrice(f.valor)}</td>
            <td><button class="btn-delete" onclick="deleteFlight('${f.id}')">Eliminar</button></td>
        </tr>
    `).join('');
}

function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
        const r = Math.random() * 16 | 0;
        const v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

async function deleteFlight(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar este vuelo?')) {
        return;
    }

    const token = localStorage.getItem('authToken');

    try {
        const response = await fetch(`/vuelos/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            alert('Vuelo eliminado con éxito.');
            location.reload(); // Recargar para actualizar la tabla
        } else {
            const err = await response.json();
            throw new Error(err.error || 'Error al eliminar');
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
}

// Cerrar sesión
document.getElementById('logoutBtn').addEventListener('click', async () => {
    const token = localStorage.getItem('authToken');
    const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });
    localStorage.clear();
    window.location.href = '../index.html';
});

// Función para abrir/cerrar el modal
function toggleModal() {
    const modal = document.getElementById('vueloModal');
    modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
    modal.classList.toggle("active");

    document.body.style.overflow =
        modal.classList.contains("active") ? "hidden" : "auto";
}


// Escuchar el envío del formulario
document.getElementById('vueloForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const token = localStorage.getItem('authToken');
    const btn = e.target.querySelector('button');

    const nuevoVuelo = {
        id: generateUUID(),
        numero: document.getElementById('numero').value,
        aerolinea: document.getElementById('aerolinea').value,
        aeropuertoSalida: document.getElementById('aeropuertoSalida').value,
        aeropuertoLlegada: document.getElementById('aeropuertoLlegada').value,
        fechaCompra: document.getElementById('fechaCompra').value,
        fechaSalida: document.getElementById('fechaSalida').value,
        fechaLlegada: document.getElementById('fechaLlegada').value,
        agenciaViajes: document.getElementById('agenciaViajes').value,
        avion: document.getElementById('avion').value,
        cliente: document.getElementById('cliente').value,
        piloto: document.getElementById('piloto').value,
        puesto: document.getElementById('puesto').value,
        estado: document.getElementById('estado').value,
        valor: parseFloat(document.getElementById('valor').value)
    };

    btn.disabled = true;
    btn.innerText = "Guardando...";

    try {
        const response = await fetch('/vuelos', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(nuevoVuelo)
        });
        console.log("Respuesta al guardar vuelo:", response);
        if (response.ok) {
            alert("¡Vuelo registrado con éxito!");
            toggleModal();
            e.target.reset();
            location.reload(); // Recargamos para ver el nuevo vuelo en la tabla
        } else {
            const err = await response.json();
            throw new Error(err.error || "Error al guardar");
        }
    } catch (error) {
        alert("Error: " + error.message);
        console.error("Error al guardar vuelo:", error);
    } finally {
        btn.disabled = false;
        btn.innerText = "Guardar Vuelo";
    }
});