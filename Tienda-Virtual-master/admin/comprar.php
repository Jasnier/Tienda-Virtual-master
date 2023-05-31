<?php
error_reporting(0);
if (!isset($_SESSION))
  session_start();
if (!$_SESSION["admin_id"]) {
  $_SESSION["volver"] = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
  header("Location: index.php");
}
require_once('../conexion.php');
?>

<?php
if (isset($_GET["idElm"]) && $_GET["idElm"] != "") {
  $q = "DELETE FROM clientes WHERE 1 AND id='$_GET[idElm]'";
  $r = $conn->query($q);
}

$max = 5;
$pag = 0;

if (isset($_GET["pag"]) && $_GET["pag"] != "") {
  $pag = $_GET["pag"];
}

$inicio = $pag * $max;

// Obtener los valores del formulario de filtrado
$fecha = isset($_GET["fecha"]) ? $_GET["fecha"] : "";
$hora_inicio = isset($_GET["hora_inicio"]) ? $_GET["hora_inicio"] : "";
$hora_fin = isset($_GET["hora_fin"]) ? $_GET["hora_fin"] : "";
$id = isset($_GET["id"]) ? $_GET["id"] : ""; // Nuevo filtro por ID

// Construir la condición de filtrado para la consulta SQL
$condition = "";
if (!empty($fecha)) {
  $condition .= "DATE(fecha) = '$fecha'";
}
if (!empty($hora_inicio) && !empty($hora_fin)) {
  if (!empty($condition)) {
    $condition .= " AND ";
  }
  $condition .= "TIME(fecha) BETWEEN '$hora_inicio' AND '$hora_fin'";
}
if (!empty($id)) { // Agregar filtro por ID
  if (!empty($condition)) {
    $condition .= " AND ";
  }
  $condition .= "id = '$id'";
}

$query = "SELECT id, cliente, nombre, valor, estado, fecha FROM pedido";

// Agregar la condición de filtrado a la consulta SQL
if (!empty($condition)) {
  $query .= " WHERE $condition";
}

$query .= " ORDER BY fecha DESC";

$query_limit = $query . " LIMIT $inicio, $max";
$resource = $conn->query($query_limit);

if (isset($_GET["total"])) {
  $total = $_GET["total"];
} else {
  $resource_total = $conn->query($query);
  $total = $resource_total->num_rows;
}

$total_pag = ceil($total / $max) - 1;

?>
  <?php
  if (isset($_POST["confi"]) && $_POST["confi"] == "Listo" && isset($_POST["pedidoID"])) {
    $pedidoID = $_POST["pedidoID"];
    $q = "UPDATE pedido SET estado = CASE WHEN id = '$pedidoID' THEN '1' ELSE estado END";
    $r = $conn->query($q);


    // Obtener los datos del pedido
    $pedidoQuery = "SELECT cliente, nombre, valor, estado, fecha FROM pedido WHERE id = '$pedidoID'";
    $pedidoResult = $conn->query($pedidoQuery);
    $pedidoData = $pedidoResult->fetch_assoc();

    // Insertar los datos en la tabla entregas
    $cliente = $pedidoData["cliente"];
    $nombre = $pedidoData["nombre"];
    $valor = $pedidoData["valor"];
    $estado = $pedidoData["estado"];
    $fecha = $pedidoData["fecha"];
    if ($cliente == 0) {
      echo '<script>alert("No ha confirmado ninguna entrega");</script>';

    } else {
      $insertQuery = "INSERT INTO entregas (id_cliente, nombre, valor,estado, fecha,FechaConfirmacion) VALUES ('$cliente', '$nombre', '$valor','$estado', '$fecha', CURRENT_TIMESTAMP)";
      $insertResult = $conn->query($insertQuery);
      $d = "DELETE FROM pedido WHERE `pedido`.`id` =$pedidoID";
      $rd = $conn->query($d);
      if ($insertResult) {
        echo '<script>alert("Se ha confirmado su entrega");</script>';

        
  
      } else {
        // Manejo de error en la inserción
        echo "Error al agregar los valores en la tabla entregas.";
      }
    }
    header("Location: entregado.php");
    exit();

  }

  ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Compras</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <style>
    img {
      max-width: 40%;
    }
  </style>
  <script>
    // Función para recargar la página
    function recargarPagina() {
      if (localStorage.getItem('contador') === null) {
        localStorage.setItem('contador', 1);
      } else {
        var contador = parseInt(localStorage.getItem('contador'));
        if (contador < 2) {
          localStorage.setItem('contador', contador + 1);
          location.reload();
        }
      }
    }

    // Evento DOMContentLoaded para iniciar la recarga
    document.addEventListener('DOMContentLoaded', function() {
      recargarPagina();
    });
  </script>
</head>

<body>
  <?php
  include("header.php");
  include("menu_admin.php");
  ?>

  <div class="container">
    <ul class="pager">
      <?php if ($pag - 1 >= 0) { ?>
        <li><a href="comprar.php?pag=<?php echo $pag - 1 ?>&total=<?php echo $total ?>">Anterior</a></li>
      <?php } ?>
      |
      <?php echo ($inicio + 1) ?> a
      <?php echo min($inicio + $max, $total) ?> | de
      <?php echo $total ?>
      <?php if ($pag + 1 <= $total_pag) { ?>
        <li><a href="comprar.php?pag=<?php echo $pag + 1 ?>&total=<?php echo $total ?>">Siguiente</a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="container">
    <h2>Listado de Compras</h2>
    <div class="row">
      <form class="form-inline" method="get">
        <div class="form-group">
          <label for="id">ID:</label> <!-- Nuevo campo de filtro por ID -->
          <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>">
        </div>
        <div class="form-group">
          <label for="fecha">Fecha:</label>
          <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha ?>">
        </div>
        <div class="form-group">
          <label for="hora_inicio">Hora Inicio:</label>
          <input type="time" class="form-control" id="hora_inicio" name="hora_inicio"
            value="<?php echo $hora_inicio ?>">
        </div>
        <div class="form-group">
          <label for="hora_fin">Hora Fin:</label>
          <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?php echo $hora_fin ?>">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
      </form>
    </div>
    <br>
    <div class="table-responsive">
      <table class="table" id="user-table">
        <thead>
          <tr>
            <th>ID cliente</th>
            <th>Nombre</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Detalle</th>
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
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $row["cliente"] ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><a href="mailto:<?php echo $row["nombre"] ?>"><?php echo $row["nombre"] ?></a></td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3"><a href="mailto:<?php echo $row["valor"] ?>"><?php echo $row["valor"] ?></a></td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $estado ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $row["fecha"] ?>
              </td>
              <td>
                <?php if ($row["estado"] == 1) { ?>
                  <button type="button" class="btn btn-success" disabled>Listo</button>
                <?php } else { ?>
                  <form action="" method="post">
                    <input type="hidden" name="pedidoID" value="<?php echo $row["id"] ?>">
                    <input type="submit" name="confi" value="Listo" class="btn btn-success">
                  </form>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include("footer.php"); ?>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
  <!-- Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $("tr:odd").css("background-color", "#efefef"); // filas impares
      $("tr:even").css("background-color", "#f7f7f7"); // filas pares

      // Función para actualizar la tabla de usuarios mediante Ajax
      function updateTable() {


      // Actualizar la tabla cada 5 segundos
      setInterval(updateTable, 5000);
    }});
  </script>




</body>

</html>