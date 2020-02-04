<?php
include_once'connectdb.php';//Incluimos conexion
session_start();//Iniciamos sesion para cargar todos las variables de sesion

if($_SESSION['username']=="" OR $_SESSION['role']=="Admin"){//si la variable de sesion que contiene el usuario esta vacia o el rol es de Admin.
  header('location:../index.php');//redirigir a index(Login), si tratamos de abrir dashboard.php(Admin) o user.php(USER), no dejara porque la variable de sesion username esta vacia
}
  include_once'headeruser.php';

  if(isset($_POST['btnsaveorder'])){
    //Obtengo datos de campos de texto y guardo en variables para guardar en tbl_invoice
    $customer_name=$_POST['txtcustomer'];
    $order_date=date('Y-m-d',strtotime($_POST['orderdate']));
    $subtotal=$_POST["txtsubtotal"];
    $tax=$_POST['txttax'];
    $discount=$_POST['txtdiscount'];
    $total=$_POST['txttotal'];
    $paid=$_POST['txtpaid'];
    $due=$_POST['txtdue'];
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
       Catalogo de Productos
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>User</a></li>
        <li class="active">Catlogo de Productos</li>
      </ol>

    
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row"><!--Fila para mostrar productos-->
            <?php
            $select=$pdo->prepare("select * from tbl_product where pstock > 0 order by idp asc");
            $select->execute();//ejecuto la query
              while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
              ?>
                <div class="col-sm-3"><!--Fila para mostrar productos 4 elemento de tamaño 3-->
                <div class="product">
                          <div class="product-img">
                            <img src="../productimages/<?php echo $row->pimage?>" alt="" >
                            <div class="product-label">
                              <span class="sale">Stock: </span>
                              <span class="new"><?php echo $row->pstock?></span>
                            </div>
                          </div>
                          <div class="product-body">
                            <p class="product-category"><?php echo $row->pcode?></p>
                            <h3 class="product-name"><a href="#"><?php echo $row->pname?></a></h3>
                            <!--<h4 class="product-price">$'.$row->saleprice.'<del class="product-old-price">$0.00</del></h4>-->
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="popover" data-placement="bottom" title="$<?php echo $row->saleprice?>" data-content="">Precio</button>
                            <div class="product-rating">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                            </div>
                            <div class="product-btns">
                              <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                              <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                              <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                            </div>
                          </div>
                          <form action=""  method="post" name="" >
				
                          <input type="hidden" class="form-control" name="txtcustomer" value="<?php echo $_SESSION['name']." ".$_SESSION['surname'];?>" placeholder="Nombre de vendedor" required readonly>
                          <input type="hidden" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d");?>"  data-date-format="yyyy-mm-dd">
                          <input type="hidden" class="form-control" name="txtsubtotal" id="txtsubtotal" value="<?php echo $row->saleprice?>" required readonly>
                          <input type="hidden" class="form-control" name="txttax" id="txttax" value="0" required readonly>
                          <input type="hidden" class="form-control" name="txtdiscount" id="txtdiscount" value="0" required readonly>
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
                            <button class="add-to-cart-btn" type="submit" name="btnsaveorder" value="Guardar Pedido"><i class="fa fa-shopping-cart"></i> Reservar</button>
                          </div>
                          </form>
            </div><!--FinFila para mostrar productos 4 elemento de tamaño 3 (4x3)-->
          </div><!--Fin Fila para mostrar productos-->
          <?php
          }
          ?>
         
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>
  //<!-- Start popover-->
  $( function(){
    $('[data-toggle="popover"]').popover()
  });
  //<!-- End popover-->

   //Date picker
   $('#datepicker').datepicker({
                autoclose: true
            });


         //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    })
  </script>
  
<?php
  include_once'footer.php';
?>