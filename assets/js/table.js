let contactos = []; // almacenar datos una sola vez

function renderTable(data) {
  const tbody = document.getElementById('data-body');
  tbody.innerHTML = '';

  data.forEach(contacto => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${contacto.NOMBRE || ''}</td>
      <td>${contacto.DOMICILIO || ''}</td>
      <td>${contacto.TELEFONO || ''}</td>
      <td>${contacto.OCUPACION || ''}</td>
      <td>${contacto.PERSONACONTACTO || ''}</td>
      <td>${contacto.MUNICIPIO || ''}</td>
      <td>${contacto.DISTRITO || ''}</td>
      <td>${contacto.clasificacion || ''}</td>
      <td>${contacto.SECCIONELECTORAL || ''}</td>
      <td>${contacto.REDESSOCIALES || ''}</td>
    `;
    tbody.appendChild(row);
  });
}

function applyFilters() {
  const distritoFilter = document.getElementById('buscardistrito').value;
  const sectorFilter = document.getElementById('buscarclacificacion').value;

  const filtered = contactos.filter(c => {
    const distritoMatch = distritoFilter === 'All' || distritoFilter === '' || c.DISTRITO === distritoFilter;
    const sectorMatch = sectorFilter === 'All' || sectorFilter === '' || c.clasificacion === sectorFilter;
    return distritoMatch && sectorMatch;
  });

  renderTable(filtered);
}

// Solo un fetch para traer los datos y preparar todo
fetch('../../controller/table.controller.php') // ajusta ruta a tu archivo PHP que devuelve JSON
  .then(response => {
    if (!response.ok) throw new Error('Error HTTP ' + response.status);
    return response.json(); // usar directamente json() si tu backend devuelve JSON puro
  })
  .then(data => {
    contactos = data;
    renderTable(contactos);

    // Listeners para filtrar cuando cambian selects
    document.getElementById('buscardistrito').addEventListener('change', applyFilters);
    document.getElementById('buscarclacificacion').addEventListener('change', applyFilters);
  })
  .catch(err => console.error("Error de red o servidor:", err));

