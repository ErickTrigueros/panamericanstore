<?php
    include_once'connectdb.php';
    session_start();
    if($_SESSION['username']=="" OR $_SESSION['role']=="User"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
        header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
      }


  include_once'header.php';

    error_reporting(0);//elimino los errores que me muestra php
    $id=$_GET['id'];//obtengo el id
    //Inicio select para traer los valores de los usuarios
    $select=$pdo->prepare("select * from tbl_user where userid =$id");//Obtengo los datos
    $select->execute();//ejecuto la query
    $row=$select->fetch(PDO::FETCH_ASSOC);//Recorro los registros los valores
      $name_db=$row['name'];
      $surname_db=$row['surname'];
      $username_db = $row['username'];
      $useremail_db = $row['useremail'];
      $password_db = $row['password'];
      $role_db = $row['role'];
      $image_db = $row['uimage'];
    //Fin  select para traer los valores de los usuarios

    if(isset($_POST['btnupdateuser'])){
    //Guardamos las variables para los usuarios
    $name=$_POST['txtname'];
    $surname=$_POST['txtsurname'];
    $username=$_POST['txtusername'];
    $useremail=$_POST['txtemail'];
    $password=$_POST['txtpassword'];
    $userrole=$_POST['txtselect_option'];
    //echo $name_txt."-" .$surname_txt."-".$username_txt;
     //Inicio codigo para agregar archivos
    //inicio update img+++++++++++++++++++++++++++
    
     $f_name= $_FILES['myfile']['name'];
     if(!empty($f_name)){//Inicio si el nombre de archivo esta vacio.
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
              $f_newfile;
        //////////////////////////////////////////INSERSION////////////////////////////////////
        if(!isset($error)){//validacion Si no hay  error

        if(isset($_POST['txtemail'])){
    
        //Con un select traeremos los datos del usuario
        $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");       
        $select->execute();//ejecuto la query

        if($select->rowcount()>1){//Inicio para verificar que el usuario con correo a insertar no exista
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

            $update=$pdo->prepare("update tbl_user set name=:name, surname=:surname, username=:username, useremail=:useremail,
            password=:password, role=:role, uimage=:uimage where userid= $id");
                $update->bindParam(':name',$name);
                $update->bindParam(':surname',$surname);
                $update->bindParam(':username',$username);
                $update->bindParam(':useremail',$useremail);
                $update->bindParam(':password',$password);
                $update->bindParam(':role',$userrole);
                $update->bindParam(':uimage',$f_newfile);
            if($update->execute()){
                   //echo 'Registro exitoso';
                   echo '<script type="text/javascript">
                   jQuery(function validation(){
                     swal({
                       title: "Actualizado!",
                       text: "Usuario Actualizado con exito!",
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
            text: "No se pudo actualizar el usuario!!",
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
    }//Fin IF si el nombre de la imagen esta vacio
    else{//Else Si no hay imagen nueva, guardar la misma de la BD
      if(isset($_POST['txtemail'])){
    
        //Con un select traeremos los datos del usuario
        $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");       
        $select->execute();//ejecuto la query

        if($select->rowcount()>1){//Inicio para verificar que el usuario con correo a insertar no exista
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
      $update=$pdo->prepare("update tbl_user set name=:name, surname=:surname, username=:username, useremail=:useremail,
      password=:password, role=:role, uimage=:uimage where userid= $id");
          $update->bindParam(':name',$name);
          $update->bindParam(':surname',$surname);
          $update->bindParam(':username',$username);
          $update->bindParam(':useremail',$useremail);
          $update->bindParam(':password',$password);
          $update->bindParam(':role',$userrole);
          $update->bindParam(':uimage',$image_db);
      if($update->execute()){
             //echo 'Registro exitoso';
             echo '<script type="text/javascript">
             jQuery(function validation(){
               swal({
                 title: "Actualizado!",
                 text: "Usuario Actualizado con exito!",
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
                text: "No se pudo actualizar el Usuario por imagen nueva!!",
                icon: "error",
                button: "OK",
              });
            });
            </script>';
          }
          }//Fin Else si el usuario a ingresar no existe
                }//Fin validacion Email y Usuario

    }//Fin Else Si no hay imagen nueva, guardar la misma de la BD
    
    }//Fin btn Edit User

    //inicio codigo para poner las nuevas variables actualizadas en el formulario 
    $select=$pdo->prepare("select * from tbl_user where userid =$id");//Obtengo los datos
    $select->execute();//ejecuto la query
    $row=$select->fetch(PDO::FETCH_ASSOC);//Recorro los registros los valores
      $name_db=$row['name'];
      $surname_db=$row['surname'];
      $username_db = $row['username'];
      $useremail_db = $row['useremail'];
      $password_db = $row['password'];
      $role_db = $row['role'];
      $image_db = $row['uimage'];
      //Fincodigo para poner las nuevas variables actualizadas en el formulario
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar Usuario
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Editar Usuario</li>
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
              <h3 class="box-title"><a href="registration.php" class="btn btn-primary" role="button">Regresar a lista de Usuarios</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" name="formproduct" enctype="multipart/form-data">
              <div class="box-body">
                    <div class="col-md-4"><!--Columnas divididas en 4-->
                    <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="txtname" value="<?php echo $name_db;?>" placeholder="Ingresar nombre" required>
                    </div>
                    <div class="form-group">
                    <label >Apellido</label>
                    <input type="text" class="form-control" name="txtsurname" value="<?php echo $surname_db;?>" placeholder="Ingresar apellido" required>
                    </div>
                    <div class="form-group">
                    <label >Usuario</label>
                    <input type="text" class="form-control" name="txtusername" value="<?php echo $username_db;?>" placeholder="Ingresar usuario" required>
                    </div>
                    <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control" name="txtemail" value="<?php echo $useremail_db;?>" placeholder="Ingresar correo" required>
                    </div>
                    <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="txtpassword"value="<?php echo $password_db;?>" placeholder="Contraseña" required>
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
                             <option <?php if($row['role']==$role_db) {?>
                                selected = "selected"
                                <?php } ?> >

                          
                            <?php echo $row['role'];?>
                           
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
                      <img src="../userimages/<?php echo $image_db; ?>" class="img-responsive" width="50px" height="50px"/>
                      <input type="file" class="input-group" name="myfile">
                      <p>Subir imagen</p>
                    </div>
                    <!-- Fin seleccionar Imagen -->
                    

                </div> 

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <button type="submit" class="btn btn-warning" name="btnupdateuser">Actualizar Usuario</button>
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