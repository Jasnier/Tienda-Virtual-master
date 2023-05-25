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
    
    $unidad = implode(',', $_POST["unidad"]);
    $q = "INSERT INTO `productos` (`id`, `nombre`, `codigo`, `categoria`, `frase_promocional`, `unidad`, `precio`, `disponibilidad`, `descripcion`, `promocion`, `fecha`) VALUES (NULL, '$_POST[nombre]', '$_POST[codigo]', '$_POST[categoria]', '$_POST[frase_promocional]', '$unidad', '$_POST[precio]', '$_POST[disponibilidad]', '$_POST[descripcion]', '$_POST[promocion]', CURRENT_TIMESTAMP)";
    
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
                            <input name="nombre" placeholder="Nombre del Producto" class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Código del Producto</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                            <input name="codigo" placeholder="Código del Producto" class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <!-- Select Basic -->
				<div class="form-group"> 
					 	<label class="col-md-4 control-label">Categorías</label>
							<div class="col-md-4 selectContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
									<select name="categoria" id="categoria" class="form-control selectpicker" >
										<option value=" " >Seleccione una categoria</option>
									 	<option value="Frutas">Frutas</option>
									 	<option value="Legumbres">Legumbres</option>
									 	<option value="Congelados">Congelados</option>
									 	<option value="Coctel">Coctel</option>
									 	<option value="Verduras">Verduras</option>
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
                            <input name="frase_promocional" placeholder="Frase Promocional" class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <!-- Multiple Checkboxes -->
                <div class="form-group"> 
					 	<label class="col-md-4 control-label">Unidad de medida</label>
							<div class="col-md-4 selectContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
									<select name="unidad[]" id="colores" class="form-control selectpicker" >
										<option value=" " >Seleccione Unidad de Medida</option>
									 	<option value="Unidad">Unidad</option>
									 	<option value="1 Kilo">1 Kilo</option>
									 	<option value="900g">900g</option>
									 	<option value="800g">800g</option>
									 	<option value="700g">700g</option>
									 	<option value="600g">600g</option>
									 	<option value="500g">500g</option>
									 	<option value="400g">400g</option>
                                        <option value="300g">300g</option>
                                        <option value="200g">200g</option>
                                        <option value="100g">100g</option>
                                        <option value="900g">900g</option>
                                        <option value="1Litro">1Litro</option>
									 	<option value="1/2Litro">1/2Litro</option>
									</select>
								</div>
							</div>
					</div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label">Precio</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                            <input name="precio" placeholder="Precio" class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <!-- Text input-->
			<!-- Disponibilidad -->
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

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Descripción</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            <textarea class="form-control" name="descripcion" placeholder="Descripción"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Text input-->
			<!-- En Promoción -->
					<div class="form-group">
						 <label class="col-md-4 control-label">En Promoción</label>
						 <div class="col-md-4 inputGroupContainer">        	      
							<div class="radio">
							  <label><input type="radio" name="promocion" value="1" required>Si</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="promocion" value="0" required>No</label>
							</div>
						 </div>
					</div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Imagen</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                            <input id="imagen" name="imagen" class="form-control" type="file">
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning" name="agregarProducto" value="agregarProducto">Agregar Producto <span class="glyphicon glyphicon-send"></span></button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</body>

</html>
