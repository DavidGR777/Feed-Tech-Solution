
<?php

    //Protección de páginas para no entrar sin antes iniciar sesión
    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor debes inicar sesión");
                window.location = "CRUD.php";
            </script>
        ';
        session_destroy();
        die();
    }


?>


<!DOCTYPE hmtl>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar - FeedTechSolution</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/estilos.css">

</head> 

<body>
    <!--Etiqueta main para tener control como proyecto--> 
    <main>
    <div class="contenedor__general">
            <!--Formulario para modificar datos-->
            <div class="contenedor__modificar">
                <!--Formulario login-->
                <form action="php/modificar_cuenta_be.php" method="POST" class="formulario__modificar">

                    <h2>Actualizar datos de cuenta</h2>
                    <input type="text" placeholder="Nombre Completo" name="nombre_completo">
                    <input type="text" placeholder="Correo" name="correo">
                    <input type="text" placeholder="Usuario" name="usuario">
                    <input type="text" placeholder="Ciudad/municipio" name="ciudad_municipio">
                    <input type="password" placeholder="Contraseña" name="contrasena">
                    <button>Actualizar</button>

                </form>
            </div>
    </div>
    </main>

</body>
</html>