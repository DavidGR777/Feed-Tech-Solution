<?php

    session_start();

    include 'conexion_be.php';

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



    $identificacion = $_SESSION['usuario'];
    $respuesta = $_POST['respuesta'];

    if( $respuesta == 'si' ){
        $query = mysqli_query($conexion, "DELETE FROM usuarios WHERE usuario = '$identificacion' ");
        echo '
            <script>
                alert("La cuenta ha sido eliminada con exito!");
                window.location = "../../index.html";
            </script>
        ';
        session_destroy();
        exit;

    }else if( $respuesta == 'no' ){
        echo '
            <script>
                alert("Piensalo bien. Si deseas eliminar la cuenta vuelve a intentarlo");
                window.location = "../bienvenida.php";
            </script>
        ';
        exit;
    }

    // Obtener el usuario de la sesión
    $usuario = $_SESSION['usuario'];

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);

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

  <main>
    <div class="contenedor__general">
            <!--Formulario para modificar datos-->
            <div class="contenedor__modificar">

                    <h2>Acualizar datos de cuenta</h2>
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
