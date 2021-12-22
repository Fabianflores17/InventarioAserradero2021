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
if ($_SESSION['caja']==1)
{
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();


  $rsptav = $consulta->Totalcajaingresos();
  $regv=$rsptav->fetch_object();
  $totalin=$regv->total_ingreso;

  $rsptav = $consulta->Totalventas();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;

  $rsptav = $consulta->TotalCompra();
  $regv=$rsptav->fetch_object();
  $totalco=$regv->compras;
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
                          <h1 class="box-title">Estado Finaciero <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                            <th>Monto</th>
                          </thead>
                          <tbody>
                            <tr>
                            <td>total ingreso </td>
                            <td>Q.<?php echo $totalin;?> </td>
                            </tr>
                            <tr>
                            <td>total ventas </td>
                            <td>Q.<?php echo $totalv;?> </td>
                          </tr>
                          <tr>
                          <td >total compras </td>
                          <td style="background-color:#ff000060">Q.<?php echo $totalco;?> </td>
                        </tr>
                          </tbody>
                          <tfoot>
                            <th>total:        </th>
                            <th> Q.<?php echo ($totalv+$totalin-$totalco);?>.00</th>
                          </tfoot>
                        </table>
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
<script type="text/javascript" src="scripts/Permiso.js"></script>
<?php
}
ob_end_flush();
?>
