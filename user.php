<?php
include_once'connectdb.php';//Incluimos conexion
session_start();//Iniciamos sesion para cargar todos las variables de sesion

if($_SESSION['username']=="" OR $_SESSION['role']=="Admin"){//si la variable de sesion que contiene el usuario esta vacia o el rol es de Admin.
  header('location:index.php');//redirigir a index(Login), si tratamos de abrir dashboard.php(Admin) o user.php(USER), no dejara porque la variable de sesion username esta vacia
}
  include_once'headeruser.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Productos 
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
        <div class="row"><!--Fila para mostrar productos-->
            <?php
            $select=$pdo->prepare("select * from tbl_product order by idp asc");
            $select->execute();//ejecuto la query
              while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
              echo' <div class="col-sm-3"><!--Fila para mostrar productos 4 elemento de tamaño 3-->
                <div class="product">
                          <div class="product-img">
                            <img src="productimages/'.$row->pimage.'" alt="">
                            <div class="product-label">
                              <span class="sale">Stock: </span>
                              <span class="new">'.$row->pstock.'</span>
                            </div>
                          </div>
                          <div class="product-body">
                            <p class="product-category">'.$row->pcode.'</p>
                            <h3 class="product-name"><a href="#">'.$row->pname.'</a></h3>
                            <h4 class="product-price">$'.$row->saleprice.'<del class="product-old-price">$0.00</del></h4>
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
                          <div class="add-to-cart">
                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                </div>
            </div><!--FinFila para mostrar productos 4 elemento de tamaño 3 (4x3)-->
          </div><!--Fin Fila para mostrar productos-->
          ';
          }
          ?>
         
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>