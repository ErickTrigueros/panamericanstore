<?php
    include_once'connectdb.php';
    session_start();
    if($_SESSION['username']=="" OR $_SESSION['role']=="Admin"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
        header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
      }


  include_once'headeruser.php';

    error_reporting(0);//elimino los errores que me muestra php
    $id=$_GET['id'];//obtengo el id
    //Inicio select para traer los valores de los usuarios
    $select=$pdo->prepare("select * from tbl_user where userid =$id");//Obtengo los datos
    $select->execute();//ejecuto la query
    $row=$select->fetch(PDO::FETCH_ASSOC);//Recorro los registros los valores
      
      $image_db = $row['uimage'];
    //Fin  select para traer los valores de los usuarios

    if(isset($_POST['btnupdateuser'])){
    //Guardamos las variables para los usuarios
    
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

            //Insertar usuarios

            $update=$pdo->prepare("update tbl_user set uimage=:uimage where userid= $id");
                
                $update->bindParam(':uimage',$f_newfile);
            if($update->execute()){
                   //echo 'Registro exitoso';
                   echo '<script type="text/javascript">
                   jQuery(function validation(){
                     swal({
                       title: "Imagen Actualizada!",
                       text: "Para ver cambios vuelva a catalogo de productos!",
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
            text: "No se pudo actualizar la imagen!!",
            icon: "error",
            button: "OK",
          });
        });
        </script>';
                }

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
      $update=$pdo->prepare("update tbl_user set uimage=:uimage where userid= $id");
          $update->bindParam(':uimage',$image_db);
      if($update->execute()){
             //echo 'Registro exitoso';
             echo '<script type="text/javascript">
             jQuery(function validation(){
               swal({
                 title: "Actualizada!",
                 text: "Imagen Actualizada con exito, para ver cambios vuelva a catalogo de productos!",
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
                text: "No se pudo actualizar la imagen!!",
                icon: "error",
                button: "OK",
              });
            });
            </script>';
          }

    }//Fin Else Si no hay imagen nueva, guardar la misma de la BD
    
    }//Fin btn Edit User

    //inicio codigo para poner las nuevas variables actualizadas en el formulario 
    $select=$pdo->prepare("select * from tbl_user where userid =$id");//Obtengo los datos
    $select->execute();//ejecuto la query
    $row=$select->fetch(PDO::FETCH_ASSOC);//Recorro los registros los valores
      $image_db = $row['uimage'];
      //Fincodigo para poner las nuevas variables actualizadas en el formulario
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Actualizar Imagen
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>User</a></li>
        <li class="active">Actualizar Imagen</li>
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
              <h3 class="box-title"><a href="user.php" class="btn btn-primary" role="button">Regresar catalogo</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" name="formproduct" enctype="multipart/form-data">
              <div class="box-body">
                    <div class="col-md-4"><!--Columnas divididas en 4-->
                    
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
              <button type="submit" class="btn btn-warning" name="btnupdateuser">Actualizar Imagen</button>
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