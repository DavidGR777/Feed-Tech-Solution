<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datos de conexión a la base de datos
$servername = "sql106.infinityfree.com"; // Cambia esto si tu servidor de MySQL tiene un nombre diferente
$username = "if0_36284776";
$password = "Vacas2024";
$dbname = "if0_36284776_nueva_ternera";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar los datos del formulario
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$peso = $_POST['peso'];
$id = $_POST['id'];
$rfid = $_POST['rfid'];
$volumen = $_POST['volumen'];

// Insertar los datos en la base de datos
$sql = "INSERT INTO terneras (nombre, edad, peso, id, rfid, volumen) 
        VALUES ('$nombre', '$edad', '$peso', '$id', '$rfid', '$volumen')";

if ($conn->query($sql) === TRUE) {
        echo '
            <script>
                alert("Ternera agregada correctamente.");
                window.location = "../bienvenida.php";
            </script>
        ';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
