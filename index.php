<?php
require "./inc/session_start.php";
require "./php/main.php"; // Incluye el archivo con la función de conexión

// Inicializa la variable del rol
$rol_id = null;

// Verifica si hay una sesión activa y obtiene el rol del usuario
if (isset($_SESSION['id'])) {
    // Llama a la función de conexión
    $conexion = conexion();

    // Prepara y ejecuta la consulta para obtener el rol del usuario
    $stmt = $conexion->prepare("SELECT rol_id FROM usuario WHERE usuario_id = ?");
    $stmt->execute([$_SESSION['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $rol_id = $result ? $result['rol_id'] : null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Incluye el archivo de encabezado que contiene metaetiquetas, títulos y enlaces a CSS -->
    <?php include "./inc/head.php"; ?>
</head>
<body>
    <?php
        // Verifica si el parámetro 'vista' está presente en la URL y no está vacío
        if (!isset($_GET['vista']) || $_GET['vista'] == "") {
            $_GET['vista'] = "login";
        }

        // Verifica si el archivo correspondiente a la vista solicitada existe y no es 'login' ni '404'
        if (is_file("./vistas/" . $_GET['vista'] . ".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404") {
            // Verifica si la sesión está activa
            if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
                include "./vistas/logout.php";
                exit();
            }

            // Incluye el archivo de navegación según el rol del usuario
            switch ($rol_id) {
                case 1:
                    include "./inc/navbar.php";
                    break;
                case 2:
                    include "./inc/navbar_op_inventario.php";
                    break;
                case 3:
                    include "./inc/navbar_op.php";
                    break;
                default:
                    // No se incluye ninguna barra de navegación si el rol no coincide
                    break;
            }

            // Incluye el archivo de la vista solicitada
            include "./vistas/" . $_GET['vista'] . ".php";

            // Incluye el archivo de scripts que contiene JavaScript para funcionalidades adicionales
            include "./inc/script.php";

        } else {
            // Si la vista es 'login', incluye el archivo de login
            if ($_GET['vista'] == "login") {
                include "./vistas/login.php";
            } else {
                // Para cualquier otra vista no válida, incluye el archivo de error 404
                include "./vistas/404.php";
            }
        }
    ?>
</body>
</html>
