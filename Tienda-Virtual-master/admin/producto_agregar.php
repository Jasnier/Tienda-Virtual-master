
<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) session_start();
if (!$_SESSION["admin_id"]) {
    $_SESSION["volver"] = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
    header("Location: index.php");
}
require_once('../conexion.php');

if (isset($_POST["agregarProducto"]) && $_POST["agregarProducto"] == "agregarProducto") {
    $nombreImagen = $_POST["codigo"] . '.jpg'; // Nombre fijo para la imagen
    $directorioDestino = 'C:/xampp/htdocs/Tienda-Virtual-master/Tienda-Virtual-master/img/'; // Directorio donde se guardará la imagen
    $rutaDestino = $directorioDestino . $nombreImagen;
    
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        echo 'La imagen se ha subido correctamente y ha sido renombrada como ' . $nombreImagen;
    } else {
        echo 'Ha ocurrido un error al subir la imagen.';
    }
    
    $q = "INSERT INTO `productos` (`id`, `nombre`, `codigo`, `categoria`, `frase_promocional`, `precio`, `disponibilidad`, `descripcion`, `promocion`, `fecha`) VALUES (NULL, '$_POST[nombre]', '$_POST[codigo]', '$_POST[categoria]', '$_POST[frase_promocional]', '$_POST[precio]', '$_POST[disponibilidad]', '$_POST[descripcion]', '$_POST[promocion]', CURRENT_TIMESTAMP)";
    
    $resource = $conn->query($q);
    
    if ($resource) {
        echo 'El producto se ha agregado correctamente.';
        header("Location: listado_productos.php");
        exit;
    } else {
        echo 'Ha ocurrido un error al agregar el producto.';
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">

    <!-- Website Font style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <title>Ingreso de Productos</title>

    <style>
        #success_message {
            display: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#agregarProducto').bootstrapValidator({
                // Configuración personalizada
            });
        });
    </script>
</head>

<body>
    <?php 
        include("header.php"); 
        include("menu_admin.php"); 
    ?>
    <div class="container">
        <form class="well form-horizontal" method="post" enctype="multipart/form-data" id="agregarProducto" name="registro">
            <fieldset>
                <!-- Form Name -->
                <legend>Ingrese los datos del Producto</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Nombre del Producto</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            <input name="nombre" placeholder="Nombre del Producto" class="form-control" type="text" required>
                        </div>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Código del Producto</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                            <input name="codigo" placeholder="Código del Producto" class="form-control" type="text" required>
                        </div>
                    </div>
                </div>

                <!-- Select Basic -->
				<div class="form-group"> 
					 	<label class="col-md-4 control-label">Categorías</label>
							<div class="col-md-4 selectContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
									<select name="categoria" id="categoria" class="form-control selectpicker" required>
										<option value="" selected>Seleccione una categoría</option>
									 	<option value="Bebidas">Bebidas</option>
									 	<option value="Helados">Helados</option>
									 	<option value="Dulces">Dulces</option>
									 	<option value="Comidas Rapidas">Comidas Rapidas</option>
									 	<option value="Paquetes">Paquetes</option>
									</select>
								</div>
							</div>
					</div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Frase Promocional</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                            <input name="frase_promocional" placeholder="Frase Promocional" class="form-control" type="text" required>
                        </div>
                    </div>
                </div>

               

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Precio</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                            <input name="precio" placeholder="Precio" class="form-control" type="text" required>
                        </div>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
						 <label class="col-md-4 control-label">Disponibilidad</label>
						 <div class="col-md-4 inputGroupContainer">        	      
							<div class="radio">
							  <label><input type="radio" name="disponibilidad" value="1" required>Si</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="disponibilidad" value="0" required>No</label>
							</div>
						 </div>
					</div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Descripción</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                            <input name="descripcion" placeholder="Descripción" class="form-control" type="text" required>
                        </div>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
						 <label class="col-md-4 control-label">En Promoción</label>
						 <div class="col-md-4 inputGroupContainer">        	      
							<div class="radio">
							  <label><input type="radio" name="promocion" value="Si" required>Si</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="promocion" value="No" required>No</label>
							</div>
						 </div>
				</div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Imagen</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                            <input type="file" name="imagen" id="imagen" required>
                        </div>
                    </div>
                </div>

                <!-- Success message -->
                <div class="alert alert-success" role="alert" id="success_message">¡El producto se ha agregado correctamente!</div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning" name="agregarProducto" value="agregarProducto">Agregar Producto</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>
