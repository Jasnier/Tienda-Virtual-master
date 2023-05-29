<?php 
error_reporting(0);
if(!isset($_SESSION)) session_start();
if(!$_SESSION["admin_id"]){
  $_SESSION["volver"] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
  header("Location: index.php");
}
require_once('../conexion.php');
?>

<?php
if(isset($_GET["idElm"]) && $_GET["idElm"] != ""){
  $q = "DELETE FROM clientes WHERE 1 AND id='$_GET[idElm]'";
  $r = $conn->query($q);
}

$max = 5;
$pag = 0;

if(isset($_GET["pag"]) && $_GET["pag"] != ""){
  $pag = $_GET["pag"];
}

$inicio = $pag * $max;
$query = "SELECT id, id_cliente, nombre, valor, estado, fecha FROM entregas ORDER BY fecha DESC";
$query_limit = $query . " LIMIT $inicio, $max";
$resource = $conn->query($query_limit);

if(isset($_GET["total"])){
  $total = $_GET["total"];
} else {
  $resource_total = $conn->query($query);
  $total = $resource_total->num_rows;
}

$total_pag = ceil($total/$max) - 1;

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <style>
    img {
      max-width: 40%;
    }
  </style>
</head>
<body>
  <?php 
    include("header.php"); 
    include("menu_admin.php"); 
  ?>

  <div class="container">                 
    <ul class="pager">
      <?php if ($pag - 1 >= 0) { ?>
        <li><a href="detalle.php?pag=<?php echo $pag - 1 ?>&total=<?php echo $total ?>">Anterior</a></li>
      <?php } ?>
      | <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $max, $total) ?> | de <?php echo $total ?>
      <?php if ($pag + 1 <= $total_pag) { ?>
        <li><a href="detalle.php?pag=<?php echo $pag + 1 ?>&total=<?php echo $total ?>">Siguiente</a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="container">
    <h2>Listado de Usuarios</h2> 
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>ID cliente</th>
            <th>Nombre</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resource->fetch_assoc()) { ?>
            <?php
            if ($row["estado"] == 0) {
              $estado = "Sin Entregar";
            } else {
              $estado = "Entregado";
            }
            ?>
            <tr>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><?php echo $row["id_cliente"] ?></td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><a href="mailto:<?php echo $row["nombre"] ?>"><?php echo $row["nombre"] ?></a></td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><a href="mailto:<?php echo $row["valor"] ?>"><?php echo $row["valor"] ?></a></td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><?php echo $estado ?></td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><?php echo $row["fecha"] ?></td>
              
            </tr>
          <?php } ?>
        </tbody>
      </table>      
    </div>
  </div>


  <!-- jQuery --> 
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>       
  <!-- Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
  <script type="text/javascript">
    $(document).ready(function(){
      $("tr:odd").css("background-color", "#efefef"); // filas impares
      $("tr:even").css("background-color", "#f7f7f7"); // filas pares
    });
  </script>
</body>

</html>
