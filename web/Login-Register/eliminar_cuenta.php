
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar cuenta - FeedTechSolution</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
    
</head>
<body>
    <main>
        <div class="contenedor__general">
            <div class="contenedor__modificar">
                <form action="php/eliminar_cuenta_be.php" method="POST" class="formulario__eliminar">
                    <h2>Eliminar cuenta</h2>
                    <p>¿Estás seguro de que deseas eliminar tu cuenta?</p>
                    <div class="opciones">
                        <input type="radio" id="si" name="respuesta" value="si">
                        <label for="si">Sí</label>
                        <input type="radio" id="no" name="respuesta" value="no">
                        <label for="no">No</label>
                    </div>
                    <button type="submit">Confirmar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
