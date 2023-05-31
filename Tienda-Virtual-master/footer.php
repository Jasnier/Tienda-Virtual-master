    <div class="footer-top-area wow fadeIn" style="margin-top: 200px;">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-about-us">
                        <a href="index.php"><img src="img/Logotipopx.png" alt="Logo Frutería Bilbao 610 Gris"></a>
                        <p>Esta pagina web ha sido creada para optimizar la compra/venta de los productos de la cafeteria de la universidad Uniminuto Centro Regional Girardot</p>
                        <!--
                             <div class="footer-social">
                                <a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/?lang=es" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.youtube.com/" target="_blank"><i class="fa fa-youtube"></i></a>
                                <a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </div>
                        -->
                    </div>
                </div>
                
                <div class="col-md-4">
    <div class="footer-menu">
        <h2 class="footer-wid-title">Navegación de Usuario</h2>
        <ul>
            <?php if(isset($_SESSION["user_id"])) { ?>
                <li><a href="mis-datos.php?id=<?php echo $_SESSION["user_id"] ?>"><i class="fa fa-user" aria-hidden="true"></i> Mis datos</a></li>
                <li><a href="carrito.php"><i class="fa fa-shopping-cart"></i> Mi Carrito</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Salir</a></li>
            <?php } else { ?>
                <li><a href="login.php"><i class="fa fa-sign-in"></i> Iniciar Sesión</a></li>
                <li><a href="registro.php"><i class="fa fa-user"></i> Registrarse</a></li>
            <?php } ?>
        </ul>                        
    </div>
</div>

                
                <div class="col-md-4">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Desarrolladores</h2>
                        <p>Jasnier Andres Perez Usuga</p>
                        <p>Juan Camilo Yali Florez</p>
                        <p>Kevin Alexander Pava Leon</p>
                        <p>Joheen Andre Vergara Cuellar</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->
    <footer class="footer-bottom-area wow fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2023 Coffe Cloud. Todos Los Derechos Reservados.</p>
                    </div>
                </div>
                
      
                </div>
            </div>
        </div>
    </footer> <!-- End footer bottom area -->