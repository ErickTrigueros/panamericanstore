<?php
include_once'connectdb.php';
error_reporting(0);
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
      Reporte Gráfico
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
          <div class="box box-warning">
            <form  action="" method="post" name="">
           
            <div class="box-header with-border">
                <h3 class="box-title">Desde : <?php echo $_POST['date_1']?> -- Hasta : <?php echo $_POST['date_2']?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
        <div class="box-body">
                    
        <div class="row">
            
        <div class="col-md-5">
            
            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
        <input type="text" class="form-control pull-right" id="datepicker1" name="date_1"  data-date-format="yyyy-mm-dd" >
                            </div> 
            
        </div>   
           
        <div class="col-md-5">
            
             <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
        <input type="text" class="form-control pull-right" id="datepicker2" name="date_2"  data-date-format="yyyy-mm-dd" >
                            </div> 
            
        </div>    
           
        <div class="col-md-2">
             <div align="left">
                    <input type="submit" name="btndatefilter" value="Filtrar por Fecha" class="btn btn-success">

                </div>   
        </div>                  
        </div>  
                     <br>
                     <br>   
        <!--Inicio de Query para mostrar datos ventas -->         
        <?php
            $select=$pdo->prepare("select order_date, sum(total) as price from tbl_invoice  where order_date between :fromdate AND :todate group by order_date");
            $select->bindParam(':fromdate',$_POST['date_1']);  
            $select->bindParam(':todate',$_POST['date_2']);  
                    
            $select->execute();
                          
            $total=[];
            $date=[];              
                              
            while($row=$select->fetch(PDO::FETCH_ASSOC)  ){
                      
               extract($row);
                      
                $total[]=$price;
                $date[]=$order_date;
                
                
            }
                          // echo json_encode($total);                    
        ?> <!--Fin de Query para mostrar datos ventas --> 
          <div class="chart">
              <canvas id="myChart" style="height:250px"></canvas>    
          </div>
        <?php
          $select=$pdo->prepare("select product_name, sum(qty) as q from tbl_invoice_details  where order_date between :fromdate AND :todate group by product_id");
          $select->bindParam(':fromdate',$_POST['date_1']);  
          $select->bindParam(':todate',$_POST['date_2']);  
                  
          $select->execute();
                        
          $pname=[];
          $qty=[];              
                  
          while($row=$select->fetch(PDO::FETCH_ASSOC)  ){
          
          extract($row);
          
          $pname[]=$product_name;
          $qty[]=$q;
          
          
            }
                    // echo json_encode($total);  
        ?>
                  <div class="chart">
                      <canvas id="bestsellingproduct" style="height:250px"></canvas>  
                  </div>
    
              </div>
              </form>
               </div>
    </section>
    <!--/.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <script>/** Script para calcular la ganancia */
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar', //line, pie,radar

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date);?>,
        datasets: [{
            label: 'Ganancia Total',
        backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
           
            data:<?php echo json_encode($total);?>
        }]
    },

    // Configuration options go here
    options: {}
});

</script><!--Fin Script para calcular la ganancia */-->
 
 
 <script>/** Script para calcular producto mas vendido */
var ctx = document.getElementById('bestsellingproduct').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($pname);?>,
        datasets: [{
            label: 'Cantidad Total',
             backgroundColor: 'rgb(102, 255, 102)',
            borderColor: 'rgb(0, 102, 0)',
            data:<?php echo json_encode($qty);?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script> <!--Fin Script para calcular producto mas vendido */-->

  <script>/** Script para date pickers */

    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true
    });
      
      
      
    //Date picker
    $('#datepicker2').datepicker({
        autoclose: true
    });  
 
</script><!-- Fin Script para date pickers */-->
  

  <?php

include_once'footer.php';

?>
