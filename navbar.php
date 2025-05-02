<?php if (isset($title)) { ?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img src="img/logo-icon.png" alt="Innova Logo">
        <span>Innova Stock</span>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="main-navbar">
      <ul class="nav navbar-nav">
        <li class="<?= isset($active_productos) ? $active_productos : '' ?>">
          <a href="stock.php"><i class='glyphicon glyphicon-barcode'></i> Inventario</a>
        </li>
        <li class="<?= isset($active_categoria) ? $active_categoria : '' ?>">
          <a href="categorias.php"><i class='glyphicon glyphicon-tags'></i> Categorías</a>
        </li>
        <li class="<?= isset($active_usuarios) ? $active_usuarios : '' ?>">
          <a href="usuarios.php"><i class='glyphicon glyphicon-user'></i> Usuarios</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="https://innova-webdev.com/#contact" target="_blank"><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li>
        <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php } ?>
