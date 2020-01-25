<?php
  include_once'connectdb.php';//Incluimos conexion
  session_start();//Iniciamos sesion para cargar todos las variables de sesion

  if($_SESSION['username']==""){//si la variable de sesion que contiene el usuario esta vacia.
    header('location:index.php');//redirigir a index(Login), si tratamos de abrir dashboard.php(Admin) o user.php(USER), no dejara porque la variable de sesion username esta vacia
  }

  
          // Query para traer data de ordenes  e ingresos netos de la BD
        $select = $pdo->prepare("select sum(total) as t , count(invoice_id) as inv from tbl_invoice");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);

        $total_order=$row->inv;

        $net_total=$row->t;
        // Query para traer data de ordenes e ingresos netos  de la BD

        // Query para traer fecha y total de pedidos  de la BD
        $select=$pdo->prepare("select order_date, total from tbl_invoice  group by order_date LIMIT 30");
     
        $select->execute();
                      
        $ttl=[];
        $date=[];              
            
        while($row=$select->fetch(PDO::FETCH_ASSOC)  ){
            
        extract($row);
            
            $ttl[]=$total;
            $date[]=$order_date;
    
    
        }//Fin Query para traer fecha y total de pedidos  de la BD
               // echo json_encode($total);  
        include_once'header.php';    
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Dashboard
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
        <div class="box-body"><!-- Inicio Body-->
            <div class="row"><!-- inicio Body row-->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $total_order;?></h3><!--para nuevos pedidos-->

                  <p>Total de Pedidos</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo "$".number_format($net_total,2);?><sup style="font-size: 20px"></sup></h3>

                  <p>Ingresos Totales</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <!-- Query para traer data de productos totales de la BD-->
            <?php 
                  $select = $pdo->prepare("select count(pname) as p from tbl_product");
                  $select->execute();
                  $row=$select->fetch(PDO::FETCH_OBJ);

                  $total_product=$row->p;
            ?><!-- Query para traer data de productos totales de la BD-->
            
            
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $total_product;?></h3>

                  <p>Total de Productos</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <?php /** Query para traer data de productos totales de la BD-->*/
                $select = $pdo->prepare("select count(category) as cate from tbl_category");
                $select->execute();
                $row=$select->fetch(PDO::FETCH_OBJ);

                $total_category=$row->cate;

             ?><!-- Fin Query para traer data de productos totales de la BD-->

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $total_category;?></h3>

                  <p>Total de Categorias</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div> <!-- Fin Body row-->

          <div class="box box-warning"><!--Inicio box warning-->
            
           
            <div class="box-header with-border">
                <h3 class="box-title">Ganancia por Fecha</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">        
              <div class="chart">
                  <canvas id="earningbydate" style="height:250px"></canvas>    
              </div>
            </div>
          </div><!--fin box warning-->

          <!--Inicia codigo row  para lo mas vendido y ordenes recientes -->
          <div class="row">
              <div class="col-md-6"> <!-- division para lo mas vendido-->
                      
                <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Lo más vendido</h3>
                </div>
                          <!-- /.box-header -->
                          <!-- form start -->
              <div class="box-body">   <!-- inicia lo mas vendido-->     
                      
                <table id="bestsellingproductlist" class="table table-striped">
                      <thead>
                      <tr>
                      <th>ID Producto</th>
                      <th>Codigo Producto</th> 
                      <th>Nombre Producto</th> 
                      <th>Color</th>   
                        <th>Cant.</th>
                        <th>Precio</th>   
                        <th>Total</th>          
                      </tr>    
                          
                      </thead> 
                                
                    <tbody>
                      
                      <?php
                        $select=$pdo->prepare("select product_id,product_code,product_name,product_color,price,sum(qty) as q , sum(qty*price) as total from tbl_invoice_details group by product_id order by sum(qty) DESC LIMIT 15");
                                    
                        $select->execute();
                                    
                        while($row=$select->fetch(PDO::FETCH_OBJ)  ){
                            
                            echo'
                            <tr>
                            <td>'.$row->product_id.'</td>
                            <td>'.$row->product_code.'</td>
                            <td>'.$row->product_name.'</td>
                            <td>'.$row->product_color.'</td>
                            <td><span class="label label-info">'.$row->q.'</span></td>
                            <td><span class="label label-success">'."$".$row->price.'</span></td>
                            <td><span class="label label-danger">'."$".$row->total.'</span></td>
                                </tr>
                            ';
                            
                        }          
                      ?>        
                              
                    </tbody>               
                  </table>            
              </div>
            </div>               
          </div><!--fin division para lo mas vendido-->
                  
          <div class="col-md-6"><!--Inicio division para ordenes recientes-->
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Pedidos Recientes</h3>
                </div>
                          <!-- /.box-header -->
                          <!-- form start -->
              <div class="box-body">    <!--Box body para info del pedido-->    
                      
                <table id="orderlisttable" class="table table-striped">
                  <thead>
                      <tr>
                        <th>ID Pedido</th>
                        <th>Nombre Vendedor</th>   
                          <th>Fecha Pedido</th>   
                          <th>Total</th>   
                          <th>Tipo de Pago</th>        
                      </tr>    
                  </thead>            
                  <tbody>
                      
                    <?php
                    $select=$pdo->prepare("select * from tbl_invoice  order by invoice_id desc LIMIT 15");
                            
                    $select->execute();
                            
                    while($row=$select->fetch(PDO::FETCH_OBJ)  ){
                    
                    echo'
                    <tr>
                    <td><a href="editorder.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
                    <td>'.$row->customer_name.'</td>
                    <td>'.$row->order_date.'</td>
                    <td><span class="label label-danger">'."$".$row->total.'</span></td>';
                    
                    
                    if($row->payment_type=="Cash"){
                        echo'<td><span class="label label-warning">'.$row->payment_type.'</span></td>';
                        
                    }elseif($row->payment_type=="Card"){
                        echo'<td><span class="label label-success">'.$row->payment_type.'</span></td>';
                    }else{
                        echo'<td><span class="label label-primary">'.$row->payment_type.'</span></td>';
                    }
                    
                }          
                ?>        
                              
                </tbody>               
              </table>  
                      
                      
                  </div>
                </div>        
              </div>  <!-- Fin codigo col-md-6 Ordenes recientes-->     
                      
            </div>   
          <!-- Fin codigo row-->

        </div><!-- Fin box Body-->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>/** Codigo para ganancia total */
      var ctx = document.getElementById('earningbydate').getContext('2d');
      var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'bar',

          // The data for our dataset
          data: {
              labels: <?php echo json_encode($date);?>,
              datasets: [{
                  label: 'Ganancia Total',
              backgroundColor: 'rgb(255, 99, 132)',
                  borderColor: 'rgb(255, 99, 132)',
                
                  data:<?php echo json_encode($ttl);?>
              }]
          },

          // Configuration options go here
          options: {}
      });
</script><!--/** Fin Codigo para ganancia total */-->

<!--
    <script>
  $(document).ready( function () {
    $('#bestsellingproductlist').DataTable({
         "order":[[0,"asc"]] 
        
     });
} );  
    
    
</script>
 
 
  <script>
  $(document).ready( function () {
    $('#orderlisttable').DataTable({
        "order":[[0,"desc"]]    
     });
} );  
    
    
</script>
-->

<?php
  include_once'footer.php';
?>