<!--
    Script de JavaScript para la interacción con la barra de navegación y la carga de archivos JS adicionales:

    - `DOMContentLoaded`: Evento que se dispara cuando el documento HTML ha sido completamente cargado y parseado.
    
    - `navbar-burger`: Elementos con esta clase representan el botón de menú en la barra de navegación en dispositivos móviles.
    
    - **Funciones principales**:
        - Selecciona todos los elementos con la clase `.navbar-burger`.
        - Itera sobre cada uno y agrega un evento `click` que:
            - Obtiene el valor del atributo `data-target` para encontrar el menú asociado.
            - Alterna la clase `is-active` en el botón y en el menú para mostrar u ocultar el menú.
    
    - `script src="./js/ajax.js"`: Incluye un archivo JavaScript externo para manejar solicitudes AJAX.
-->

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Obtener todos los elementos con la clase "navbar-burger"
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Verificar si hay elementos "navbar-burger"
        if ($navbarBurgers.length > 0) {

            // Agregar un evento de clic a cada uno
            $navbarBurgers.forEach(el => {
                el.addEventListener('click', () => {

                    // Obtener el objetivo del atributo "data-target"
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);

                    // Alternar la clase "is-active" en el "navbar-burger" y en el "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });
        }
    });
</script>

<script src="./js/ajax.js"></script>
