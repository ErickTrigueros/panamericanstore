<?php
include_once'connectdb.php';
session_start();

  include_once'header.php';
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
            
              <div class="box-body">
              <form role="form" action="" method="post" name="formproduct"><!--Formulario para agregar productos-->

              <div class="col-md-6"><!--Columnas divididas en 6 para agregar productos-->
              <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" class="form-control" name="txtcode" placeholder="Ingresar codigo" required>
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
                        <option value="" disabled selected>Seleccionar categoria</option>
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
                    <input type="number" min="1" step="1" class="form-control" name="txtpprice" placeholder="Ingresar precio compra" required><!-- minimo de cantidad y step, es el incremento, 1 a 1 -->
                    </div>
                    <div class="form-group">
                    <label>Precio venta</label>
                    <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" placeholder="Ingresar precio de venta" required><!-- minimo de cantidad y step, es el incremento, 1 a 1 -->
                    </div>  
                    <div class="form-group">
                    <label>Observaciones</label>
                    <textarea class="form-control" name="txtdescription" placeholder="Ingresar..." rows="4"></textarea>
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
                    <input type="file" class="input-group" name="productimage" required>
                    <p>Subir imagen</p>
                    </div>
              

              </div>
            </form>
              </div><!-- end box body-->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info" name="btnaddproduct">Guardar producto</button>
              </div>
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>