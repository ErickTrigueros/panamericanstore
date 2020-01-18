<?php
  include_once'connectdb.php';
  session_start();
  if($_SESSION['username']==""){//si la variable de sesion que contiene el usuario esta vacia.
    header('location:index.php');//redirigir a index(Login), si tratamos de abrir dashboard.php(Admin) o user.php(USER), no dejara porque la variable de sesion username esta vacia
  }
  if($_SESSION['role']=="Admin"){//si la variable de sesion que contiene el role es Admin, mostrarar el header del admin, si no el de user.
    include_once'header.php';
  }else{
    include_once'headeruser.php';
  }
  // cuando haga click en el boton actualizar voy a obtener los valores de las variables.
  if(isset($_POST['btnupdate'])){
      $oldpassword_txt=$_POST['txtoldpass'];
      $newpassword_txt=$_POST['txtnewpass'];
      $confpassword_txt=$_POST['txtconfpass'];
      //echo $oldpassword_txt."-" .$newpassword_txt."-".$confpassword_txt;
  
      //Con un select traeremos los datos del usuario
      $username=$_SESSION['username'];
      $select=$pdo->prepare("select * from tbl_user where username='$username'");
      
      $select->execute();//ejecuto la query
      $row=$select->fetch(PDO::FETCH_ASSOC);//Obtengo los valores
      
      $username_db = $row['username'];
      $password_db = $row['password'];
      //Comparamos la entras del usuario con los de la BD
      if($oldpassword_txt==$password_db){
       // echo'password match';
        if ($newpassword_txt==$confpassword_txt) {
            //echo'new and confirm password  match';

            //Si las contraseñas coinciden, ejecutar la query
            $update=$pdo->prepare("update tbl_user set password=:pass where username=:user");

            $update->bindParam(':pass',$confpassword_txt);
            $update->bindParam(':user',$username);
            if($update->execute()){
                //echo'password updated';
                 //Mostrando sweetalert
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Exito!",
            text: "Tu contraseña ha sido actualizada",
            icon: "success",
            button: "OK",
          });
        });
        </script>';

            }else{
                //echo'password is not updated';
                //Mostrando sweetalert
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Error!",
            text: "Fallo Consulta",
            icon: "error",
            button: "OK",
          });
        });
        </script>';
            }

        } else {
            //echo'new and confirm password  not match';
            //Mostrando sweetalert
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Oops!!!",
            text: "Las contraseñas no coinciden",
            icon: "warning",
            button: "OK",
          });
        });
        </script>';
        }
        
      }else {
        //echo'password not match';
        //Mostrando sweetalert
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Advertencia!",
            text: "Tu contraseña es invalida, escribe la contraseña correcta",
            icon: "warning",
            button: "OK",
          });
        });
        </script>';
      }
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cambiar Contraseña
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
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cambiar Contraseña</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña actual</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nueva contraseña</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirmar contraseña</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass" required>
                </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Actualizar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>