<?php
require_once(__DIR__ . '/conection.php');

class CsvModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }

    public function procesarCSV($fileTmpPath) {
        if (($handle = fopen($fileTmpPath, "r")) !== FALSE) {
            $firstRow = true;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }

                $NOMBRE = $this->conn->real_escape_string($data[0]);
                $TELEFONO = $this->conn->real_escape_string($data[1]);
                $MUNICIPIO = $this->conn->real_escape_string($data[2]);
                $PERSONACONTACTO = $this->conn->real_escape_string($data[3]);
                $DOMICILIO = $this->conn->real_escape_string($data[4]);
                $DISTRITO = $this->conn->real_escape_string($data[5]);
                $REDESSOCIALES = $this->conn->real_escape_string($data[6]);
                $OCUPACION = $this->conn->real_escape_string($data[7]);
                $SECCIONELECTORAL = $this->conn->real_escape_string($data[8]);
                $CLASIFICACIONID = $this->conn->real_escape_string($data[9]);

                $sql = "INSERT INTO data_general (
                            NOMBRE, TELEFONO, MUNICIPIO, PERSONACONTACTO, DOMICILIO,
                            DISTRITO, REDESSOCIALES, OCUPACION, SECCIONELECTORAL, CLASIFICACIONID
                        ) VALUES (
                            '$NOMBRE', '$TELEFONO', '$MUNICIPIO', '$PERSONACONTACTO', '$DOMICILIO',
                            '$DISTRITO', '$REDESSOCIALES', '$OCUPACION', '$SECCIONELECTORAL', '$CLASIFICACIONID'
                        )
                        ON DUPLICATE KEY UPDATE 
                            TELEFONO = '$TELEFONO',
                            MUNICIPIO = '$MUNICIPIO',
                            PERSONACONTACTO = '$PERSONACONTACTO',
                            DOMICILIO = '$DOMICILIO',
                            DISTRITO = '$DISTRITO',
                            REDESSOCIALES = '$REDESSOCIALES',
                            OCUPACION = '$OCUPACION',
                            SECCIONELECTORAL = '$SECCIONELECTORAL',
                            CLASIFICACIONID = '$CLASIFICACIONID'";

                if (!$this->conn->query($sql)) {
                    echo "Error al insertar: " . $this->conn->error . "<br>";
                }
            }

            fclose($handle);
            return "Archivo CSV cargado y procesado correctamente.";
        } else {
            return "No se pudo abrir el archivo.";
        }
    }
}

// Esta parte puede ir en otro archivo como cargar_csv.php
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
    $modelo = new CsvModel();
    echo $modelo->procesarCSV($_FILES['csvFile']['tmp_name']);
} else {
    echo "Error al subir el archivo.";
}
?>
