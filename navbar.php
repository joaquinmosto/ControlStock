<?php
    if (isset($title)) {
?>
<nav class="navbar navbar-default" style="border:none; border-radius:0; margin-bottom:0;">
  <div class="container-fluid">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar" style="background:#fff;"></span>
        <span class="icon-bar" style="background:#fff;"></span>
        <span class="icon-bar" style="background:#fff;"></span>
      </button>
      <a class="navbar-brand" href="#" style="display:flex; align-items:center; gap:10px;">
        <img src="img/logo-icon.png" alt="Innova Logo" style="height:28px;">
        <span style="color:#ffffff; font-weight:600; font-family:'Poppins', sans-serif;">Innova Stock</span>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="main-navbar">
      <ul class="nav navbar-nav">
        <li class="<?php if (isset($active_dashboard)){echo $active_dashboard;}?>">
          <a href="dashboard.php" style="color:#fff;"><i class='glyphicon glyphicon-stats'></i> Dashboard</a>
        </li>
        <li class="<?php if (isset($active_productos)){echo $active_productos;}?>">
          <a href="stock.php" style="color:#fff;"><i class='glyphicon glyphicon-barcode'></i> Inventario</a>
        </li>
        <li class="<?php if (isset($active_categoria)){echo $active_categoria;}?>">
          <a href="categorias.php" style="color:#fff;"><i class='glyphicon glyphicon-tags'></i> Categorías</a>
        </li>
        <li class="<?php if (isset($active_usuarios)){echo $active_usuarios;}?>">
          <a href="usuarios.php" style="color:#fff;"><i class='glyphicon glyphicon-user'></i> Usuarios</a>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="https://innova-webdev.com/#contact" target="_blank" style="color:#fff;"><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li>
        <li><a href="login.php?logout" style="color:#fff;"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div>

  </div>
</nav>
<?php
    }
?>
