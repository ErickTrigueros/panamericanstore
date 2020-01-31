<?php
include_once'connectdb.php';
session_start();

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
  header('location:index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
}
  include_once'header.php';

  //Inicio codigo para agregar productos
  if(isset($_POST['btnaddproduct'])){
    //Guardamos en variables para los campos del producto
    $pcode=$_POST['txtpcode'];
    $productname=$_POST['txtpname'];
    $category=$_POST['txtselectcat_option'];
    $style=$_POST['txtselectstyle_option'];
    $material=$_POST['txtselectmat_option'];
    $color=$_POST['txtselectcolor_option'];
    $purchaseprice=$_POST['txtpprice'];
    $saleprice=$_POST['txtsaleprice'];
    $observation=$_POST['txtobservation'];
    $stock=$_POST['txtstock'];
    $description=$_POST['txtdescription'];
      //Inicio codigo para agregar archivos
      $f_name= $_FILES['myfile']['name'];
      $f_tmp= $_FILES['myfile']['tmp_name'];
      $f_size= $_FILES['myfile']['size'];
      $f_extension= explode('.',$f_name);
      $f_extension= strtolower(end($f_extension));
      $f_newfile= uniqid().'.'.$f_extension;
      $store= "productimages/". $f_newfile;//necesitamos crear una carpeta llamada upload

      if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){
        if ($f_size>=1000000) {
         // echo "Archivo debe ser mayor a 1MB"
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
          if(move_uploaded_file($f_tmp, $store)){
            $productimage=$f_newfile;
     
      //Codigo para insertar en db

      if(!isset($error)){
        $insert=$pdo->prepare("insert into tbl_product(pcode,pname,pcategory,pstyle,pmaterial,pcolor,purchaseprice,saleprice,pobservation,pstock,pdescription,pimage)
         values (:pcode,:pname,:pcategory,:pstyle,:pmaterial,:pcolor,:purchaseprice,:saleprice,:pobservation,:pstock,:pdescription,:pimage)");
        $insert->bindParam(':pcode',$pcode);
        $insert->bindParam(':pname',$productname);
        $insert->bindParam('pcategory',$category);
        $insert->bindParam(':pstyle',$style);
        $insert->bindParam(':pmaterial',$material);
        $insert->bindParam(':pcolor',$color);
        $insert->bindParam(':purchaseprice',$purchaseprice);
        $insert->bindParam(':saleprice',$saleprice);
        $insert->bindParam(':pobservation',$observation);
        $insert->bindParam(':pstock',$stock);
        $insert->bindParam(':pdescription',$description);
        $insert->bindParam(':pimage',$productimage);
        if($insert->execute()){
            //echo 'Registro exitoso';
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Agregado!",
                text: "Producto agregado con exito!",
                icon: "success",
                button: "OK",
              });
            });
            </script>';
        }else {
          echo'
         <script type="text/javascript">
             jQuery(function validation(){
               swal({
                 title: "Error!",
                 text: "No se pudo agregar producto!",
                 icon: "error",
                 button: "OK",
               });
             });
             </script>';
        }
      }//FIn codigo inertar en DB
        
          }
        }
        
      }else {
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
      }
      //Fin codigo para agregar archivos



    }
    //Fin codigo para agregar productos
      


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Agregar Productos 
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Regresar a lista de productos</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" name="formproduct" enctype="multipart/form-data"><!--Formulario para agregar productos-->

              <div class="box-body">
              
              <div class="col-md-6"><!--Columnas divididas en 6 para agregar productos-->
              <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" class="form-control" name="txtpcode" placeholder="Ingresar codigo" required>
                    </div>

                    <div class="form-group">
                    <label >Nombre</label>
                    <input type="text" class="form-control" name="txtpname" placeholder="Ingresar nombre" required>
                    </div>
                    <!-- seleccionar categoria -->
                    <div class="form-group">
                    <label>Categoria</label>
                    <select class="form-control" name="txtselectcat_option">
                        <option value="" disabled selected>Seleccionar categoria</option>
                            <!-- codigo para cargar las categorias -->
                            <?php
                            $select=$pdo->prepare("select * from tbl_category order by idcat asc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_ASSOC)){//Recorro los registros los valores
                            extract($row);
                            ?>
                            <option><?php echo $row['category'];?></option>
                           ?>
                            <?php
                            }
                            ?>
                            <!-- Fin codigo para cargar las categorias -->
                        
                    </select>
                    </div>
                    <!-- Fin seleccionar categoria -->
                     <!-- seleccionar estilo -->
                     <div class="form-group">
                    <label>Estilo</label>
                    <select class="form-control" name="txtselectstyle_option">
                        <option value="" disabled selected>Seleccionar estilo</option>
                       <!-- codigo para cargar estilos -->
                       <?php
                            $select=$pdo->prepare("select * from tbl_style order by idstyle asc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_ASSOC)){//Recorro los registros los valores
                            extract($row);
                            ?>
                            <option><?php echo $row['style'];?></option>
                           ?>
                            <?php
                            }
                            ?>
                            <!-- Fin codigo para cargar estilos -->
                    </select>
                    </div>
                    <!-- Fin seleccionar estilo -->
                    <!-- seleccionar Material -->
                    <div class="form-group">
                    <label>Material</label>
                    <select class="form-control" name="txtselectmat_option">
                        <option value="" disabled selected>Seleccionar material</option>
                        <!-- codigo para cargar Material -->
                        <?php
                            $select=$pdo->prepare("select * from tbl_material order by idmat asc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_ASSOC)){//Recorro los registros los valores
                            extract($row);
                            ?>
                            <option><?php echo $row['material'];?></option>
                           ?>
                            <?php
                            }
                            ?>
                            <!-- Fin codigo para cargar material -->
                    </select>
                    </div>
                    <!-- Fin seleccionar Material -->
                    <!-- seleccionar Color -->
                    <div class="form-group">
                    <label>Color</label>
                    <select class="form-control" name="txtselectcolor_option">
                        <option value="" disabled selected>Seleccionar color</option>
                       <!-- codigo para cargar color -->
                       <?php
                            $select=$pdo->prepare("select * from tbl_color order by idcolor asc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_ASSOC)){//Recorro los registros los valores
                            extract($row);
                            ?>
                            <option><?php echo $row['color'];?></option>
                           ?>
                            <?php
                            }
                            ?>
                            <!-- Fin codigo para cargar color -->
                    </select>
                    </div>
                    <!-- Fin seleccionar Color -->
                    <div class="form-group">
                    <label >Precio compra</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="txtpprice" placeholder="Ingresar precio compra" required><!-- minimo de cantidad y step, es el incremento, 1 a 1 -->
                    </div>
                    <div class="form-group">
                    <label>Precio venta</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="txtsaleprice" placeholder="Ingresar precio de venta" required><!-- minimo de cantidad y step, es el incremento, 1 a 1 -->
                    </div>  
                    <div class="form-group">
                    <label>Observaciones</label>
                    <textarea class="form-control" name="txtobservation" placeholder="Ingresar..." rows="4"></textarea>
                    </div>   
     
              </div>


              <div class="col-md-6"><!--Columnas divididas en 6-->
                    <div class="form-group">
                    <label>Existencias</label>
                    <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Ingresar..." required>
                    </div>
                    <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" name="txtdescription" placeholder="Ingresar..." rows="4"></textarea>
                    </div>
                    <div class="form-group">
                    <label>Imagen de producto</label>
                    <input type="file" class="input-group" name="myfile" required>
                    <p>Subir imagen</p>
                    </div>
              

              </div>
          
              </div><!-- end box body-->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info" name="btnaddproduct">Guardar producto</button>
              </div>
              </form>
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>