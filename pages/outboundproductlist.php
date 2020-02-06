<?php
    include_once'connectdb.php';
    session_start();
    if($_SESSION['username']=="" OR $_SESSION['role']==""){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
      header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
    }

    if($_SESSION['role']=="Admin"){
    
    
      include_once'header.php';  
   }else{
       
     include_once'headeruser.php';   
   }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Productos Salientes 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Productos Salientes</li>
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
              <h3 class="box-title">Lista de Productos Salientes</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">

                <div style="overflow-x:auto;" > <!-- Inicio scroll para tabla -->
                        <table id ="orderlisttable" class="table table-Striped">
                                <thead>
                                    <tr>
                                        <th>ID pedido</th>
                                        <th>Nombre Vendedor</th>
                                        <th>Fecha de Salida</th>
                                        <th>Total</th>
                                        
                                        <th>Pagó</th>
                                        <th>Diferencia</th>
                                        <th>Tipo de Pago</th>
                                    
                                        <!--<th>Imprimir</th>-->
                                        <th>Ver Productos</th>
                                        <th>Eliminar </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $select=$pdo->prepare("select * from tbl_outbound order by invoice_id asc");//Obtengo los datos
                                    $select->execute();//ejecuto la query
                                    while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                                        echo'<tr>
                                        <td>'.$row->invoice_id.'</td>
                                        <td>'.$row->customer_name.'</td>
                                        <td>'.$row->order_date.'</td>
                                        <td>$ '.$row->total.'</td>
                                        <td>$ '.$row->paid.'</td>
                                        <td>$ '.$row->due.'</td>
                                        <td>'.$row->payment_type.'</td>
                                        
                                        
                                        <td>
                                        <a href="editoutboundproduct.php?id='.$row->invoice_id.'" class="btn btn-info" role="button">
                                        <span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip" title="Editar Orden"></span></a>
                                        </td>
                                        <td>
                                        <button id='.$row->invoice_id.' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Eliminar Orden"></span></button>
                                        </td>
                                        
                                    </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                     </div><!-- Fin scroll para tabla -->
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.Call this function for DATATABLES -->
  <script>
      $(document).ready( function () {
    $('#orderlisttable').DataTable({
        "order":[[0,"asc"]]//Ordenarlos asc o desc
    });
    } );
  </script>
  
   <script>
      $(document).ready( function () {
        $('[data-togle="tooltip"]').tooltip();
    } );

    /** Inicio boton elimiar */

    $(document).ready(function() {
    $('.btndelete').click(function() {
            var tdh = $(this);
            var id = $(this).attr("id");
             swal({
  title: "¿Eliminar pedido?",
  text: "Una vez eliminado, no podra ser recuperado!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
       $.ajax({
                            url: 'outboundproductdelete.php',
                            type: 'post',
                            data: {
                            pidd: id
                            },
                            success: function(data) {
                            tdh.parents('tr').hide();
                            }


                        });
      
      
      
    swal("Pedido eliminado!", {
      icon: "success",
    });
  } else {
    swal("Pedido no eliminado!");
  }
});
            
                     

        });
    });     

    /** FIN boton elimiar */

  </script>
   <!-- /. End Call this function for DATATABLES -->
<?php
  include_once'footer.php';
?>