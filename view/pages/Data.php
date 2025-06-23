<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tabla</title>
  <link rel="stylesheet" href="../../assets/css/table.css"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="sidebar-section">
        <h2>Tablero</h2>
        <ul>
          <li><a href="Inicio.php">Mapa</a></li>
          <li><a href="Data.php">Tabla</a></li>
        </ul>
      </div>
    </aside>

    <main class="main-content">
      <div class="container-button">
        <div class="filter-button">
          <button id="open-add-modal" title="Agregar Contacto" style="background-image: url('../../assets/img/icon/icon-adduser.svg'); 
                      background-size: 24px 24px; 
                      background-position: center; 
                      background-repeat: no-repeat;
                      width: 38px;
                      height: 38px;"></button>
        </div>
        <div id="add-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title" class="modal" style="display: none;">
          <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Agregar Contacto</h2>
            <input type="text" id="add-name" placeholder="Nombre">
            <input type="text" id="add-phone" placeholder="Teléfono">
            <!-- Select para Municipio -->
            <select id="select-municipio" style="width: 100%;">
              <option value="" disabled selected>Selecciona un municipio</option>
              <option>Acuitzio</option>
              <option>Aguililla</option>
              <option>Álvaro Obregón</option>
              <option>Angamacutiro</option>
              <option>Angangueo</option>
              <option>Apatzingán</option>
              <option>Aporo</option>
              <option>Aquila</option>
              <option>Ario</option>
              <option>Arteaga</option>
              <option>Briseñas</option>
              <option>Buenavista</option>
              <option>Carácuaro</option>
              <option>Coahuayana</option>
              <option>Coalcomán de Vázquez Pallares</option>
              <option>Coeneo</option>
              <option>Contepec</option>
              <option>Copándaro</option>
              <option>Cotija</option>
              <option>Cuitzeo</option>
              <option>Charapan</option>
              <option>Charo</option>
              <option>Chavinda</option>
              <option>Cherán</option>
              <option>Chilchota</option>
              <option>Chinicuila</option>
              <option>Chucándiro</option>
              <option>Churintzio</option>
              <option>Churumuco</option>
              <option>Ecuandureo</option>
              <option>Epitacio Huerta</option>
              <option>Erongarícuaro</option>
              <option>Gabriel Zamora</option>
              <option>Hidalgo</option>
              <option>La Huacana</option>
              <option>Huandacareo</option>
              <option>Huaniqueo</option>
              <option>Huetamo</option>
              <option>Huiramba</option>
              <option>Indaparapeo</option>
              <option>Irimbo</option>
              <option>Ixtlán</option>
              <option>Jacona</option>
              <option>Jiménez</option>
              <option>Jiquilpan</option>
              <option>Juárez</option>
              <option>Jungapeo</option>
              <option>Lagunillas</option>
              <option>Madero</option>
              <option>Maravatío</option>
              <option>Marcos Castellanos</option>
              <option>Lázaro Cárdenas</option>
              <option>Morelia</option>
              <option>Morelos</option>
              <option>Múgica</option>
              <option>Nahuatzen</option>
              <option>Nocupétaro</option>
              <option>Nuevo Parangaricutiro</option>
              <option>Nuevo Urecho</option>
              <option>Numarán</option>
              <option>Ocampo</option>
              <option>Pajacuarán</option>
              <option>Panindícuaro</option>
              <option>Parácuaro</option>
              <option>Paracho</option>
              <option>Pátzcuaro</option>
              <option>Penjamillo</option>
              <option>Peribán</option>
              <option>La Piedad</option>
              <option>Purépero</option>
              <option>Puruándiro</option>
              <option>Queréndaro</option>
              <option>Quiroga</option>
              <option>Cojumatlán de Régules</option>
              <option>Los Reyes</option>
              <option>Sahuayo</option>
              <option>San Lucas</option>
              <option>Santa Ana Maya</option>
              <option>Salvador Escalante</option>
              <option>Senguio</option>
              <option>Susupuato</option>
              <option>Tacámbaro</option>
              <option>Tancítaro</option>
              <option>Tangamandapio</option>
              <option>Tangancícuaro</option>
              <option>Tanhuato</option>
              <option>Taretan</option>
              <option>Tarímbaro</option>
              <option>Tepalcatepec</option>
              <option>Tingambato</option>
              <option>Tingüindín</option>
              <option>Tiquicheo de Nicolás Romero</option>
              <option>Tlalpujahua</option>
              <option>Tlazazalca</option>
              <option>Tocumbo</option>
              <option>Tumbiscatío</option>
              <option>Turicato</option>
              <option>Tuxpan</option>
              <option>Tuzantla</option>
              <option>Tzintzuntzan</option>
              <option>Tzitzio</option>
              <option>Uruapan</option>
              <option>Venustiano Carranza</option>
              <option>Villamar</option>
              <option>Vista Hermosa</option>
              <option>Yurécuaro</option>
              <option>Zacapu</option>
              <option>Zamora</option>
              <option>Zináparo</option>
              <option>Zinapécuaro</option>
              <option>Ziracuaretiro</option>
              <option>Zitácuaro</option>
              <option>José Sixto Verduzco</option>
              <option>Otro</option>
            </select> 
            <input type="text" id="add-persona" placeholder="Persona de Contacto">
            <input type="text" id="add-domicilio" placeholder="Domicilio">
            <!-- Select para Distrito -->
            <select id="add-distrito">
              <option value="" disabled selected>Selecciona un distrito</option>
              <option value="Distrito 1">Distrito 1</option>
              <option value="Distrito 2">Distrito 2</option>
              <option value="Distrito 3">Distrito 3</option>
              <option value="Distrito 4">Distrito 4</option>
              <option value="Distrito 5">Distrito 5</option>
              <option value="Distrito 6">Distrito 6</option>
              <option value="Distrito 7">Distrito 7</option>
              <option value="Distrito 8">Distrito 8</option>
              <option value="Distrito 9">Distrito 9</option>
              <option value="Distrito 10">Distrito 10</option>
              <option value="Distrito 11">Distrito 11</option>
              <option value="Distrito 12">Distrito 12</option>
              <option value="Otro">Otro</option>
            </select>
            <input type="text" id="add-redes" placeholder="Redes Sociales">
            <input type="text" id="add-ocupacion" placeholder="Ocupación">
            <input type="text" id="add-seccion" placeholder="Sección Electoral">
            <!-- Select para Distrito -->
            <select id="add-clasificacion">
              <option value="" disabled selected>Selecciona un sector</option>
              <option value="SCJE">SCJE</option>
              <option value="EQUIPO">EQUIPO</option>
              <option value="AMIGOS">AMIGOS</option>
              <option value="FUNCIONARIOS PUBLICOS">FUNCIONARIOS PUBLICOS</option>
              <option value="COMUNIDAD JURIDICA">COMUNIDAD JURIDICA</option>
              <option value="SECTOR ESTUDIANTIL">SECTOR ESTUDIANTIL</option>
              <option value="SECTOR EMPRESARIAL">SECTOR EMPRESARIAL</option>
              <option value="OPERADORES">OPERADORES</option>
              <option value="MEDIOS DE COMUNICACION">MEDIOS DE COMUNICACION</option>
              <option value="JUDICATIVA">JUDICATIVA</option>
              <option value="AMTRIJA">AMTRIJA</option>
            </select>
            <div id="add-feedback" class="feedback-message"></div>
            <div class="filter-button"><button id="confirm-add">Agregar</button></div>
          </div>
        </div>
        <div class="filter-button">
          <button id="open-delete-modal" title="Eliminar Contacto" style="background-image: url('../../assets/img/icon/icon-deleteuser.svg'); 
                      background-size: 24px 24px; 
                      background-position: center; 
                      background-repeat: no-repeat;
                      width: 38px;
                      height: 38px;"></button>
        </div>
        <div id="delete-modal" class="modal" style="display: none;">
          <div class="modal-overlay"></div>
          <div class="modal-content">
          <button class="close-modal" id="close-modal">&times;</button>
          <p>Buscar contacto para eliminar:</p>
          <select id="delete-contact" class="select2" style="width: 100%;"></select>
          <div class="modal-actions">
            <button class="cancel-btn" id="cancel-delete">Cancelar</button>
            <button class="delete-btn" id="confirm-delete">Eliminar</button>
          </div>
          <div id="contacto-preview" style="margin-top: 1rem; display: none;">
            <h3>Detalles del contacto</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Municipio</th>
                  <th>Ocupación</th>
                  <th>Clasificación</th>
                </tr>
              </thead>
              <tbody id="preview-body"></tbody>
            </table>
          </div>
          </div>
        </div>
        <div class="filter-button">
            <input type="file" id="csv-file" accept=".csv" style="display: none;">
            <button id="cargar-csv" title="Cargar Csv" style="background-image: url('../../assets/img/icon/icon-cargar.svg'); 
                      background-size: 24px 24px; 
                      background-position: center; 
                      background-repeat: no-repeat;
                      width: 38px;
                      height: 38px;"></button>
        </div>
        <div class="filter-button">
          <a href="https://drive.google.com/file/d/1g79iIki59qggtrBH6WNE4LgMI0e2I67z/view?usp=drive_link" download="Plantilla-Carga-de-contactos.csv"><button id="descargar-plantilla" title="Descargar CSV" style="background-image: url('../../assets/img/icon/icon-plantilla.svg'); 
                      background-size: 24px 24px; 
                      background-position: center; 
                      background-repeat: no-repeat;
                      width: 38px;
                      height: 38px;"></button></a>
        </div>
      </div>
      <div class="filtros">      
        <div class="buscador">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#666" stroke-width="2" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
          </svg>
          <label for="buscar" class="form-label">Buscar</label>
          <input type="text" class="form-control" id="buscar" name="buscar" value="<?php echo isset($_POST["buscar"]) ? $_POST["buscar"] : ''; ?>">
        </div>
        <div id="open-filter-modal" class="filtro">
          <div class="filter-button">
            <button id="open-filter-modal" title="Filtrar"
              style="background-image: url('../../assets/img/icon/icon-filtro.svg'); 
                background-size: 24px 24px; 
                background-position: center; 
                background-repeat: no-repeat;
                width: 38px;
                height: 38px;">
            </button>
          </div>  
        </div>
        <div id="filter-modal" class="modal" style="display: none;">
          <div class="modal-overlay"></div>
            <div class="modal-content">
              <button class="close-modal" style="float: right;">&times;</button>
              <h3>Filtros</h3>
              <table>
                <thead>
                  <tr class="filters">
                    <th>
                      Distrito
                      <select id="buscardistrito" name="buscardistrito" class="form-control mt-2">
                        <option value="All">Seleciona el distrito</option>
                        <option value="Distrito 1">Distrito 1</option>
                        <option value="Distrito 2">Distrito 2</option>
                        <option value="Distrito 3">Distrito 3</option>
                        <option value="Distrito 4">Distrito 4</option>
                        <option value="Distrito 5">Distrito 5</option>
                        <option value="Distrito 6">Distrito 6</option>
                        <option value="Distrito 7">Distrito 7</option>
                        <option value="Distrito 8">Distrito 8</option>
                        <option value="Distrito 9">Distrito 9</option>
                        <option value="Distrito 10">Distrito 10</option>
                        <option value="Distrito 11">Distrito 11</option>
                        <option value="Distrito 12">Distrito 12</option>
                        <option value="Otro">Otro</option>
                      </select>
                    </th>
                    <th>
                      Sector
                      <select id="buscarclacificacion" name="buscarclacificacion" class="form-control mt-2">
                        <option value="All">Seleciona el sector</option>
                        <option value="SCJE">SCJE</option>
                        <option value="EQUIPO">EQUIPO</option>
                        <option value="AMIGOS">AMIGOS</option>
                        <option value="FUNCIONARIOS PUBLICOS">FUNCIONARIOS PUBLICOS</option>
                        <option value="COMUNIDAD JURIDICA">COMUNIDAD JURIDICA</option>
                        <option value="SECTOR ESTUDIANTIL">SECTOR ESTUDIANTIL</option>
                        <option value="SECTOR EMPRESARIAL">SECTOR EMPRESARIAL</option>
                        <option value="OPERADORES">OPERADORES</option>
                        <option value="MEDIOS DE COMUNICACION">MEDIOS DE COMUNICACION</option>
                        <option value="JUDICATIVA">JUDICATIVA</option>
                        <option value="AMTRIJA">AMTRIJA</option>
                      </select>
                    </th>
                  </tr>
                </thead>
              </table>
              <div style="margin-top: 1rem; display: flex; justify-content: flex-end; gap: 10px;">
                <button id="clear-filters" class="btn btn-secondary">Limpiar Filtros</button>
              </div>
          </div>
        </div>
      </div>
        <div class="table-responsive">
        <table id="datatab" class="tab">
          <thead>
            <tr id="encabezados">
              <th>Nombre</th>
              <th>Domicilio</th>
              <th>Teléfono</th>
              <th>Ocupación</th>
              <th>Persona contacto</th>
              <th>Municipio</th>
              <th>Distrito</th>
              <th>Sector</th>
              <th>Sección electoral</th>
              <th>Redes Sociales</th>
            </tr>
          </thead>
          <tbody id="data-body">
            <!-- Aquí se agregarán los datos dinámicamente -->
          </tbody>
        </table>
        <div id="paginador"></div>
      <div class="container-button"></div>
    </main>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../assets/js/data.js"></script>
<script src="../../assets/js/table.js"></script>
</body>
</html>