<?php
    session_start();
    if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
        exit;
    }

    require_once ("config/db.php");
    require_once ("config/conexion.php");

    $total_productos = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as total FROM products"))['total'];
    $total_categorias = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as total FROM categorias"))['total'];
    $stock_bajo = mysqli_query($con, "SELECT nombre_producto, stock FROM products WHERE stock < 10 ORDER BY stock ASC LIMIT 5");

    $title = "Dashboard | Innova Stock";
    $active_dashboard = "active";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include("navbar.php"); ?>

    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h4><i class='glyphicon glyphicon-dashboard'></i> Dashboard - Resumen del Sistema</h4>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="well text-center">
                            <h4>Total de Productos</h4>
                            <h2><?php echo $total_productos; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="well text-center">
                            <h4>Categorías Activas</h4>
                            <h2><?php echo $total_categorias; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="well text-center bg-danger text-white">
                            <h4>Stock Bajo</h4>
                            <h2>Productos críticos</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3>Productos con bajo stock</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Stock Disponible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($stock_bajo)) { ?>
                                    <tr>
                                        <td><?php echo $row['nombre_producto']; ?></td>
                                        <td class="text-center"><?php echo $row['stock']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3>Últimos movimientos en el inventario</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th>Acción</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $historial = mysqli_query($con, 
                                        "SELECT historial.fecha, historial.nota, historial.cantidad, products.nombre_producto 
                                        FROM historial 
                                        JOIN products ON historial.id_producto = products.id_producto 
                                        ORDER BY historial.fecha DESC 
                                        LIMIT 10"
                                    );

                                    while ($row = mysqli_fetch_array($historial)) {
                                        echo "<tr>
                                                <td>" . date('d/m/Y', strtotime($row['fecha'])) . "</td>
                                                <td>" . $row['nombre_producto'] . "</td>
                                                <td>" . $row['nota'] . "</td>
                                                <td class='text-center'>" . number_format($row['cantidad'], 2) . "</td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
