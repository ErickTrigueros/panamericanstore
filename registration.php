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
        Registro 
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
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registrar Usuarios</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                    <div class="col-md-4"><!--Columnas divididas en 4-->
                    <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="txtname" placeholder="Ingresar nombre">
                    </div>
                    <div class="form-group">
                    <label >Apellido</label>
                    <input type="text" class="form-control" name="txtsurname" placeholder="Ingresar apellido">
                    </div>
                    <div class="form-group">
                    <label >Usuario</label>
                    <input type="text" class="form-control" name="txtusername" placeholder="Ingresar usuario">
                    </div>
                    <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control" name="txtemail" placeholder="Ingresar correo">
                    </div>
                    <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="txtpassword" placeholder="Password">
                    </div>
                    <!-- seleccionar opciones de role -->
                    <div class="form-group">
                    <label>Rol</label>
                    <select class="form-control" name="txtselect_option">
                        <option value="" disabled selected>Seleccionar Rol</option>
                        <option>User</option>
                        <option>Admin</option>
                    </select>
                    </div>

                    <button type="submit" class="btn btn-info">Registrar</button>

                </div>
                <div class="col-md-8"><!--Columnas divididas en 8-->
                    <table class="table table-Striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select=$pdo->prepare("select * from tbl_user order by userid desc");//Obtengo los datos
                            $select->execute();//ejecuto la query
                            while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores
                                echo'<tr>
                                <td>'.$row->userid.'</td>
                                <td>'.$row->name.'</td>
                                <td>'.$row->surname.'</td>
                                <td>'.$row->username.'</td>
                                <td>'.$row->useremail.'</td>
                                <td>'.$row->password.'</td>
                                <td>'.$row->role.'</td>
                                
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div>

                

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
            </form>
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include_once'footer.php';
?>