<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <link rel="stylesheet" href="../../assets/css/Mapa.css" />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <h2>Tablero</h2>
      <ul>
        <li><a href="Inicio.php">Mapa</a></li>
        <li><a href="Data.php">Tabla</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <div class="map-container">
        <?php
          require_once __DIR__ . '/../../model/forms.models.php';
          $db = (new Conexion())->conectar();
          $stmt = $db->query("SELECT DISTINCT MUNICIPIO FROM data_general ORDER BY MUNICIPIO ASC");
          $municipios = $stmt->fetchAll(PDO::FETCH_COLUMN);
        ?>
        <div id="map"></div>
        <div id="sidebar">
          <h3>Personas del municipio</h3>
          <div id="lista-personas">Selecciona un municipio...</div>
          <div style="margin-top: 10px;">
            <button id="ver-datos-btn" disabled>Ver datos</button>
          </div>
        </div>
      </div>
      <div class="filter-button">
        <form action="data.php" method="GET">
          <input type="hidden" name="municipio" value="otros">
          <button type="submit">Mostrar contactos fuera de Michoacán</button>
        </form>
      </div>
    </main>
  </div>
  <?php
    if (isset($_GET['municipio']) && $_GET['municipio'] === 'otros') {
        // Aquí haces la consulta para mostrar solo contactos que NO sean de Michoacán
    }
  ?>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="../../assets/js/mapa.js"></script>
</body>
</html>