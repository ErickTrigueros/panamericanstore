<?php
include_once'connectdb.php';
error_reporting(0);
session_start();

  include_once'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ventas->Reporte tabular
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
        <div class="box box-warning">
            <form  action="" method="post" name="">
            <div class="box-header with-border">
            <h3 class="box-title">Desde : <?php echo $_POST['date_1']?> -- Hasta : <?php echo $_POST['date_2']?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body"> <!-- ********inicio Body para table report******-->
<!--Inicio row de date picker-->
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
                                    <input type="submit" name="btndatefilter" value="Filtrar por fecha" class="btn btn-success">
                                </div>  
                            </div>                         
                </div> <!--Fin codigo row de date picker--> 
                <br>
                     <br>
                <!--Mostrando info de la data para el box info-->
                <?php
             
                        $select=$pdo->prepare("select sum(total) as total , sum(subtotal) as stotal,count(invoice_id) as invoice from tbl_invoice  where order_date between :fromdate AND :todate");
                        $select->bindParam(':fromdate',$_POST['date_1']);  
                                $select->bindParam(':todate',$_POST['date_2']);  
                                
                        $select->execute();
                                
                    $row=$select->fetch(PDO::FETCH_OBJ);
                        
                    $net_total=$row->total;
                                        
                    $stotal=$row->stotal;
                                        
                    $invoice=$row->invoice;                    
 
                  ?>
                  <!--Fin Mostrando info de la data para el box info-->
                
                             <!-- Info boxes -->
                <div class="row"><!--Inicio codigo row de info boxes--> 
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Total Facturado</span>
                        <span class="info-box-number"><h2><?php echo number_format($invoice); ?></h2></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Sub Total</span>
                            <span class="info-box-number"><h2><?php echo number_format($stotal,2); ?></h2></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-usd"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Total Neto</span>
                            <span class="info-box-number"><h2><?php echo number_format($net_total,2); ?></h2></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row --> <!--Fin  codigo row de info boxes--> 
                <br>
                 
                                     
                <table id="salesreporttable" class="table table-striped"><!-- Fin table  info pedidos-->
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Nombre Vendedor</th> 
                                    <th>Subtotal</th>  
                                    <th>Impuesto(0%)</th> 
                                    <th>Descuento</th>  
                                    <th>Total</th>   
                                    <th>Pagó</th>
                                    <th>Diferencia</th>
                                    <th>Fecha de Pedido</th> 
                                    <th>Tipo de pago</th>        
                            </tr>    
                                
                        </thead>              
                    <tbody>
                        <!--Inicio traer datos de la BD-->   
                        <?php
                            $select=$pdo->prepare("select * from tbl_invoice  where order_date between :fromdate AND :todate");
                            $select->bindParam(':fromdate',$_POST['date_1']);  
                                    $select->bindParam(':todate',$_POST['date_2']);  
                                    
                            $select->execute();
                                    
                        while($row=$select->fetch(PDO::FETCH_OBJ)  ){
                            
                            echo'
                            <tr>
                            <td>'.$row->invoice_id.'</td>
                            <td>'.$row->customer_name.'</td>
                            <td>'.$row->subtotal.'</td>
                            <td>'.$row->tax.'</td>
                            <td>'.$row->discount.'</td>
                            <td><span class="label label-danger">'."$".$row->total.'</span></td>
                            <td>'.$row->paid.'</td>
                            <td>'.$row->due.'</td>
                            <td>'.$row->order_date.'</td>
                            ';
                            /**--Fin traer datos de la BD */

                            /**--Inicio para verificar el tipo de pago y agregar clase info o warning */
                            if($row->payment_type=="Cash"){
                                
                            echo'<td><span class="label label-primary">'.$row->payment_type.'</span></td>';  
                            }elseif($row->payment_type=="Card"){
                                echo'<td><span class="label label-warning">'.$row->payment_type.'</span></td>';  
                            }else{
                                echo'<td><span class="label label-info">'.$row->payment_type.'</span></td>';
                            }  
                            /**--Fin para verificar el tipo de pago */
                        }          
                        ?>        
                   
                    </tbody>               
                </table><!-- Fin table  info pedidos-->

            </div><!--******* Fin Body para table report******-->
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Codigo JS-->
  <script>
 
    //Date picker1
    $('#datepicker1').datepicker({
        autoclose: true
    });
      
      
      
    //Date picker2
    $('#datepicker2').datepicker({
        autoclose: true
    });  

     //data table plugin
    $('#salesreporttable').DataTable({
        
        "order":[[0,"desc"]]    
    
            
        });

    </script>
    <!-- Codigo JS-->
<?php
  include_once'footer.php';
?>