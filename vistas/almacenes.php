<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['almacen']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Bodegas </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" >
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>tipo de almacen</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                           <th>tipo de almacen</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    
                    <div class="panel-body table-responsive" id="listadoarticulos">
                    <table id="tbbodega" class="table table-striped table-bordered table-condensed table-hover dataTable" width="100%">
                   
                          <thead >
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>categoria</th>
                            <th>stock</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>categoria</th>
                            <th>stock</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>

                    
                        <button class="btn btn-info" type="button" onclick="document.location='almacenes.php'"> Volver atras</button>
                                            </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/almacenes.js"></script>
<?php
}
ob_end_flush();
?>
