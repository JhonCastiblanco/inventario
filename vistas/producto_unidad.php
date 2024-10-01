<?php

// Conectar a la base de datos
$conexion = conexion();

// Simular paginación
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$registros = 10; // Número de registros por página
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

// Obtener el total de registros
$total_query = $conexion->query("SELECT COUNT(*) FROM unidad_producto");
$total = $total_query->fetchColumn();

// Obtener los datos para la página actual
$productos_query = $conexion->prepare("SELECT * FROM unidad_producto LIMIT :inicio, :registros");
$productos_query->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$productos_query->bindValue(':registros', $registros, PDO::PARAM_INT);
$productos_query->execute();
$productos = $productos_query->fetchAll(PDO::FETCH_ASSOC);

$Npaginas = ceil($total / $registros);
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
</head>
<body>

    <div class="container">
        <!-- Botones para agregar nuevo producto y volver a la página anterior -->
        <div class="button-container">
        <a href="index.php?vista=unidad_new" class="button is-success is-rounded is-small">Agregar Nueva uinidad</a>
            <a href="javascript:history.back()" class="button is-light is-rounded is-small">Volver</a>
        </div>

        <br>
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>ID Producto</th>
                        <th>Estado</th>
                        <th>Fallas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr class="has-text-centered">
                                <td><?php echo htmlspecialchars($producto['producto_id']); ?></td>
                                <td><?php echo htmlspecialchars($producto['estado']); ?></td>
                                <td><?php echo htmlspecialchars($producto['fallas']); ?></td>
                                <td>
                                    <a href="editar_unidad.php?id=<?php echo urlencode($producto['unidad_id']); ?>" class="button is-success is-rounded is-small">Editar</a>
                                    <a href="eliminar_unidad.php?id=<?php echo urlencode($producto['unidad_id']); ?>" class="button is-danger is-rounded is-small">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="has-text-centered">
                            <td colspan="4">No hay registros en el sistema</td>
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

</body>
</html>
