<?php
include_once'connectdb.php';
session_start();

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
    header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
  }

  include_once'header.php';
//Inicio editar producto
$id = $_GET['id'];
$select=$pdo->prepare("select * from tbl_product where idp =$id");//Obtengo los datos
$select->execute();//ejecuto la query
$row=$select->fetch(PDO::FETCH_ASSOC);//Recorro los registros los valores
    $code_db=$row['pcode'];
    $productname_db=$row['pname'];
    $category_db = $row['pcategory'];
    $style_db = $row['pstyle'];
    $material_db = $row['pmaterial'];
    $color_db = $row['pcolor'];
    $purchaseprice_db = $row['purchaseprice'];
    $saleprice_db = $row['saleprice'];
    $observation_db = $row['pobservation'];
    $stock_db = $row['pstock'];
    $description_db = $row['pdescription'];
    $image_db = $row['pimage'];
    //print_r($row); //Linea para imprimir el producto.
//fin editar producto

//inicio codigo de boton actualizar producto
  //Inicio codigo para agregar productos
  if(isset($_POST['btnupdateproduct'])){
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
      //inicio update img+++++++++++++++++++++++++++
      if(!empty($f_name)){//Inicio si el nombre esta vacio.
        $f_tmp= $_FILES['myfile']['tmp_name'];
        $f_size= $_FILES['myfile']['size'];
        $f_extension= explode('.',$f_name);
        $f_extension= strtolower(end($f_extension));
        $f_newfile= uniqid().'.'.$f_extension;
        $store= "../productimages/". $f_newfile;//necesitamos crear una carpeta llamada upload
  
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
              $f_newfile;
       
        //Codigo para insertar en db
  
        if(!isset($error)){
          $update=$pdo->prepare("update tbl_product set pcode=:pcode, pname=:pname, pcategory=:pcategory, pstyle=:pstyle, pmaterial=:pmaterial,
          pcolor=:pcolor, purchaseprice=:purchaseprice, saleprice=:saleprice, pobservation=:pobservation, pstock=:pstock, pdescription=:pdescription,
          pimage=:pimage where idp =$id ");
          $update->bindParam(':pcode',$pcode);
          $update->bindParam(':pname',$productname);
          $update->bindParam('pcategory',$category);
          $update->bindParam(':pstyle',$style);
          $update->bindParam(':pmaterial',$material);
          $update->bindParam(':pcolor',$color);
          $update->bindParam(':purchaseprice',$purchaseprice);
          $update->bindParam(':saleprice',$saleprice);
          $update->bindParam(':pobservation',$observation);
          $update->bindParam(':pstock',$stock);
          $update->bindParam(':pdescription',$description);
          $update->bindParam(':pimage',$f_newfile);
          if($update->execute()){
              //echo 'Registro exitoso';
              echo '<script type="text/javascript">
              jQuery(function validation(){
                swal({
                  title: "Producto actualizado con exito!",
                  text: "Actualizado!",
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
                   title: "No se pudo actualizar producto!",
                   text: "Error!",
                   icon: "error",
                   button: "OK",
                 });
               });
               </script>';
          }
        }//FIn codigo inertar en DB si no hay error.
          
            }//Fin if (move_uploaded)
          }//Fin Else Size
          
        }//Fin if Extension
        else {//Inicio If extension de imagen
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
        
      }//Fin IF si el nombre de la imagen esta vacio
      else {//Else Si no hay imagen nueva, guardar la misma de la BD
        $update=$pdo->prepare("update tbl_product set pcode=:pcode, pname=:pname, pcategory=:pcategory, pstyle=:pstyle, pmaterial=:pmaterial,
        pcolor=:pcolor, purchaseprice=:purchaseprice, saleprice=:saleprice, pobservation=:pobservation, pstock=:pstock, pdescription=:pdescription,
        pimage=:pimage where idp =$id ");
        $update->bindParam(':pcode',$pcode);
        $update->bindParam(':pname',$productname);
        $update->bindParam('pcategory',$category);
        $update->bindParam(':pstyle',$style);
        $update->bindParam(':pmaterial',$material);
        $update->bindParam(':pcolor',$color);
        $update->bindParam(':purchaseprice',$purchaseprice);
        $update->bindParam(':saleprice',$saleprice);
        $update->bindParam(':pobservation',$observation);
        $update->bindParam(':pstock',$stock);
        $update->bindParam(':pdescription',$description);
        $update->bindParam(':pimage',$image_db);
        if($update->execute()){
          //echo 'Registro exitoso';
          $error= '<script type="text/javascript">
          jQuery(function validation(){
            swal({
              title: "Producto actualizado con exito!",
              text: "Actualizado!",
              icon: "success",
              button: "OK",
            });
          });
          </script>';
          echo $error;
      }else {
        $error='
       <script type="text/javascript">
           jQuery(function validation(){
             swal({
               title: "No se pudo actualizar producto!",
               text: "Error!",
               icon: "error",
               button: "OK",
             });
           });
           </script>';
           echo $error;
      }
    }//FIn codigo actualizar en DB
    //Fin codigo para actualizar img+++++++++

      }//Fin btn edit product

      //inicio codigo para poner las nuevas variables actualizadas en el formulario 
      $select=$pdo->prepare("select * from tbl_product where idp =$id");//Obtengo los datos
