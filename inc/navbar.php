<!-- Archivo: navbar.php -->

<!--
    Barra de navegación principal:
    - `navbar`: Clase principal para el contenedor de la barra de navegación.
    - `navbar-brand`: Contiene el logo y el botón de menú (en dispositivos móviles).
    - `navbar-burger`: Botón para abrir/cerrar el menú en dispositivos móviles.
    - `navbar-menu`: Contiene los enlaces de navegación y el menú desplegable.
    - `navbar-start`: Sección para enlaces de navegación principales.
    - `navbar-item`: Elemento de navegación individual.
    - `navbar-dropdown`: Menú desplegable asociado a los elementos de navegación con sub-enlaces.
    - `navbar-end`: Sección para botones adicionales como "Mi cuenta" y "Salir".
-->

<nav class="navbar" role="navigation" aria-label="main navigation">

    <!-- Branding y botón de menú -->
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home">
            <img src="./img/logo.png" width="65" height="28" alt="Logo">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <!-- Menú de navegación -->
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <!-- Enlaces desplegables para Usuarios, Categorías y Productos -->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=user_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=user_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=user_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Categorías</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=category_new" class="navbar-item">Nueva</a>
                    <a href="index.php?vista=category_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=category_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Productos</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=product_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=product_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=product_category" class="navbar-item">Por categoría</a>
                    <a href="index.php?vista=product_search" class="navbar-item">Buscar</a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Proyectos</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=project_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=project_list" class="navbar-item">Lista</a>
                </div>
            </div>
        </div>

        <!-- Botones de usuario -->
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
                        Mi cuenta
                    </a>
                    <a href="index.php?vista=logout" class="button is-link is-rounded">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
