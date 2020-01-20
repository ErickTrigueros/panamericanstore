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
        Ver producto 
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
            <div class="box-header with-border">
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Regresar a lista de productos</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
                <?php
                    $id = $_GET['id'];
                    $select=$pdo->prepare("select * from tbl_product where idp =$id");//Obtengo los datos
                    $select->execute();//ejecuto la query
                    while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                        echo'
                        <div class="col-md-6">
                            <ul class="list-group">
                            <center><p class="list-group-item list-group-item-success"><b>Detalle de producto</b></p></center>
                                <li class="list-group-item"><b>ID</b><span class="badge">'.$row->idp.'</span></li>
                                <li class="list-group-item"><b>Codigo</b><span class="badge">'.$row->pcode.'</span></li>
                                <li class="list-group-item"><b>Nombre</b><span class="label label-info pull-right">'.$row->pname.'</span></li>
                                <li class="list-group-item"><b>Categoria</b><span class="label label-primary pull-right">'.$row->pcategory.'</span></li>
                                <li class="list-group-item"><b>Estilo</b><span class="label label-info pull-right">'.$row->pstyle.'</span></li>
                                <li class="list-group-item"><b>Material</b><span class="label label-info pull-right">'.$row->pmaterial.'</span></li>
                                <li class="list-group-item"><b>Color</b><span class="label label-info pull-right">'.$row->pcolor.'</span></li>
                                <li class="list-group-item"><b>Precio compra</b><span class="label label-warning pull-right">'.$row->purchaseprice.'</span></li>
                                <li class="list-group-item"><b>Precio venta</b><span class="label label-warning pull-right">'.$row->saleprice.'</span></li>
                                <li class="list-group-item"><b>Ganancia</b><span class="label label-success pull-right">'.($row->saleprice-$row->purchaseprice).'</span></li>
                                <li class="list-group-item"><b>Existencias</b><span class="label label-danger pull-right">'.$row->pstock.'</span></li>
                                <li class="list-group-item"><b>Observaciones: </b><span class="">'.$row->pobservation.'</span></li>   
                                
                            </ul>  
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                            <center><p class="list-group-item list-group-item-success"><b>Imagen de producto</b></p></center>

                            <img src="productimages/'.$row->pimage.'" class="img-responsive"/>
                            <li class="list-group-item"><b>Descripcion: </b><span class="">'.$row->pdescription.'</span></li>
                                
                            </ul>  
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>