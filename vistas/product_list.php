<!-- Contenedor principal para el título y subtítulo -->
<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<!-- Contenedor para la lista de productos -->
<div class="container pb-6 pt-6">
    <?php
        // Incluye el archivo principal que puede manejar configuraciones generales y funciones
        require_once "./php/main.php";

        // Verifica si se ha enviado una solicitud para eliminar un producto
        if(isset($_GET['product_id_del'])){
            // Incluye el archivo que maneja la eliminación del producto
            require_once "./php/producto_eliminar.php";
        }

        // Determina la página actual para la paginación
        if(!isset($_GET['page'])){
            $pagina=1; // Página predeterminada si no se especifica
        } else {
            $pagina=(int) $_GET['page']; // Convierte el valor de la página a entero
            if($pagina<=1){
                $pagina=1; // Asegura que la página sea al menos 1
            }
        }

        // Obtiene el ID de categoría si se especifica, o usa 0 si no se especifica
        $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

        // Limpia la cadena de la página para evitar inyecciones de código
        $pagina=limpiar_cadena($pagina);

        // Define la URL base para la paginación
        $url="index.php?vista=product_list&page=";

        // Número de registros por página
        $registros=15;

        // Define una cadena de búsqueda vacía
        $busqueda="";

        // Incluye el archivo que maneja la lista de productos y la paginación
        require_once "./php/producto_lista.php";
    ?>
</div>
