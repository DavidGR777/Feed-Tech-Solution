<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir nueva ternera</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir nueva ternera</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-image: url('assets/images/fondo.png'); /* Ruta de la imagen de fondo */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centrar verticalmente */
            align-items: center; /* Centrar horizontalmente */
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background-color: white; /* Añade transparencia al fondo */
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 20px auto; /* Espacio entre el formulario y el borde de la página */
            box-sizing: border-box;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1CBF37; /* Color del título */
            font-size: 32px; /* Tamaño del título */
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px; /* Espacio entre los campos */
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #1CBF37; /* Color del botón */
            color: #fff; /* Color del texto del botón */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Transición al pasar el cursor */
        }

        .form-group button:hover {
            background-color: #128b26; /* Color de fondo al pasar el cursor */
        }
    </style>
</head> 
<body>
    <div class="form-container">
        <h2>Añadir nueva ternera</h2>
        <form action="php/nueva_ternera_be.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="text" id="edad" name="edad" required>
            </div>
            <div class="form-group">
                <label for="peso">Peso:</label>
                <input type="text" id="peso" name="peso" required>
            </div>
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="rfid">RFID:</label>
                <input type="text" id="rfid" name="rfid" required>
            </div>
            <div class="form-group">
                <label for="volumen">Volumen:</label>
                <input type="text" id="volumen" name="volumen" required>
            </div>
            <div class="form-group">
                <button type="submit">Agregar ternera</button>
            </div>
        </form>
    </div>
</body>
</html>
