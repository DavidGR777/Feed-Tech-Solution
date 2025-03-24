<?php
// Protección de páginas para no entrar sin antes iniciar sesión
session_start();

if(!isset($_SESSION['usuario'])){
    echo '
        <script>
            alert("Por favor debes iniciar sesión");
            window.location = "CRUD.php";
        </script>
    ';
    session_destroy();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida - FeedTechSolution</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <style>
        :root{
        --red:#79f82a;
        --black:#252a34;
        --blue:#08d9d6;
        --white:#eaeaea;
        --title:35px;
        --text:19px;
        }
        *{
        margin:0;
        padding: 0;
        box-sizing: border-box;
        }
        body {
            margin: 0; /* Elimina el margen */
            padding: 0;
            font-family: 'Merriweather', sans-serif;
            overflow-x: hidden; /* Evita la barra de desplazamiento horizontal */
            background-color: #f0f0f0; /* Color de fondo sólido */
        }
        #header {
            background-color: #f0f0f0; /* Color de fondo para el encabezado */
            padding: 10px 0;
            position: relative;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0; /* Elimina el margen */
            padding: 0 20px; /* Agrega un poco de espacio a los lados */
        }

        .list-container ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
            display: flex;
        }
        .list-container ul li {
            margin-left: 20px;
        }
        .list-container ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .list-container ul li a:hover {
            color: #f8f9fa;
        }
        .contenedor__bienvenida {
            margin-top: 60px; /* Para dar espacio al encabezado fijo */
            text-align: center;
            padding: 20px;
        }
        .contenedor__bienvenida h1 {
            margin-bottom: 20px;
        }
        .contenedor__bienvenida h2 {
            margin-bottom: 30px;
        }
        .contenedor__bienvenida a {
            display: block;
            margin-bottom: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .contenedor__bienvenida a:hover {
            background-color: #0056b3;
        }
            .menu .logo-box{
            margin-left: 0px;
            text-align: left;
            }
        .menu .logo-box h1 a{
            text-decoration: none;
            font-size: var(--title);
            font-weight: 400;
            color:var(--black);
            margin: 0; /* Elimina el margen para evitar espacio adicional */
        }
        .menu .list-container {
            margin-right: 0; /* Elimina el margen derecho */
        }
        .menu .list-container ul{display: flex;}
        .menu .list-container ul li{list-style: none;}
        .menu .list-container ul li a{
            text-decoration: none;
            margin: 0px 10px;
            padding:8px;
            color: var(--black);
            border-radius: 24px;
            transition: 0.3s;
            font-size: 16px;
        }
        .menu .list-container ul li a.active{
            background: var(--red);
            color:#fff;
        }
        .menu .list-container ul li a:hover{
            background: var(--red);
            color:#fff;
        }

        .btn-menu > .fa-bars{
            display: none;
        }
    </style>
</head>
<body>

    <!-- Menu de Navegacion -->
    <header id="header">
    <nav class="menu">
     <div class="logo-box">
       <h1><a href="#">Feed Tech Solution</a></h1>
       <span class="btn-menu"><i class="fas fa-bars"></i></span>
     </div>
            <div class="list-container">
                <ul class="lists">
                    <li><a href="eliminar_cuenta.php">Eliminar cuenta</a></li>
                    <li><a href="modificar_cuenta.php">Modificar cuenta</a></li>
                    <li><a href="php/cerrar_sesion.php">Cerrar sesión</a></li>
                    <li><a href="nueva_ternera1.php">Añadir nueva ternera</a></li>
                </ul>
            </div>
        </div>
    </nav>
    </div>
    </header>

    <iframe id="dashboard-iframe" src="https://demo.thingsboard.io/dashboards/90b0bac0-1d5d-11ef-a435-ab3a1d535f3e" width="100%" height="600" frameborder="0"></iframe>
   <script>
    setInterval(function(){
        document.getElementById('dashboard-iframe').src = document.getElementById('dashboard-iframe').src;
    }, 60000); // Actualiza cada 60 segundos
    </script>



</body>
</html>


