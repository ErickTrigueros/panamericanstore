<?php
include_once'connectdb.php';
session_start();
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
  include_once'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Crear orden
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
            <form action="" method="post" name="">
            <div class="box-header with-border">
              <h3 class="box-title">Nueva orden</h3>
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
                                <input type="text" class="form-control" name="txtcustomer" value="<?php echo $_SESSION['name']." ".$_SESSION['surname'];?>" placeholder="Nombre de vendedor" required readonly>
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
                                <input type="text" class="form-control pull-right" id="datepicker">
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
                                <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Impuesto (5%)</label>
                        <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txttax" id="txttax" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Descuento</label>
                        
                        <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><!-- segunda division-->
                    <div class="form-group">
                            <label>Total</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txttotal" id="txttotal" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pagó</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>

                                <input type="text" class="form-control" name="txtpaid"  id="txtpaid" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Diferencia</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-usd"></i>
                                </div>
                                <input type="text" class="form-control" name="txtdue" id="txtdue" required>
                            </div>
                        </div>

                         <!-- radio -->
                         <label>Metodo de pago</label>
                        <div class="form-group">

                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Cash" checked> EFECTIVO
                            </label>
                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Card"> TARJETA
                            </label>
                            <label>
                                <input type="radio" name="rb" class="minimal-red" value="Check">
                                CHEQUE
                            </label>
                        </div>
                        <!-- end radio -->

                    </div><!-- end segunda division-->
            </div><!--end taxes, discount, etc -->
            <hr>

                <div align="center">

                    <input type="submit" name="btnsaveorder" value="Guardar Orden" class="btn btn-info">

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
            tr.find(".stock").val(data["pstock"]);
            tr.find(".price").val(data["saleprice"]); 
            tr.find(".qty").val(1);
            tr.find(".total").val( tr.find(".qty").val() *  tr.find(".price").val()); //
                calculate(0,0); 
             }   
      })   
      })    
    //Fin cargar detalles de producto
        })  
        // btnremove start here   
        $(document).on('click','.btnremove',function(){
         
         $(this).closest('tr').remove(); 
          calculate(0,0);
          $("#txtpaid").val(0);
          
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

        // Start total calculation acording quantity




    });
    //Fin boton agregar productos

    </script>
<?php
  include_once'footer.php';
?>