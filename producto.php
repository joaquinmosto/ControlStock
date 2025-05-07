<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
	}

	require_once("config/db.php");
	require_once("config/conexion.php");
	include("funciones.php");

	$active_productos = "active";
	$active_clientes = "";
	$active_usuarios = "";
	$title = "Producto | Innova Stock";

	if (isset($_POST['reference']) && isset($_POST['quantity'])) {
		$quantity = intval($_POST['quantity']);
		$reference = mysqli_real_escape_string($con, strip_tags($_POST["reference"], ENT_QUOTES));
		$id_producto = intval($_GET['id']);
		$user_id = $_SESSION['user_id'];
		$firstname = $_SESSION['firstname'];
		$nota = "$firstname agregó $quantity producto(s) al inventario";
		$fecha = date("Y-m-d H:i:s");
		guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity);
		$update = agregar_stock($id_producto, $quantity);
		$message = ($update == 1) ? 1 : 0;
	}

	if (isset($_POST['reference_remove']) && isset($_POST['quantity_remove'])) {
		$quantity = intval($_POST['quantity_remove']);
		$reference = mysqli_real_escape_string($con, strip_tags($_POST["reference_remove"], ENT_QUOTES));
		$id_producto = intval($_GET['id']);
		$user_id = $_SESSION['user_id'];
		$firstname = $_SESSION['firstname'];
		$nota = "$firstname eliminó $quantity producto(s) del inventario";
		$fecha = date("Y-m-d H:i:s");
		guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity);
		$update = eliminar_stock($id_producto, $quantity);
		$message = ($update == 1) ? 1 : 0;
	}

	if (isset($_GET['id'])) {
		$id_producto = intval($_GET['id']);
		$query = mysqli_query($con, "SELECT * FROM products WHERE id_producto='$id_producto'");
		$row = mysqli_fetch_array($query);
	} else {
		die("Producto no existe");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
	<?php include("head.php"); ?>
	<link rel="stylesheet" href="css/producto.css">
</head>
<body>
	<?php
		include("navbar.php");
		include("modal/agregar_stock.php");
		include("modal/eliminar_stock.php");
		include("modal/editar_productos.php");
	?>

<div class="panel panel-success custom-panel">
	<div class="panel-heading">
        <h3 class="panel-title">Detalles del Producto</h3>
    </div>
    <div class="panel-body">
        <div class="product-container">
            <div class="product-content">
                <div class="product-info">
                    <span class="item-title"><?php echo $row['nombre_producto'];?></span>
                    <span class="item-number"><?php echo $row['codigo_producto'];?></span>

                    <div class="stock-section">
                        <span class="current-stock">Stock disponible</span>
                        <div class="stock-data">
                            <div class="item-quantity"><?php echo number_format($row['stock']);?></div>
                            <div class="stock-actions">
                                <button class="stock-add" data-toggle="modal" data-target="#add-stock">➕</button>
                                <button class="stock-remove" data-toggle="modal" data-target="#remove-stock">➖</button>
                            </div>
                        </div>
                    </div>

                    <div class="price-section">
                        <span class="current-stock">Precio venta</span>
                        <div class="item-price">$ <?php echo number_format($row['precio_producto'], 2);?></div>
                    </div>
                </div>

                <div class="product-actions">
					<div class="image-container">
						<img class="item-img img-responsive" src="img/stock.png" alt="">
					</div>

					<div class="action-buttons">
						<a href="#" class="btn btn-danger delete-btn" onclick="eliminar('<?php echo $row['id_producto'];?>')">
							<i class="glyphicon glyphicon-trash"></i> Eliminar
						</a>
						<a href="#myModal2" data-toggle="modal"
						data-codigo='<?php echo $row['codigo_producto'];?>'
						data-nombre='<?php echo $row['nombre_producto'];?>'
						data-categoria='<?php echo $row['id_categoria'];?>'
						data-precio='<?php echo $row['precio_producto'];?>'
						data-stock='<?php echo $row['stock'];?>'
						data-id='<?php echo $row['id_producto'];?>'
						class="btn btn-info edit-btn">
							<i class="glyphicon glyphicon-pencil"></i> Editar
						</a>
					</div>
				</div>
            </div>
        </div>
    </div>
	
	
	<div class="history-section">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<table class='table table-bordered'>
					<tr><th colspan="5" class="text-center">HISTORIAL DE INVENTARIO</th></tr>
					<tr>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Descripción</th>
						<th>Referencia</th>
						<th class='text-center'>Total</th>
					</tr>
					<?php
                    $query = mysqli_query($con, "SELECT * FROM historial WHERE id_producto='$id_producto'");
                    while ($row = mysqli_fetch_array($query)):
						?>
                    <tr>
						<td><?php echo date('d/m/Y', strtotime($row['fecha']));?></td>
                        <td><?php echo date('H:i:s', strtotime($row['fecha']));?></td>
                        <td><?php echo $row['nota'];?></td>
                        <td><?php echo $row['referencia'];?></td>
                        <td class='text-center'><?php echo number_format($row['cantidad'],2);?></td>
                    </tr>
					<?php endwhile; ?>
				</table>
			</div>
		</div>
	</div>
</div>
	

	<?php include("footer.php"); ?>
	<script src="js/productos.js"></script>

	<script>
		$("#editar_producto").submit(function(event) {
			$('#actualizar_datos').attr("disabled", true);
			var parametros = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "ajax/editar_producto.php",
				data: parametros,
				beforeSend: function() {
					$("#resultados_ajax2").html("Mensaje: Cargando...");
				},
				success: function(datos) {
					$("#resultados_ajax2").html(datos);
					$('#actualizar_datos').attr("disabled", false);
					setTimeout(function() {
						$(".alert").fadeTo(500, 0).slideUp(500, function() {
							$(this).remove();
							location.replace('stock.php');
						});
					}, 4000);
				}
			});
			event.preventDefault();
		});

		$('#myModal2').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget);
			$(this).find('.modal-body #mod_codigo').val(button.data('codigo'));
			$(this).find('.modal-body #mod_nombre').val(button.data('nombre'));
			$(this).find('.modal-body #mod_categoria').val(button.data('categoria'));
			$(this).find('.modal-body #mod_precio').val(button.data('precio'));
			$(this).find('.modal-body #mod_stock').val(button.data('stock'));
			$(this).find('.modal-body #mod_id').val(button.data('id'));
		});

		function eliminar(id) {
			if (confirm("Realmente deseas eliminar el producto")) {
				location.replace('stock.php?delete=' + id);
			}
		}
	</script>
</body>
</html>
