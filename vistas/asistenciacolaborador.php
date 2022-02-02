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
if ($_SESSION['ventas']==1)
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
                          <h1 class="box-title">Asistencia</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistroscolaborador">
                        <table id="tbllistadoasistencia" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DPI</th>
                            <th>Direccion</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Cargo</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DPI</th>
                            <th>Direccion</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Cargo</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistroscolaborador">
                        <form name="formulario" id="formulariocolaborador" method="POST">
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <!-- <input type="hidden" name="idpersona" id="idpersona"> -->
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="3">
                            <input type="text" autocomplete="off" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del colaborador" required>
                          </div>
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido:</label>
                            <input type="text" autocomplete="off" class="form-control" name="apellido" id="apellido" maxlength="100" placeholder="Apellido del colaborador" required>
                          </div>
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                            <option value="2">DPI</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Número DPI:</label>
                            <input type="text" autocomplete="off" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="DPI">
                          </div>
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" autocomplete="off" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección">
                          </div>
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" autocomplete="off" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                          </div>

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="email" autocomplete="off" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo:</label>
                            <input type="text" autocomplete="off" class="form-control" name="cargo" id="cargo" maxlength="50" placeholder="Cargo/Puesto">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardarcolaborador"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
      
      <!-- /.inicio Modal -->
  <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione...</h4>
        </div>
        <div class="modal-body">
  <form action="" name="formulario_asis" id="formulario_asis" method="POST">
      <div class="form-group col-lg-12 col-md-12 col-xs-12">
      <label for="">Fecha(*):</label>
        <input type="hidden" name="idpersona" id="idpersona">      
        <input type="hidden" id="idasistencia" name="idasistencia">
        <!-- <input type="hidden" id="alumn_id" name="alumn_id"> -->
        <input type="Date" onchange="verificarfecha();" class="form-control" id="fecha_asistencia" name="fecha_asistencia" required="">   
        <label for="">Descripcion(*):</label>
        <select class="form-control selectpicker"  id="tipo_asistencia"  name="tipo_asistencia">        
          <option value="1"> Asistencia</option>
          <option value="2"> Falta</option>
        </select>

        
    </div>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar_asis"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger pull-right" data-dismiss="modal" onclick="cancelarasistecia();" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

    </div>
        </form>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
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
<script type="text/javascript" src="scripts/colaborador.js"></script>
<?php
}
ob_end_flush();
?>
