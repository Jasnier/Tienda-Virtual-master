<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div> 
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="tienda.php">Menu</a></li>
                    <?php
                    session_start();
                    if (isset($_SESSION['user_id'])) {
                        echo '<li><a href="comprar.php">Mis Compras</a></li>';
                    }
                    ?>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </div>  
        </div>
    </div>
</div>
