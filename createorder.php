<?php
include_once'connectdb.php';
session_start();
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
                         <input type="text" class="form-control" name="txtcustomer" placeholder="Ingresar nombre de cliente" required>
                
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
                                <button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button>
                                </th>
                            </tr>
                        </thead>
                 </table>        
                
                </div>
            </div><!-- end order table -->
            
            <div class="box-body"> <!-- start taxes, discount, etc -->
                <div class="col-md-6"><!-- primera division-->
                    <div class="form-group">
                        <label>SubTotal</label>
                        <input type="text" class="form-control" name="txtsubtotal" required>
                    </div>
                    <div class="form-group">
                        <label>Impuesto (5%)</label>
                        <input type="text" class="form-control" name="txttax" required>
                    </div>
                    <div class="form-group">
                        <label>Descuento</label>
                        <input type="text" class="form-control" name="txtdiscount" required>
                    </div>
                </div>
                <div class="col-md-6"><!-- segunda division-->
                    <div class="form-group">
                            <label>Total</label>
                            <input type="text" class="form-control" name="txttotal" required>
                        </div>
                        <div class="form-group">
                            <label>Pagó</label>
                            <input type="text" class="form-control" name="txtpaid" required>
                        </div>
                        <div class="form-group">
                            <label>Vuelto</label>
                            <input type="text" class="form-control" name="txtdue" required>
                        </div>
                    </div>
            </div><!--end taxes, discount, etc -->
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

    </script>
<?php
  include_once'footer.php';
?>