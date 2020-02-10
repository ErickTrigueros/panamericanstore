<?php
include_once'connectdb.php';
session_start();
if($_SESSION['username']=="" OR $_SESSION['role']==""){//si la variable de sesion que contiene el usuario esta vacia o es un rol de usuario mandarlo al index.
    header('location:../index.php');//redirigir a index(Login), si tratamos de abrir registration.php, no dejara porque la variable de sesion username esta vacia o la variable de sesion esta con usuario
  }
//Inicio funcion para llenar select de porduct
function fill_product($pdo){
    
    $output='';
        
    $select=$pdo->prepare("select * from tbl_product order by pname asc"); 
    $select->execute();
        
    $result=$select->fetchAll();
        
    foreach($result as $row){
        
    $output.='<option value="'.$row["idp"].'">'.$row["pname"].'-'.$row["pcode"].'</option>';  //Aparece el product name y el codigo del producto
        
    }    
        
     return $output;   
        
    }
 //Fin funcion para llenar select de porduct 
 
 //Inicio para obtener valores de los textbox y guardarlos en BD
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
    //fin Obtengo datos de campos de texto y guardo en variables para guardar en tbl_outbound
    ////////////////////////////////
    
    //tenemos array de valores en las variables para insertar en tbl_outbound details
    $arr_productid=$_POST['productid'];
    $arr_productname=$_POST['productname'];
    $arr_pcode=$_POST['code'];/** NEW se toman de los inputs*/
    $arr_pcolor=$_POST['color'];/** NEW se toman de los inputs*/
    $arr_stock=$_POST['stock'];
    $arr_qty=$_POST['qty'];
    $arr_price=$_POST['price'];
    $arr_total=$_POST['total'];

    ///INSERTANDO EN tbl_outbound//////////
    $insert=$pdo->prepare("insert into tbl_outbound(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype)");
    
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
   $invoice_id=$pdo->lastInsertId();
   if($invoice_id!=null){
   
for($i=0 ; $i<count($arr_productid) ; $i++){
   

  $insert=$pdo->prepare("insert into tbl_outbound_details(invoice_id,product_id,product_name,product_code,product_color,qty,price,order_date) values(:invid,:pid,:pname,:pcode,:pcolor,:qty,:price,:orderdate)");/**Something new added */
   
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
echo "Orden creada satisfactoriamente";
  //  echo"success fully created order";    
  header('location:outboundproductlist.php');     
       
   }
   //FIN INSERTANDO EN tbl_invoice_details///////
 }

 //FIN para obtener valores de los textbox y guardarlos en BD

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
        Crear Orden Saliente
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Orden Saliente</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <!-- general form elements -->
        <div class="box box-warning">
            <form action="" method="post" name="">
            <div class="box-header with-border">
              <h3 class="box-title">Nuevo pedido</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body"> <!-- customer and date -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre de vendedor</label>
                        <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <!--<input type="text" class="form-control" name="txtcustomer" value="<?php echo $_SESSION['name']." ".$_SESSION['surname'];?>" placeholder="Nombre de vendedor" required >-->
                                <input type="text" class="form-control" name="txtcustomer" value=" " placeholder="Nombre de vendedor" required >
                        </div>                
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <label>Fecha:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d");?>"  data-date-format="yyyy-mm-dd">
                            </div>
                            <!-- /.input group -->
                    </div>
                </div>
            </div><!-- end customer and date -->
            
            <div class="box-body"> <!-- start order table -->
                <div class="col-md-12">
                    <div style="overflow-x:auto;" > 
                        <table id ="producttable" class="table table-Striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Buscar Producto</th>
                                        <th>Codigo</th><!-- ****NEW****-->
                                        <th>Color</th><!-- ****NEW****-->
                                        <th>Existencias</th>
                                        <th>Precio</th>                                    
                                        <th>Ingrese cantidad</th>
                                        <th>Total</th>
                                        <th>
                                        <center> <button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button> </center>
                                        </th>
                                    </tr>
                                </thead>
                        </table>        
                    </div>
                </div>
            </div><!-- end order table -->
            
            <div class="box-body"> <!-- start taxes, discount, etc -->
                <div class="col-md-6"><!-- primera division-->
                    <div class="form-group">
                        <label>SubTotal</label>
                        <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Impuesto (0%)</label>
                        <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txttax" id="txttax" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Descuento(Comision)</label>
                        
                        <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txtdiscount"  id="txtdiscount" required readonly >
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><!-- segunda division-->
                    <div class="form-group">
                            <label>Total - Comision</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txttotal" id="txttotal" required readonly>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label>Pagó</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>

                                <input type="text" class="form-control" name="txtpaid" value="0"  id="txtpaid" required readonly>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label>Diferencia</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txtdue" id="txtdue" required readonly>
                            </div>
                        </div>

                         <!-- radio -->
                         <label>Metodo de pago</label>
                        <div class="form-group">

                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Cash" checked> EFECTIVO
                            </label>
                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Card" readonly> TARJETA
                            </label>
                            <!--<label>
                                <input type="radio" name="rb" class="minimal-red" value="Check">
                                CHEQUE
                            </label> -->
                        </div>
                        <!-- end radio -->

                    </div><!-- end segunda division-->
            </div><!--end taxes, discount, etc -->
            <hr>

                <div align="center">

                    <input type="submit" name="btnsaveorder" value="Guardar Pedido" class="btn btn-info">

                </div>

            <hr>
        </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <script>
        //Date picker
        $('#datepicker').datepicker({
                autoclose: true
            });


         //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    })
    //inicio boton agregar productos al select
    $(document).ready(function(){
        
        $(document).on('click','.btnadd',function(){
        
            var html='';
    html+='<tr>';
            
    html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            
    html+='<td><select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option><?php echo fill_product($pdo); ?> </select></td>';//llamo a la funcion para obtener el nombre

    html+='<td><input type="text" class="form-control code" name="code[]" style="width: 125px" readonly></td>';/***NEW ***/
    html+='<td><input type="text" class="form-control color" name="color[]" style="width: 90px" readonly></td>'; /**NEW */       
    html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
    html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
    html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>';
    html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
    html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>'; 
            
            $('#producttable').append(html);
    //fin boton agregar productos al select  

      //Initialize Select2 Elements
        $('.productid').select2()
    //finish Select2 Elements

    //Inicio cargar detalles de producto

    $(".productid").on('change' , function(e){
         
         var productid = this.value;
          var tr=$(this).parent().parent();  
            $.ajax({
                
             url:"getproduct.php",
             method:"get",
             data:{id:productid},
             success:function(data){
                 
             // console.log(data); mostramos en consola
            tr.find(".pname").val(data["pname"]);
            tr.find(".code").val(data["pcode"]);           /** NEW */
            tr.find(".color").val(data["pcolor"]);         /** NEW */
            tr.find(".stock").val(data["pstock"]);
            tr.find(".price").val(data["saleprice"]); 
            tr.find(".qty").val(1);
            tr.find(".total").val( tr.find(".qty").val() *  tr.find(".price").val()); //
            calculate(0,0); //Funcion para calcular subtotal
             }   
      })   
      })    
    //Fin cargar detalles de producto
        })  
        // btnremove start here   
        $(document).on('click','.btnremove',function(){
         
         $(this).closest('tr').remove(); 
          calculate(0,0);
          $("#txtpaid").val(0);//seteamos a cero al dar click en remove.
          
      }) // btnremove end here  

        // Start total calculation acording quantity

        $("#producttable").delegate(".qty","keyup change" ,function(){
       
       var quantity = $(this);
        var tr = $(this).parent().parent(); 
         
     if((quantity.val()-0)>(tr.find(".stock").val()-0) ){//Validamos si la cantidad a reservar esta disponible o no.
        
        swal("ADVERTENCIA!","Lo sentimos! Esta cantidad no esta disponible","warning");
         
         quantity.val(1);
         
          tr.find(".total").val(quantity.val() *  tr.find(".price").val());
         calculate(0,0);
        }else{
            
            tr.find(".total").val(quantity.val() *  tr.find(".price").val());
            calculate(0,0);
        }    
         
         
         
     })   

        // end total calculation acording quantity
        
        ////Start function calculate subtotal, tax, net total
        function calculate(dis,paid){// le pasamos el descuento y lo que pago
         //variables a usar
         var subtotal=0;
         var tax=0;
         var discount = dis;     
         var net_total=0;
         var paid_amt=paid;
         var due=0;
              
              
         $(".total").each(function(){
             
         subtotal = subtotal+($(this).val()*1); //calculanndo subtotal   
             
         })
         /////////Seteando comision de acuerdo a la cantidad
         $(".qty").each(function(){
             
             discount = discount+($(this).val()*1); //calculanndo la comision de acuerdo e  
                 
             })
        /////////Fin Seteando comision de acuerdo a la cantidad
     //end function calculate subtotal, tax, net, descuento, due          
     tax=0*subtotal;//calculando impuesto
     net_total=tax+subtotal;  //50+1000 =1050 // calculando  total neto
     net_total=net_total- discount;   //calculando 
     due=net_total-paid_amt;  //total neto -  el total que pagó     
              
         
     $("#txtsubtotal").val(subtotal.toFixed(2)); //mostrando subtotal en el textfield
     $("#txttax").val(tax.toFixed(2));   //mostrando impuesto en el textfield
     $("#txttotal").val(net_total.toFixed(2));//mostrando total neto en el textfield
     $("#txtdiscount").val(discount); //mostrando descuento en el textfield (ingresar)
     $("#txtdue").val(due.toFixed(2));//
       
              
              
          }
    //end function calculate subtotal, tax, net total  

    //inicio calculo de descuento y diferencia
         $("#txtdiscount").keyup(function(){
            var discount = $(this).val();
            calculate(discount,0);
            
            
         }) 
                
         $("#txtpaid").keyup(function(){
            var paid = $(this).val();  
            var discount = $("#txtdiscount").val();
                calculate(discount,paid);
            
        }) 
        //Fin calculo de descuento y diferencia     



    });
    //Fin boton agregar productos

    </script>
<?php
  include_once'footer.php';
?>

