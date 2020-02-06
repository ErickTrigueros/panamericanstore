<?php
    include_once'connectdb.php';
    session_start();

    if($_SESSION['username']=="" OR $_SESSION['role']=="User"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
        header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
      }

  include_once'header.php';
  if(isset($_POST['btnsave'])){
    $material=$_POST['txtmaterial'];
    if(empty($material)){ //Si esta vacia, se mostrara un mensaje de error
        $error='
        <script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "El campo esta vacio!",
                text: "Por favor llena el campo!",
                icon: "error",
                button: "OK",
              });
            });
            </script>';
            echo $error;
    }
    if(!isset($error)){
        $insert=$pdo->prepare("insert into tbl_material(material) values (:material)");
        $insert->bindParam(':material',$material);
        if($insert->execute()){
            //echo 'Registro exitoso';
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Agregado!",
                text: "Material ingresado con exito!",
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
  }//Fin boton agregar

//Inicio boton update
if(isset($_POST['btnupdate'])){
    $material=$_POST['txtmaterial'];
    $id=$_POST['txtidmat'];
    if(empty($material)){ //Si esta vacia, se mostrara un mensaje de error
        $errorupdate='
        <script type="text/javascript">
            jQuery(function validation(){
            swal({
                title: "Error!",
                text: "El campo esta vacio, por favor ingresar material",
                icon: "error",
                button: "OK",
            });
            });
            </script>';
            echo $errorupdate;
    }
    if(!isset($errorupdate)){
        $update=$pdo->prepare("update tbl_material set material=:material where idmat=".$id);//podemos pasar el placeholder
        $update->bindParam(':material',$material);
        if($update->execute()){
            echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Actualizado!",
                text: "Material actualizado con exito!",
                icon: "success",
                button: "OK",
              });
            });
            </script>';
        
        }else {
            echo '<script type="text/javascript">
            jQuery(function validation(){
            swal({
                title: "Error!",
                text: "Material no actualizado!!",
                icon: "error",
                button: "OK",
            });
            });
            </script>';
        }
    }
}//boton update end here

//Inicio boton delete.
if(isset($_POST['btndelete'])){
    $delete=$pdo->prepare("delete from tbl_material where idmat=".$_POST['btndelete']);//podemos pasar el placeholder
    if($delete->execute()){
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Eliminado!",
            text: "Material eliminado con exito!",
            icon: "success",
            button: "OK",
          });
        });
        </script>';

    }else {
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Error!",
            text: "Material no fue eliminado!",
            icon: "error",
            button: "OK",
          });
        });
        </script>';
    }
}//Fin boton delete
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Materiales 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Materiales</li>
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
              <h3 class="box-title">Agregar Material</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
              <form role="form" action="" method="post"><!--Formulario para editar-->
                  <?php
                  if(isset($_POST['btnedit'])){ //si presiono editar  las categorias, se mostrara otro formulario y escondera el actual
                    $select=$pdo->prepare("select * from tbl_material where idmat=".$_POST['btnedit']);//Obtengo los datos
                    $select->execute();//ejecuto la query
                    if($select){
                        $row=$select->fetch(PDO::FETCH_OBJ);
                        echo'
                    <div class="col-md-4"><!--Columnas divididas en 4-->
                    
                    <div class="form-group">
                    <label >Actualizar Material</label>
                    <input type="hidden" class="form-control" value="'.$row->idmat.'" name="txtidmat" placeholder="Ingresar Material">
                    
                    <input type="text" class="form-control"  value="'.$row->material.'" name="txtmaterial" placeholder="Ingresar Material">

                    </div>
                    <button type="submit" class="btn btn-info" name="btnupdate">Actualizar</button>

                </div>';

                    }

                  }else{// Si no damos click en el boton editar, se mostrara el normal.
                    echo'
                    <div class="col-md-4"><!--Columnas divididas en 4-->
                    
                    <div class="form-group">
                    <label >Material</label>
                    <input type="text" class="form-control" name="txtmaterial" placeholder="Ingresar Material">
                    </div>
                    <button type="submit" class="btn btn-warning" name="btnsave">Guardar</button>

                </div>';
                  }

                  ?>
                <div class="col-md-8"><!--Columnas divididas en 8-->
                    <table id="tablematerial" class="table table-Striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>MATERIAL</th>
                                <th>EDITAR</th>
                                <th>ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $select=$pdo->prepare("select * from tbl_material order by idmat asc");//Obtengo los datos
                             $select->execute();//ejecuto la query
                             while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                                 echo'<tr>
                                    <td>'.$row->idmat.'</td>
                                    <td>'.$row->material.'</td>
                                    <td>
                                    <button type="submit" value="'.$row->idmat.'" class="btn btn-success" name="btnedit">Editar</button>
                                    </td>
                                    <td>
                                    <button type="submit" value="'.$row->idmat.'" class="btn btn-danger" name="btndelete">Eliminar</button>
                                    </td>
                                </tr>';
                             }

                            ?>
                        </tbody>
                    </table>
                    
                </div> 
                </form>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
            
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.Call this function for DATATABLES -->
  <script>
      $(document).ready( function () {
    $('#tablematerial').DataTable();
} );
  </script>
<?php
  include_once'footer.php';
?>
        