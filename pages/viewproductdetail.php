<?php

include_once'connectdb.php';
session_start();
if($_SESSION['username']=="" OR $_SESSION['role']=="Admin"){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
    header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
  }
  include_once'headeruser.php';

  if(isset($_POST['btnsaveorder'])){
    //Obtengo datos de campos de texto y guardo en variables para guardar en tbl_invoice
    $customer_name=$_POST['txtcustomer'];
    $order_date=date('Y-m-d',strtotime($_POST['orderdate']));
    $subtotal=$_POST["txtsubtotal"];
    $tax=$_POST['txttax'];
    $discount=$_POST['txtdiscount'];
    $total=$_POST['txttotal']-$_POST['txtdiscount'];//Total menos descuento.
    $paid=$_POST['txtpaid'];
    $due=$_POST['txtdue']-$_POST['txtdiscount'];
    $payment_type=$_POST['rb'];
    //fin Obtengo datos de campos de texto y guardo en variables para guardar en tbl_invoice
    ////////////////////////////////
    
    //tenemos array de valores en las variables para insertar en tbl_invoice details
    $arr_productid=$_POST['productid'];
    $arr_productname=$_POST['productname'];
    $arr_pcode=$_POST['code'];// NEW se toman de los inputs
    $arr_pcolor=$_POST['color'];// NEW se toman de los inputs
    $arr_stock=$_POST['stock'];
    $arr_qty=$_POST['qty'];
    $arr_price=$_POST['price'];
    

    ///INSERTANDO EN tbl_invoice//////////
    $insert=$pdo->prepare("insert into tbl_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype)");
    
    $insert->bindParam(':cust',$customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':stotal', $subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);
   
   $insert->execute();
    ///FIN INSERTANDO EN tbl_invoice//////////

  //INSERTANDO EN tbl_invoice_details////////
  $invoice_id=$pdo->lastInsertId();//Guardando el invoice ultimo id
  if($invoice_id!=null){// si esta variable es diferente de  null
  
for($i=0 ; $i<count($arr_productid) ; $i++){
  
  //Actualizando Stock
  $rem_qty = $arr_stock[$i]-$arr_qty[$i];
  
  if($rem_qty<0){// si la cantidada restatnte es menor a 0
      
      return"Orden no completada";
  }else{
      
     $update=$pdo->prepare("update tbl_product SET pstock ='$rem_qty' where idp='".$arr_productid[$i]."'");
      
      $update->execute();// ejecuto query para actualizar stock
     
  }
  //FIN Actualizando Stock

 $insert=$pdo->prepare("insert into tbl_invoice_details(invoice_id,product_id,product_name,product_code,product_color,qty,price,order_date) values(:invid,:pid,:pname,:pcode,:pcolor,:qty,:price,:orderdate)");/**Something new added */
  
  $insert->bindParam(':invid',$invoice_id);
  $insert->bindParam(':pid', $arr_productid[$i]);
  $insert->bindParam(':pname',$arr_productname[$i]);
  $insert->bindParam(':pcode',$arr_pcode[$i]);/** NEW */
  $insert->bindParam(':pcolor',$arr_pcolor[$i]);/** NEW */
  $insert->bindParam(':qty',$arr_qty[$i]);
  $insert->bindParam(':price',$arr_price[$i]);
  $insert->bindParam(':orderdate',$order_date);
   
  
  $insert->execute();
  
}        
echo '<script type="text/javascript">
              jQuery(function validation(){
                swal({
                  title: "Reservado!",
                  text: "Producto reservado exitosamente!",
                  icon: "success",
                  button: "OK",
                });
              });
              </script>';
 //  echo"success fully created order";    
    
      
  }
  //FIN INSERTANDO EN tbl_invoice_details///////
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detalles del Producto 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Producto</a></li>
        <li class="active">Detalles</li>
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
              <h3 class="box-title"><a href="user.php" class="btn btn-primary" role="button">Regresar a Catalogo</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
                <?php
                    $id = $_GET['id'];
                    $select=$pdo->prepare("select * from tbl_product where idp =$id");//Obtengo los datos
                    $select->execute();//ejecuto la query
                    while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                ?>

                
                <!-- SECTION -->
                <div class="section">
                  <!-- container -->
                  <div class="container">
                    <!-- row -->
                    <div class="row">
                      <!-- Product main img -->
                      <div class="col-md-5 col-md-push-2">
                        <div id="product-main-img">
                          <div class="product-preview">
                            <img src="../productimages/<?php echo $row->pimage?>" alt="">
                          </div>
                        </div>
                      </div>
                      <!-- /Product main img -->

                      <!-- Product thumb imgs -->
                      <div class="col-md-2  col-md-pull-5">
                        <div id="product-imgs">
                          <div class="product-preview">
                            <img src="../productimages/<?php echo $row->pimage?>" alt="">
                          </div>
                        </div>
                      </div>
                      <!-- /Product thumb imgs -->

                      <!-- Product details -->
                      <div class="col-md-5">
                        <div class="product-details">
                          <p class="product-category"><?php echo $row->pcode?></p>
                          <h2 class="product-name"><?php echo $row->pname?></h2>
                          <div>
                            <div class="product-rating">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star-o"></i>
                            </div>
                            <a class="review-link" href="#">1000 Valoración(es) | Agrega tu valoración</a>
                          </div>
                          <div>
                            <h4 class="product-price">$ <?php echo $row->saleprice?></h4>
                            <span class="product-available"><?php echo $row->pstock?> In Stock</span>
                          </div>
                          <p><?php echo $row->pdescription?></p>

                          <div class="product-options">
                            <label>
                              Material
                              <select class="input-select">
                                <option value="0"><?php echo $row->pmaterial?></option>
                              </select>
                            </label>
                            <label>
                              Color
                              <select class="input-select" style="width: 150px">
                                <option value="0" ><?php echo $row->pcolor?></option>
                              </select>
                            </label>
                          </div>
                          <!--Formulario para boton -->
                          <form action=""  method="post" name="" >
				
                            <input type="hidden" class="form-control" name="txtcustomer" value="<?php echo $_SESSION['name']." ".$_SESSION['surname'];?>" placeholder="Nombre de vendedor" required readonly>
                            <input type="hidden" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d");?>"  data-date-format="yyyy-mm-dd">
                            <input type="hidden" class="form-control" name="txtsubtotal" id="txtsubtotal" value="<?php echo $row->saleprice?>" required readonly>
                            <input type="hidden" class="form-control" name="txttax" id="txttax" value="0" required readonly>
                            <input type="hidden" class="form-control" name="txtdiscount" id="txtdiscount" value="1" required readonly>
                            <input type="hidden" class="form-control" name="txttotal" id="txttotal" value="<?php echo $row->saleprice?>" required readonly>
                            <input type="hidden" class="form-control" name="txtpaid" value="0"  id="txtpaid" required>
                            <input type="hidden" class="form-control" name="txtdue" id="txtdue" value="<?php echo $row->saleprice?>" required readonly>
                            <label style="display: none;">
                                  <input type="radio" name="rb" class="minimal-red" value="Cash" checked> EFECTIVO
                              </label>
                              <label style="display: none;">
                                  <input type="radio" name="rb" class="minimal-red" value="Card" readonly> TARJETA
                              </label>
                            
                            <input type="hidden" class="form-control productid" name="productid[]" id="txtproductid" value="<?php echo $row->idp?>" readonly>
                            <input type="hidden" class="form-control pname" name="productname[]"  id="txtproductname" value="<?php echo $row->pname?>" readonly>
                            <input type="hidden" class="form-control code" name="code[]" id="txtcode" value="<?php echo $row->pcode?>" style="width: 125px" readonly>
                            <input type="hidden" class="form-control color" name="color[]" id="txtcolor" value="<?php echo $row->pcolor?>" style="width: 90px" readonly>
                            <input type="hidden" class="form-control stock" name="stock[]" id="txtstock" value="<?php echo $row->pstock?>"readonly>
                            <input type="hidden" class="form-control price" name="price[]" id="txtprice" value="<?php echo $row->saleprice?>" readonly>
                            <input type="number" min="1" class="form-control qty" name="qty[]" id="txtqty" value="<?php echo 1;?>" style="display: none;">
                          
                            <div class="add-to-cart">
                              <!--<button class="add-to-cart-btn" type="submit" name="btnsaveorder" data-toggle="modal" data-target="#confirm"><i class="fa fa-shopping-cart"></i> Reservar</button>-->
                              <button id="cancelorder" class="add-to-cart-btn" type="button" data-trigger="focus" name="btnsaveorder" data-toggle="popover" data-placement="bottom" title='<p class="text-danger" align="center">Confirmar Reserva</p>' data-html='true' 
                              data-content='
                                    <div align="center">
                                      <h4>¿Reservar el siguiente producto?</h4><h6>Una vez reservado podra eliminarlo de la lista de reservas!</h6>
                                    </div>
                                    <div align="center">
                                    <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-window-close"></i> Cancelar</button>
                                    <button type="submit" name="btnsaveorder" class="btn btn-success btn-sm"><i class="fa fa-shopping-cart"></i> Confirmar</button>
                                    </div>'
                              >
                              <i class="fa fa-shopping-cart"></i> Reservar</button>
                            </div>
                            </form>
                            <!--Fin Form-->
                          <ul class="product-btns">
                            <li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
                            <li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li>
                          </ul>

                          <ul class="product-links">
                            <li>Categoria:</li>
                            <li><a href="#"><?php echo $row->pcategory?></a></li>
                            
                          </ul>

                          <ul class="product-links">
                            <li>Compartir:</li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                          </ul>

                        </div>
                      </div>
                      <!-- /Product details -->

                      <!-- Product tab -->
                      <div class="col-md-12">
                        <div id="product-tab">
                          <!-- product tab nav -->
                          <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Descripción</a></li>
                            <li><a data-toggle="tab" href="#tab2">Detalles</a></li>
                            
                          </ul>
                          <!-- /product tab nav -->

                          <!-- product tab content -->
                          <div class="tab-content">
                            <!-- tab1  -->
                            <div id="tab1" class="tab-pane fade in active">
                              <div class="row">
                                <div class="col-md-12">
                                  <p><?php echo $row->pdescription?></p>
                                </div>
                              </div>
                            </div>
                            <!-- /tab1  -->

                            <!-- tab2  -->
                            <div id="tab2" class="tab-pane fade in">
                              <div class="row">
                                <div class="col-md-12">
                                  <p><?php echo $row->pobservation?></p>
                                </div>
                              </div>
                            </div>
                            <!-- /tab2  -->

                         
                          </div>
                          <!-- /product tab content  -->
                        </div>
                      </div>
                      <!-- /product tab -->
                    </div>
                    <!-- /row -->
                  </div>
                  <!-- /container -->
                </div>
                <!-- /SECTION -->
                <?php
                    }
                ?>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
  //Start hide and show prices
  //with toggle with 1 button
 $(document).ready(function(){  
	$("#switchprice").click(function () {
            $('h4').toggle("slow");
        });
  });

   //<!-- Start popover-->
   $( function(){
    $('[data-toggle="popover"]').popover()
  });
  //<!-- End popover-->
  $('.popover-dismiss').popover({
  trigger: 'focus'
})
  </script>
<?php
  include_once'footer.php';
?>