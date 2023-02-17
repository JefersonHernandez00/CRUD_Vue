<?php

// Conexión a la base de datos utilizando la función mysqli_connect()
$conn = mysqli_connect('localhost', 'root', '', 'crud');

// Comprobación de si se estableció la conexión correctamente
if (!$conn) {
    die('Error de conexión: ' . mysqli_connect_error());
}

/**
 * Validación y sanitización de la variable $action
 * 
 * La variable $action es un parámetro GET que indica la acción que se debe realizar en la base de datos
 */
$action = isset($_GET['action']) ? $_GET['action'] : '';
if (!in_array($action, ['get_personas', 'create_persona', 'update_persona', 'delete_persona'])) {
    die('Acción no permitida');
}

// Si $action es 'get_personas', se seleccionan todas las filas de la tabla 'personas' y se devuelven como un objeto JSON
if ($action == 'get_personas') {
    /**
     * Aquí se ejecuta una consulta SQL para seleccionar todas las filas de la tabla 'personas' 
     * y se almacena el resultado en la variable $result.
     */
    $result = mysqli_query($conn, 'SELECT * FROM personas');
    $personas = [];
    /**
     * Se realiza un bucle para recuperar todas las filas recuperadas de la tabla 'personas' 
     * y se agregan al array $personas. La función mysqli_fetch_assoc() devuelve la fila actual en forma de array asociativo.
     */
    while ($row = mysqli_fetch_assoc($result)) {
        $personas[] = $row;
    }
    /**
     * El array $personas se codifica como JSON y se envía al cliente 
     * como respuesta de la solicitud HTTP.
     */
    echo json_encode($personas);
}
// Si $action es 'create_persona', se inserta una nueva fila en la tabla 'personas' con los valores proporcionados en $_POST
else if ($action == 'create_persona') {
    /**
     *  Obtenemos los datos enviados por el método POST en formato JSON y los decodificamos
     * Esto permite que los datos enviados en la solicitud puedan ser manipulados en el
     * script PHP como un objeto JSON en lugar de como una cadena de texto plano.
     */
    $_POST = json_decode(file_get_contents("php://input"), true);
    // Obtenemos los valores de las variables necesarias, utilizando operador ternario para validar si existen o no
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($conn, trim($_POST['nombre'])) : '';
    $apellido = isset($_POST['apellido']) ? mysqli_real_escape_string($conn, trim($_POST['apellido'])) : '';
    $no_identificacion = isset($_POST['no_identificacion']) ? mysqli_real_escape_string($conn, trim($_POST['no_identificacion'])) : '';
    $direccion = isset($_POST['direccion']) ? mysqli_real_escape_string($conn, trim($_POST['direccion'])) : '';

    // Verificamos si se tienen todos los datos necesarios para crear una nueva persona en la base de datos
    if ($nombre && $apellido && $no_identificacion && $direccion) {
        // Insertamos los datos en la tabla personas de la base de datos
        mysqli_query($conn, "INSERT INTO personas (nombre, apellido, no_identificacion, direccion) 
    VALUES ('$nombre', '$apellido', '$no_identificacion', '$direccion')");

        // Enviamos una respuesta JSON al cliente indicando el éxito de la operación
        echo json_encode(['status' => 'success']);
    } else {
        // Enviamos una respuesta JSON al cliente indicando que faltan datos
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos']);
    }
}
// Si $action es 'update_persona', se actualizan los datos
else if ($action == 'update_persona') {
    // Decodificar los datos recibidos en la solicitud
    $_POST = json_decode(file_get_contents("php://input"), true);

    // Recuperar los valores de los campos de la persona a actualizar y sanitizarlos
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($conn, trim($_POST['nombre'])) : '';
    $apellido = isset($_POST['apellido']) ? mysqli_real_escape_string($conn, trim($_POST['apellido'])) : '';
    $no_identificacion = isset($_POST['no_identificacion']) ? mysqli_real_escape_string($conn, trim($_POST['no_identificacion'])) : '';
    $direccion = isset($_POST['direccion']) ? mysqli_real_escape_string($conn, trim($_POST['direccion'])) : '';

    // Verificar si se recibieron los valores necesarios para actualizar la persona
    if ($id && $nombre && $apellido && $no_identificacion && $direccion) {
        // Ejecutar la consulta SQL para actualizar la persona en la base de datos
        mysqli_query($conn, "UPDATE personas 
        SET nombre = '$nombre', apellido = '$apellido', no_identificacion = '$no_identificacion', direccion = '$direccion' 
        WHERE id = $id");
        // Devolver una respuesta con estado "success"
        echo json_encode(['status' => 'success']);
    } else {
        // Devolver una respuesta con estado "error" y un mensaje indicando que faltan datos
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos']);
    }
}
// Si $action es 'delete_persona', se elimna la persona
else if ($action == 'delete_persona') {
    // Decodificar los datos recibidos en la solicitud
    $_POST = json_decode(file_get_contents("php://input"), true);

    // Recuperar el ID de la persona a eliminar y sanitizarlo
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    // Verificar si se recibió el ID de la persona a eliminar
    if ($id) {
        // Ejecutar la consulta SQL para eliminar la persona de la base de datos
        mysqli_query($conn, "DELETE FROM personas WHERE id = $id");
        // Devolver una respuesta con estado "success"
        echo json_encode(['status' => 'success']);
    } else {
        // Devolver una respuesta con estado "error" y un mensaje indicando que falta el ID
        echo json_encode(['status' => 'error', 'message' => 'Falta el ID']);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
