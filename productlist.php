<?php
include_once'connectdb.php';
session_start();

if($_SESSION['username']=="" OR $_SESSION['role']=="User"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
  header('location:index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
}

  include_once'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Productos 
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

           <!-- INICIO DE LISTADO DE PRODUCTOS -->
           <div class="box box-warning">
                <div class="box-header with-border">
                <h3 class="box-title">Lista de productos</h3>
                </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                <div style="overflow-x:auto;" > <!-- Inicio scroll para tabla -->
                    <table id ="producttable" class="table table-Striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    
                                    <th>Material</th>
                                    <th>Color</th>
                                    <th>Precio compra</th>
                                    <th>Precio venta</th>
                                    
                                    <th>Existencias</th>
                                    
                                    <th>Imagen</th>
                                    <th>Ver</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select=$pdo->prepare("select * from tbl_product order by idp asc");//Obtengo los datos
                                $select->execute();//ejecuto la query
                                while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                                    echo'<tr>
                                    <td>'.$row->idp.'</td>
                                    <td>'.$row->pcode.'</td>
                                    <td>'.$row->pname.'</td>
                                    <td>'.$row->pcategory.'</td>
                                    
                                    <td>'.$row->pmaterial.'</td>
                                    <td>'.$row->pcolor.'</td>
                                    <td>'.$row->purchaseprice.'</td>
                                    <td>'.$row->saleprice.'</td>
                                    
                                    <td>'.$row->pstock.'</td>
                                    
                                    <td><img src="productimages/'.$row->pimage.'" class="img-rounded" width="40px" height="40px"/></td>
                                    <td>
                                    <a href="viewproduct.php?id='.$row->idp.'" class="btn btn-success" role="button">
                                    <span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip" title="Ver Producto"></span></a>
                                    </td>
                                    <td>
                                    <a href="editproduct.php?id='.$row->idp.'" class="btn btn-info" role="button">
                                    <span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Editar Producto"></span></a>
                                    </td>
                                    <td>
                                    <button id='.$row->idp.' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Eliminar Producto"></span></button>
                                    </td>
                                    
                                </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                      </div><!-- Fin scroll para tabla -->
                </div>
            </div><!-- FIN DE LISTADO DE PRODUCTOS -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <!-- /.Call this function for DATATABLES -->
   <script>
      $(document).ready( function () {
    $('#producttable').DataTable({
        "order":[[0,"asc"]]//Ordenarlos asc o desc
    });
    } );
  </script>
   <!-- /.Call this function for DATATABLES -->
   <script>
      $(document).ready( function () {
        $('[data-togle="tooltip"]').tooltip();
    } );
  </script>

  <!-- Start Script para eliminar producto-->
        <script>
          $(document).ready(function() {
          $('.btndelete').click(function() {
                  var tdh = $(this);
                  var id = $(this).attr("id");
                  swal({
        title: "¿Eliminar producto?",
        text: "Una vez eliminado, no podras recuperarlo!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            
            $.ajax({
                                  url: 'productdelete.php',
                                  type: 'post',
                                  data: {
                                  pidd: id
                                  },
                                  success: function(data) {
                                  tdh.parents('tr').hide();
                                  }
                              });
          swal("Producto eliminado!", {
            icon: "success",
          });
        } else {
          swal("Producto no eliminado!");
        }
      });
              });
          });   
      </script>
<!-- End Script para eliminar producto-->

<?php
  include_once'footer.php';
?>