<?php 
error_reporting(E_ALL ^ E_NOTICE);
require_once("conexion.php");

if(!isset($_GET['pedido'])){
    header("Location: index.php");
    exit;
}

$q = "SELECT * FROM compras WHERE cliente = (SELECT cliente FROM pedidos WHERE id = {$_GET['pedido']}) ORDER BY fecha DESC";
$r = $conn->query($q); 
$t = $r->num_rows;

// Verificar si se encontraron compras para el pedido
if(empty($_GET['pedido'])){
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("head.php");?>
    <style>
    .descuento{
        display: none;
    }  
    </style>
</head>
<body>
    <!-- header -->
    <?php include("header.php");?><!-- fin header --> 

    <!-- Menu Principal -->
    <?php include("menu.php");?>    
    <!-- End Menu Principal -->

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Gracias Por Su Preferencia</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">

                            <h2>Su Compra Fué Realizada con Éxito</h2>
                            <div class="table-responsive col-xs-12">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail"><i class="fa fa-file-image-o" aria-hidden="true"></i> Foto</th>
                                            <th class="product-name"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Producto</th>
                                            <th class="product-price"><i class="fa fa-usd" aria-hidden="true"></i> Precio</th>
                                            <th class="product-quantity">Cantidad</th>
                                            <th class="product-subtotal"><i class="fa fa-usd" aria-hidden="true"></i> Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $subtotal = 0; // Inicializar la variable subtotal
                                        while ($row = $r->fetch_assoc()){
                                            $precio = $row['precio'];
                                            $cantidad = $row['cantidad'];
                                            $subtotal_producto = $precio * $cantidad;
                                            $subtotal += $subtotal_producto; // Agregar el subtotal del producto al subtotal total
                                        ?>
                                        <tr class="cart_item wow fadeIn">
                                            <td class="product-thumbnail">
                                                <img width="145" height="145" alt="<?php echo $row['nombre']?>" class="shop_thumbnail" src="img/<?php echo $row['codigo']?>.jpg">
                                            </td>

                                            <td class="product-name">
                                                <?php echo $row['nombre']?>
                                            </td>

                                            <td class="product-price">
                                                <span class="amount">$<?php echo number_format($precio, 0, ',', '.'); ?></span> 
                                            </td>

                                            <td class="product-quantity">
                                                <?php echo $cantidad;?>
                                            </td>

                                            <td class="product-subtotal">
                                                <span class="amount">$<?php echo number_format($subtotal_producto, 0, ',', '.'); ?></span> 
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr class="cart-subtotal wow fadeIn">
                                            <th colspan="4">Total</th>
                                            <td>
                                                <span class="amount">$<?php echo number_format($subtotal, 0, ',', '.');?></span> 
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="woocommerce-info wow fadeIn">
                                <p>Gracias por su compra, estaremos en contacto con usted.</p>
                            </div>                         
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de Pagina -->
    <?php include("footer.php");?>    
    <!-- End Pie de Pagina -->

</body>
</html>
