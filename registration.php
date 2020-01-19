<?php
    include_once'connectdb.php';
    session_start();
  include_once'header.php';

    error_reporting(0);//elimino los errores que me muestra php
    $id=$_GET['id'];//obtengo el id
    $delete=$pdo->prepare("delete from tbl_user where userid=".$id);
    if($delete->execute()){
        echo '<script type="text/javascript">
                   jQuery(function validation(){
                     swal({
                       title: "Eliminado!",
                       text: "Usuario eliminado!",
                       icon: "success",
                       button: "OK",
                     });
                   });
                   </script>';
    }
    if(isset($_POST['btnsave'])){
    //Guardamos las variables para los usuarios
    $name=$_POST['txtname'];
    $surname=$_POST['txtsurname'];
    $username=$_POST['txtusername'];
    $useremail=$_POST['txtemail'];
    $password=$_POST['txtpassword'];
    $userrole=$_POST['txtselect_option'];
    //echo $name_txt."-" .$surname_txt."-".$username_txt;

    //Inicio validacion Email para insertar datos de usuario
    if(isset($_POST['txtemail'])){
    
        //Con un select traeremos los datos del usuario
        $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");       
        $select->execute();//ejecuto la query

        if($select->rowcount()>0){
            //echo'Email ya existe';
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Advertencia!",
                text: "Usuario con correo ya existe, por favor pruebe con un email diferente!",
                icon: "warning",
                button: "OK",
              });
            });
            </script>';
        }else {
            //Insertar usuarios
            $insert=$pdo->prepare("insert into tbl_user(name, surname, username, useremail, password, role)
            values (:name, :surname, :user, :email,:pass, :role)");
                $insert->bindParam(':name',$name);
                $insert->bindParam(':surname',$surname);
                $insert->bindParam(':user',$username);
                $insert->bindParam(':email',$useremail);
                $insert->bindParam(':pass',$password);
                $insert->bindParam(':role',$userrole);

            if($insert->execute()){
                   //echo 'Registro exitoso';
                   echo '<script type="text/javascript">
                   jQuery(function validation(){
                     swal({
                       title: "Exito!",
                       text: "Usuario ingresado con exito!",
                       icon: "success",
                       button: "OK",
                     });
                   });
                   </script>';

                }else{
                    //echo 'Registro fallo';
                    echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Error!",
            text: "El registro falló!!",
            icon: "error",
            button: "OK",
          });
        });
        </script>';
                }
            }
    }
    //Fin validacion Email y Usuario
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Registro de usuarios
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
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registrar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                    <div class="col-md-4"><!--Columnas divididas en 4-->
                    <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="txtname" placeholder="Ingresar nombre" required>
                    </div>
                    <div class="form-group">
                    <label >Apellido</label>
                    <input type="text" class="form-control" name="txtsurname" placeholder="Ingresar apellido" required>
                    </div>
                    <div class="form-group">
                    <label >Usuario</label>
                    <input type="text" class="form-control" name="txtusername" placeholder="Ingresar usuario" required>
                    </div>
                    <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control" name="txtemail" placeholder="Ingresar correo" required>
                    </div>
                    <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
                    </div>
                    <!-- seleccionar opciones de role -->
                    <div class="form-group">
                    <label>Rol</label>
                    <select class="form-control" name="txtselect_option">
                        <option value="" disabled selected>Seleccionar Rol</option>
                        <option>User</option>
                        <option>Admin</option>
                    </select>
                    </div>

                    <button type="submit" class="btn btn-info" name="btnsave">Registrar</button>

                </div>
                <div class="col-md-8"><!--Columnas divididas en 8-->
                    <table class="table table-Striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select=$pdo->prepare("select * from tbl_user order by userid asc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                                echo'<tr>
                                <td>'.$row->userid.'</td>
                                <td>'.$row->name.'</td>
                                <td>'.$row->surname.'</td>
                                <td>'.$row->username.'</td>
                                <td>'.$row->useremail.'</td>
                                <td>'.$row->password.'</td>
                                <td>'.$row->role.'</td>
                                <td>
                                <a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button">
                                <span class="glyphicon glyphicon-trash" title="delete" </span></a>
                                </td>
                                
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div>

                

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
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