$select->execute();//ejecuto la query
$row=$select->fetch(PDO::FETCH_ASSOC);//Recorro los registros los valores
    $code_db=$row['pcode'];
    $productname_db=$row['pname'];
    $category_db = $row['pcategory'];
    $style_db = $row['pstyle'];
    $material_db = $row['pmaterial'];
    $color_db = $row['pcolor'];
    $purchaseprice_db = $row['purchaseprice'];
    $saleprice_db = $row['saleprice'];
    $observation_db = $row['pobservation'];
    $stock_db = $row['pstock'];
    $description_db = $row['pdescription'];
    $image_db = $row['pimage'];
  //Fincodigo para poner las nuevas variables actualizadas en el formulario
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar producto 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Editar Producto</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <!-- general form elements -->
        <div class="box box-warning">
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
                    <input type="text" class="form-control" name="txtpcode" value="<?php echo $code_db;?>" placeholder="Ingresar codigo" required>
                    </div>

                    <div class="form-group">
                    <label >Nombre</label>
                    <input type="text" class="form-control" name="txtpname" value="<?php echo $productname_db;?>" placeholder="Ingresar nombre" required>
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
                                
                                <option <?php if($row['category']==$category_db) {?>
                                selected = "selected"
                                <?php } ?> >

                                <?php echo $row['category'];?></option>
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
                            <option <?php if($row['style']==$style_db) {?>
                                selected = "selected"
                                <?php } ?> >

                                <?php echo $row['style'];?></option>
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
                            <option <?php if($row['material']==$material_db) {?>
                                selected = "selected"
                                <?php } ?> >

                                <?php echo $row['material'];?></option>
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
                            <option <?php if($row['color']==$color_db) {?>
                                selected = "selected"
                                <?php } ?> >

                                <?php echo $row['color'];?></option>
                            <?php
                            }
                            ?>
                            <!-- Fin codigo para cargar color -->
                    </select>
                    </div>
                    <!-- Fin seleccionar Color -->
                    <div class="form-group">
                    <label >Precio compra</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="txtpprice" value="<?php echo $purchaseprice_db;?>" placeholder="Ingresar precio compra" required><!-- minimo de cantidad y step, es el incremento, 1 a 1 -->
                    </div>
                    <div class="form-group">
                    <label>Precio venta</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="txtsaleprice" value="<?php echo $saleprice_db;?>" placeholder="Ingresar precio de venta" required><!-- minimo de cantidad y step, es el incremento, 1 a 1 -->
                    </div>  
                    <div class="form-group">
                    <label>Observaciones</label>
                    <textarea class="form-control" name="txtobservation" placeholder="Ingresar..." rows="4"><?php echo $observation_db;?></textarea>
                    </div>   
     
              </div>


              <div class="col-md-6"><!--Columnas divididas en 6-->
                    <div class="form-group">
                    <label>Existencias</label>
                    <input type="number" min="1" step="1" class="form-control" name="txtstock" value="<?php echo $stock_db;?>" placeholder="Ingresar..." required>
                    </div>
                    <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" name="txtdescription" placeholder="Ingresar..." rows="4"><?php echo $description_db;?></textarea>
                    </div>
                    <div class="form-group">
                    <label>Imagen de producto</label>

                    <img src="../productimages/<?php echo $image_db; ?>" class="img-responsive" width="50px" height="50px"/>

                    <input type="file" class="input-group" name="myfile">
                    <p>Subir imagen</p>
                    </div>
              

              </div>
          
            </div>
            <div class="box-footer">
                
                <button type="submit" class="btn btn-warning" name="btnupdateproduct">Actualizar producto</button>
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