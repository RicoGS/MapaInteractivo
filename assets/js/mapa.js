// Inicializar el mapa
const map = L.map('map', {
    zoomControl: false,
    dragging: false,
    scrollWheelZoom: false,
    doubleClickZoom: false,
    boxZoom: false,
    keyboard: false,
    attributionControl: false
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'OpenStreetMap contributors'
}).addTo(map);

// Cargar municipios desde GeoJSON
fetch('../../assets/zone/michoacan.geojson')
    .then(res => res.json())
    .then(data => {
        const geo = L.geoJSON(data, {
            style: {
                fillColor: '#f794b1',
                weight: 1,
                color: '#640b25',
                fillOpacity: 0.7
            },
            onEachFeature: (feature, layer) => {
                layer.on({
                    click: () => {
                        obtenerDatosMunicipio(feature.properties.NOMGEO);
                    },
                    mouseover: (e) => {
                        e.target.setStyle({
                            fillColor: '#9c1f43', // Color al hacer hover
                            weight: 2,
                            color: '#f794b1',
                            fillOpacity: 1
                        });
                        e.target.bringToFront(); // Asegura que se vea encima
                    },
                    mouseout: (e) => {
                        geo.resetStyle(e.target); // Restaura estilo original
                    }
                });

                layer.bindTooltip(feature.properties.NOMGEO || "Municipio");
            }
        }).addTo(map);

        map.fitBounds(geo.getBounds());
        map.setMaxBounds(geo.getBounds());

        // Máscara alrededor del estado
        let holes = [];
        data.features.forEach(feature => {
            const geom = feature.geometry;
            if (geom.type === 'Polygon') {
                geom.coordinates.forEach(ring => {
                    holes.push(ring.map(([lng, lat]) => [lat, lng]));
                });
            } else if (geom.type === 'MultiPolygon') {
                geom.coordinates.forEach(polygon => {
                    polygon.forEach(ring => {
                        holes.push(ring.map(([lng, lat]) => [lat, lng]));
                    });
                });
            }
        });

        const world = [
            [-90, -180], [-90, 180], [90, 180], [90, -180]
        ];

        L.polygon([world, ...holes], {
            color: '#fff',
            fillColor: '#fff',
            fillOpacity: 1,
            stroke: false
        }).addTo(map);
    })
    .catch(err => console.error("Error al cargar municipios:", err));

        document.getElementById('ver-datos-btn').addEventListener('click', function () {
        const municipio = this.getAttribute('data-municipio');
        if (municipio) {
            window.location.href = `Data.php?municipio=${encodeURIComponent(municipio)}`;
        }
    });

// Función para obtener datos del municipio
function obtenerDatosMunicipio(municipio) {
    const contenedor = document.getElementById('lista-personas');
    contenedor.innerHTML = `<h3>${municipio}</h3><p>Cargando datos...</p>`;

    // Habilitar botón y guardar municipio
    const boton = document.getElementById('ver-datos-btn');
    boton.disabled = false;
    boton.setAttribute('data-municipio', municipio);

    fetch(`../../controller/municipio.controller.php?municipio=${encodeURIComponent(municipio)}`)
        .then(response => response.json())
        .then(data => {
            if (!data.length) {
                contenedor.innerHTML = `<h3>${municipio}</h3><p>No se encontraron registros.</p>`;
                return;
            }

            contenedor.innerHTML = `<h3>${municipio}</h3>`;
            data.forEach(p => {
                const div = document.createElement('div');
                div.classList.add('persona');
                div.style.borderBottom = '1px solid #ccc';
                div.style.padding = '8px 0';

                div.innerHTML = `
                    <strong>${p.NOMBRE}</strong><br>
                    Tel: ${p.TELEFONO}<br>
                    Contacto: ${p.PERSONACONTACTO}<br>
                    Domicilio: ${p.DOMICILIO}<br>
                    Distrito: ${p.DISTRITO}<br>
                    Redes: ${p.REDESSOCIALES}<br>
                    Ocupación: ${p.OCUPACION}<br>
                    Sección: ${p.SECCIONELECTORAL}<br>
                    Clasificación: ${p.CLASIFICACIONID}
                `;
                contenedor.appendChild(div);
            });
        })
        .catch(error => {
            contenedor.innerHTML = `<h3>${municipio}</h3><p>Error al obtener los datos.</p>`;
            console.error("Error en la consulta:", error);
        });
}

