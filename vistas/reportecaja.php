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

if ($_SESSION['consultac']==1)
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
                          <h1 class="box-title">Consulta de Caja chica por fecha </h1>
                        <div class="box-tools pull-right">
                        <h4 id="totales">Q/. 0.00</h4>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Pago(*):</label>
                            <select name="tipo_pago" id="tipo_pago" class="form-control selectpicker" title="--Seleccione Tipo Pago--" >
                               <option value="1">Ingresos</option>
                               <option value="2">Gastos</option>
                            </select>
                          <button class="btn btn-success" onclick="listarcaja()">Mostrar</button>
                       </div>
                        <table id="tbllistadocaja" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Descripcion</th>
                            <th>Número</th>
                            <th>Total Compra</th>
                            <th>Tipo</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Descripcion</th>
                            <th>Número</th>
                            <th>Total Compra</th>
                            <th>Tipo</th>
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
<script type="text/javascript" src="scripts/reportecaja.js"></script>
<?php 
}
ob_end_flush();
?>


