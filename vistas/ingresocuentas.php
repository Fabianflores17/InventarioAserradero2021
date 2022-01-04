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
  require_once "../modelos/caja.php";
  $consulta = new Caja();


  $rsptav = $consulta->listarTotal();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total;
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
                          <h1 class="box-title">Caja <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Tipo Transaccion</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Tipo Transaccion</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                        <h3>Total Disponible</h3>
                        <p style="font-size:40px;" id="validarcampo" value="<?php echo $totalv; ?>"><?php echo $totalv; ?></p>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Monto ingresado:</label>
                            <input type="hidden" name="idcaja" id="idcaja">
                            <input type="text" class="form-control" autocomplete="off" name="cantida" id="cantida" maxlength="50" placeholder="Cantidad" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <input type="text" autocomplete="off" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Transaccion(*):</label>
                            <select onchange="validarcuenta();"  name="tipo_transaccion" id="tipo_transaccion" title="selecciones tipo Transaccion" class="form-control selectpicker" title="--Seleccione Tipo Comprobante--" required="">
                               <option value="1">Ingreso</option>
                               <option value="2">Gasto</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" onclick="validarcuenta();" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                          
                        </form>
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
<script type="text/javascript" src="scripts/cuentas.js"></script>
<?php
}
ob_end_flush();
?>
