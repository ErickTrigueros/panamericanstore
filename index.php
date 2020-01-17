
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- Sweetalert plugin -->
<script src="bower_components/sweetalert/sweetalert.js"></script>

<?php
  include_once'connectdb.php';
  session_start();
  if(isset($_POST['btn_login'])){
    $username = $_POST['txt_username'];
    $password = $_POST['txt_password'];

    //echo $username." - ".$password;
    $select = $pdo->prepare("select * from tbl_user where 
    username='$username' AND password='$password'");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);//Obtnego los valores en esta row
    //Validamos si los datos son correctos, y verificamos tipo de USER y mostramos los mensajes
    if($row['username']==$username AND
      $row['password']==$password AND $row['role']=="Admin"){//Todos se debe cumplir si es Admin
        //Guardamos todo en variables de sesion para poder usarlas porteriormente
        $_SESSION['userid']=$row['userid'];
        $_SESSION['name']=$row['name'];
        $_SESSION['surname']=$row['surname'];
        $_SESSION['username']=$row['username'];
        $_SESSION['useremail']=$row['useremail'];
        $_SESSION['role']=$row['role'];
        //Mostrando sweetalert
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Good job!'.$_SESSION['nombre'].'",
            text: "Login Exitoso!",
            icon: "success",
            button: "Loading....",
          });
        });
        </script>';
        header('refresh:2;dashboard.php');//se redirigirá a dashboard.php después de 1 seg
      }else if($row['username']==$username AND
      $row['password']==$password AND $row['role']=="User"){// si es User
        //Guardamos todo en variables de sesion para poder usarlas porteriormente
        $_SESSION['userid']=$row['userid'];
        $_SESSION['name']=$row['name'];
        $_SESSION['surname']=$row['surname'];
        $_SESSION['username']=$row['username'];
        $_SESSION['useremail']=$row['useremail'];
        $_SESSION['role']=$row['role'];
        //Mostrando sweetalert
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Good job!'.$_SESSION['nombre'].'",
            text: "Login Exitoso!",
            icon: "success",
            button: "Loading....",
          });
        });
        </script>';
        header('refresh:1;user.php');//se redirigirá a user.php después de 1 seg

    }else{
      echo 'login fail';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Panamerican Store| Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Panamerican</b>Store</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Logueate para iniciar sesion</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="txt_username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="txt_password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        <a href="#">Olvide mi contraseña</a><br>
         <!-- CODE checkbox DELETED -->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_login">Login In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   <!-- CODE Log in with Social Network DELETED -->
    <!-- /.social-auth-links -->

    
    <!-- CODE register a membership DELETED -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
