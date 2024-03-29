<?php
    include_once'connectdb.php';
    session_start();
    if($_SESSION['username']=="" OR $_SESSION['role']=="User"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
        header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
      }


  include_once'header.php';

    error_reporting(0);//elimino los errores que me muestra php
    $id=$_GET['id'];//obtengo el id
    $delete=$pdo->prepare("delete from tbl_user where userid=".$id);
    if($delete->execute()){//Inicio If delete
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
    }//Fin If delete
    if(isset($_POST['btnsave'])){
    //Guardamos las variables para los usuarios
    $name=$_POST['txtname'];
    $surname=$_POST['txtsurname'];
    $username=$_POST['txtusername'];
    $useremail=$_POST['txtemail'];
    $password=$_POST['txtpassword'];
    $userrole=$_POST['txtselect_option'];
    //echo $name_txt."-" .$surname_txt."-".$username_txt;
     //Inicio codigo para agregar archivos
     $f_name= $_FILES['myfile']['name'];
     $f_tmp= $_FILES['myfile']['tmp_name'];
     $f_size= $_FILES['myfile']['size'];
     $f_extension= explode('.',$f_name);
     $f_extension= strtolower(end($f_extension));
     $f_newfile= uniqid().'.'.$f_extension;
     $store= "../userimages/". $f_newfile;//necesitamos crear una carpeta llamada userimages

      //Inicio validacion Email para insertar datos de usuario
    
         //////////INICIO INSERTANDO IMAGEN
         if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){//Inivcio validacion para tipos de estension
          if ($f_size>=1000000) {//validacion tamaño de imagen
           // echo "Archivo debe ser menor a 1MB"
           $error='
           <script type="text/javascript">
               jQuery(function validation(){
                 swal({
                   title: "Error!",
                   text: "Archivo debe ser menor a 1MB!",
                   icon: "warning",
                   button: "OK",
                 });
               });
               </script>';
               echo $error;
          } else {
            if(move_uploaded_file($f_tmp, $store)){//Inicio validacion de imagen cargada
              $userimage=$f_newfile;
        //////////////////////////////////////////INSERSION////////////////////////////////////
        if(!isset($error)){//validacion Si no hay  error

         if(isset($_POST['txtemail'])){
    
        //Con un select traeremos los datos del usuario
        $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");       
        $select->execute();//ejecuto la query

        if($select->rowcount()>0){//Inicio para verificar que el usuario con correo a insertar no exista
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
        }
        else {//Inicio Else si el usuario a ingresar no existe
            //Insertar usuarios

            $insert=$pdo->prepare("insert into tbl_user(name, surname, username, useremail, password, role, uimage)
            values (:name, :surname, :user, :email,:pass, :role, :uimage)");
                $insert->bindParam(':name',$name);
                $insert->bindParam(':surname',$surname);
                $insert->bindParam(':user',$username);
                $insert->bindParam(':email',$useremail);
                $insert->bindParam(':pass',$password);
                $insert->bindParam(':role',$userrole);
                $insert->bindParam(':uimage',$userimage);
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
                }//Fin Else si el usuario a ingresar no existe
                }//Fin validacion Email y Usuario

       }//FIn codigo insertar en DB si no hay error ////////// FIN INSERSION//////////
       }//fin de if if(move_uploaded_file     
      }//Fin else si el tamaño de la imagen es adecuado
      }//Fin de if para tipos de extension
      else {
        //echo "Solo puede cargar imagenes jpg, png y gif"
        $error='
         <script type="text/javascript">
             jQuery(function validation(){
               swal({
                 title: "Warning!",
                 text: "Solo puede cargar imagenes jpg, jpeg, png y gif!",
                 icon: "error",
                 button: "OK",
               });
             });
             </script>';
             echo $error;      
      }//Fin else para tipos de extension
      //////////////////////////////////////////FIN INSERSION////////////////////////////////////
    }//Fin btn Save
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Usuarios
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Usuarios</li>
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
              <h3 class="box-title">Agregar usuarios</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" name="formproduct" enctype="multipart/form-data">
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
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="txtpassword" placeholder="Contraseña" required>
                    </div>
                     <!-- seleccionar Role -->
                     <div class="form-group">
                    <label>Rol</label>
                    <select class="form-control" name="txtselect_option">
                        <option value="" disabled selected>Seleccionar Rol</option>
                            <!-- codigo para cargar las categorias -->
                            <?php
                            $select=$pdo->prepare("select * from tbl_role order by idrole asc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_ASSOC)){//Recorro los registros los valores
                            extract($row);
                            ?>
                            <option><?php echo $row['role'];?></option>
                           ?>
                            <?php
                            }
                            ?>
                            <!-- Fin codigo para cargar los roles -->
                        
                    </select>
                    </div>
                    <!-- Fin seleccionar Role -->
                    <!-- Inicio seleccionar Imagen -->
                    <div class="form-group">
                      <label>Imagen de Usuario</label>
                      <input type="file" class="input-group" name="myfile">
                      <p>Subir imagen</p>
                    </div>
                    <!-- Fin seleccionar Imagen -->
                    <button type="submit" class="btn btn-info" name="btnsave">Guardar</button>

                </div>
                <div class="col-md-8" style="overflow-x:auto;"><!--Columnas divididas en 8-->
                
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
                                <th>Imagen</th>
                                <th>Editar</th>
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
                                <td><img src="../userimages/'.$row->uimage.'" class="img-rounded" width="40px" height="40px"/></td>
                                <td>
                                    <a href="edituser.php?id='.$row->userid.'" class="btn btn-info" role="button">
                                    <span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Editar Usuario"></span></a>
                                </td>
                                <td>
                                <a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button">
                                <span class="glyphicon glyphicon-trash" title="delete"></span></a>
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