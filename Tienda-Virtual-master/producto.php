<?php 
error_reporting(E_ALL ^ E_NOTICE);
require_once('conexion.php'); ?>
<?php
if(isset($_POST["comprar"]) && $_POST["comprar"] == "Comprar"){
    //print_r($_POST);
		$q="INSERT INTO `compras` (`id`, `cliente`, `codigo`, `nombre`, `precio`, `cantidad`, `fecha`) VALUES (NULL, '$_POST[cliente]', '$_POST[codigo]', '$_POST[nombre]', '$_POST[precio]', '$_POST[cantidad]', CURRENT_TIMESTAMP)";
		//print_r($q);
		$resource=$conn->query($q);
		header("Location: carrito.php");
	}
?>
<?php
if($_GET["id"]==0){
            header("Location: index.php"); 
        }
$query=" SELECT * FROM productos WHERE 1 AND id=$_GET[id]";
$resource = $conn->query($query); 
$total = $resource->num_rows;
$row = $resource->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
  <head>

    <?php include("head.php");?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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
                        <h2><?php echo $row["nombre"]?></h2>
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
                        
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="img/<?php echo $row["codigo"]?>.jpg" alt="<?php echo $row["nombre"]?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-9">
                                <div class="product-inner">
                                    <h2 class="product-name"><?php echo $row["nombre"]?></h2>
                                    <p><i class="fa fa-quote-left" aria-hidden="true"></i> <span class="frase-promo"><?php echo $row["frase_promocional"]?> </span><i class="fa fa-quote-right " aria-hidden="true"></i></p>
                                    <div class="product-inner-price">
                                        <ins>$ <?php echo $row["precio"]?></ins>  
                                        Antes $<del><?php echo $row["precio"]+($row["precio"]*0.4)?></del>
                                    </div> 

                                    
                                    <form method="post" name="comprar" id="comprar" class="cart">
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" title="Cantidad" value="1" name="cantidad" min="1" step="1">
                                            <input type="hidden" name="codigo" id="codigo" value="<?php echo $row["codigo"]?>">
                                            <input type="hidden" name="nombre" id="nombre" value="<?php echo $row["nombre"]?>">
                                            <input type="hidden" name="precio" id="precio" value="<?php echo $row["precio"]?>">
                                            <input type="hidden" name="cliente" id="cliente" value="<?php echo isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "" ?>">
                                        </div>
                                        <?php if ($row["disponibilidad"] != 0){?>
                                        <input type="submit" name="comprar" id="comprar" value="Comprar" class="add_to_cart_button">
                                        <?php }else{?>
                                        <input type="submit" name="comprar" id="comprar" value="Producto Agotado" class="nox-disponible" disabled>
                                        <?php }?>
                                    </form>   
                                    
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Descripción de Producto</a></li>
                                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">+ Información</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Descripción de Producto</h2>  
                                                <p><?php echo $row["descripcion"]?></p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                                                <div class="submit-review">
                                                    <p><b>Unidad de Medida:</b> <?php echo $row["unidad"]?></p>
                                                    <p><b>Código :</b> <?php echo $row["codigo"]?></p>
                                                    <p><b>Categoría :</b> <?php echo $row["categoria"]?></p>
                                                    <p><b>¿Producto en Promoción?: </b> <?php echo $row["promocion"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include("footer.php");?><!-- End Footer -->
    <!-- JS -->
    <?php include("js.php");?><!-- End JS -->
  </body>
</html>