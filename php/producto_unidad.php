<?php
// Incluir archivo de sesión (asegúrate de que esta línea esté en el archivo adecuado, si es necesario)
require_once "../inc/session_start.php";

// Incluir el archivo de barra de navegación
include "../inc/navbar.php";

// Ejemplo de datos para productos (normalmente, esto vendría de una base de datos)
$productos = [
    [
        'id' => 1,
        'nombre' => 'Producto A',
        'caracteristicas' => 'Característica 1, Característica 2',
        'estado' => 'activo',
        'fallas' => 'Ninguna'
    ],
    [
        'id' => 2,
        'nombre' => 'Producto B',
        'caracteristicas' => 'Característica 3, Característica 4',
        'estado' => 'inactivo',
        'fallas' => 'Falla menor'
    ],
    // Agrega más productos según sea necesario
];

// Simular paginación
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$registros = 10; // Número de registros por página
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$total = count($productos); // Total de productos
$Npaginas = ceil($total / $registros);

// Cortar los datos para la página actual
$productos = array_slice($productos, $inicio, $registros);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Producto Unidad</title>
    <!-- Incluye el archivo de estilos CSS específico para este archivo -->
    <link rel="stylesheet" href="../css/producto_unidad.css">
    <!-- Incluye los estilos CSS globales o cualquier otro necesario -->
    <link rel="stylesheet" href="../css/global.css">
    <!-- Incluye cualquier otro archivo CSS que necesites -->
</head>
<body>
    <!-- Incluye el navbar -->
    <?php include "../inc/navbar.php"; ?>

    <div class="container">
        <h1>Detalles del Producto</h1>
        <!-- Aquí va el contenido específico de producto_unidad.php -->
    </div>

    <!-- Contenido de la página -->
    <div class="container">
        <h1>Lista de Productos</h1>
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                     
                        <th>Estado</th>
                        <th>Fallas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr class="has-text-centered">
                                <td><?php echo $producto['id']; ?></td>
                                <td><?php echo $producto['nombre']; ?></td>
                                <td><?php echo $producto['caracteristicas']; ?></td>
                                <td class="<?php echo $producto['estado'] === 'activo' ? 'estado-activo' : 'estado-inactivo'; ?>">
                                    <?php echo $producto['estado']; ?>
                                </td>
                                <td><?php echo $producto['fallas']; ?></td>
                                <td>
                                    <a href="ver_producto.php?id=<?php echo $producto['id']; ?>" class="button is-link is-rounded is-small">Ver</a>
                                    <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="button is-success is-rounded is-small">Editar</a>
                                    <a href="eliminar_producto.php?id=<?php echo $producto['id']; ?>" class="button is-danger is-rounded is-small">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="has-text-centered">
                            <td colspan="6">No hay registros en el sistema</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Muestra el rango de productos que se están mostrando -->
        <?php if ($total > 0): ?>
            <p class="has-text-right">
                Mostrando productos <strong><?php echo $inicio + 1; ?></strong> al <strong><?php echo min($inicio + $registros, $total); ?></strong> de un <strong>total de <?php echo $total; ?></strong>
            </p>
        <?php endif; ?>

        <!-- Paginador -->
        <?php if ($total > $registros): ?>
            <nav class="pagination" role="navigation" aria-label="pagination">
                <ul class="pagination-list">
                    <?php if ($pagina > 1): ?>
                        <li><a href="?pagina=<?php echo $pagina - 1; ?>" class="pagination-link">Anterior</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $Npaginas; $i++): ?>
                        <li>
                            <a href="?pagina=<?php echo $i; ?>" class="pagination-link <?php echo $i == $pagina ? 'is-current' : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($pagina < $Npaginas): ?>
                        <li><a href="?pagina=<?php echo $pagina + 1; ?>" class="pagination-link">Siguiente</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Incluye el archivo de scripts -->
    <?php include "../inc/script.php"; ?>
</body>
</html>
