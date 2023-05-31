<?php
error_reporting(0);
if (!isset($_SESSION))
  session_start();
if (!$_SESSION["user_id"]) {
  $_SESSION["volver"] = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
  header("Location: index.php");
}
require_once('conexion.php');
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

$query = "SELECT id, id_cliente, nombre, valor, estado, fecha,fechaentrega FROM historial";
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
  <?php include("head.php"); ?>

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
    document.addEventListener('DOMContentLoaded', function () {
      recargarPagina();
    });
  </script>
</head>

<body>
  <?php
  include("header.php");
  include("menu.php");
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
    <div class="table-responsive">
      <table class="table" id="user-table">
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Nombre</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Fecha de compra</th>
            <th>Fecha de entrega</th>
          </tr>

        </thead>
        <tbody>
          <?php
          while ($row = $resource->fetch_assoc()) {

            $cliente = $row["id_cliente"];
            $nombre = $row["nombre"];
            $valor = $row["valor"];
            $estado = $row["estado"];
            $fecha = $row["fecha"];
            $fechaentrega = $row["fechaentrega"];
            $id = $row["id"];
            if ($row["estado"] == 0) {
              $estado = "Sin Entregar";
            } else {
              $estado = "Entregado";
            }
            ?>


            <tr>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $cliente; ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $nombre; ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $valor; ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $estado; ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $fecha; ?>
              </td>
              <td class="col-xs-3 col-sm-3 col-md-4 col-lg-3">
                <?php echo $fechaentrega; ?>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JFvFc0jRMmDpB+JwzTXB0NnqIbbVYUew+OrCXaRkfjM"
    crossorigin="anonymous"></script>
  <!-- Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous"></script>
</body>
<?php include("footer.php"); ?>

</html>