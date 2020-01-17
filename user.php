<?php
include_once'connectdb.php';//Incluimos conexion
session_start();//Iniciamos sesion para cargar todos las variables de sesion

if($_SESSION['username']==""){//si la variable de sesion que contiene el usuario esta vacia.
  header('location:index.php');//redirigir a index(Login), si tratamos de abrir dashboard.php(Admin) o user.php(USER), no dejara porque la variable de sesion username esta vacia
}
  include_once'headeruser.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User dashboard 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>