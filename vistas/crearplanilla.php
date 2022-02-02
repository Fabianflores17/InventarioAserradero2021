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
 require_once "../modelos/crear_planilla.php";
   $articulo = new Articulo();


  $rsptav = $articulo->Totalplanilla();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->totalplanilla;
//   $diario=$reg->limite_credito/30;
  $totalpla=number_format($totalv,2);
// 	$totales=$reg->limite_credito-($reg->faltas*$dia);
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
                          <h1 class="box-title">Creacion Planilla <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                          <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Mes</th>
                            <th>Fecha inicio</th>
                            <th>Fecha final</th>
                            
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Mes</th>
                            <th>Fecha inicio</th>
                            <th>Fecha final</th>
                            
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="hidden" name="idplanilla" id="idplanilla">
                            <input type="text" class="form-control" autocomplete="off" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Mes(*):</label>
                            <select id="mes" title="Seleccione la Mes"  name="mes" class="form-control selectpicker" data-live-search="true" required>
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio">Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Septiembre">Septiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Diciembre">Diciembre</option>
                            </select>

                          </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <!-- <label>Tipo empleado:</label>
                            <select id="tipo_empleado" title="Seleccione la Tipo empleado"  name="tipo_empleado" class="form-control selectpicker" data-live-search="true" required>
                            </select> -->
                          </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>fecha inicio:</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha Final:</label>
                            <input type="date" class="form-control" name="fecha_final" id="fecha_final" required="">
                          </div>

          
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                             </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
    
          
      </section><!-- /.content -->
     
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Pago Total de Planilla Q.<?php echo $totalpla; ?></h4>
      
        </div>
        <div class="modal-body table-responsive">
       
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover"  style="width:100%">
            <thead>
                <th>Nombre</th>
                <th>Mes</th>
                <th>Dias laborados</th>
                <th>Falta</th>
                <th>Sueldo</th>
                <th>Fecha inicio</th>
                <th>Fecha final</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              
                <th>Nombre</th>
                <th>Mes</th>
                <th>Dias laborados</th>
                <th>Falta</th>
                <th>Sueldo</th>
                <th>Fecha inicio</th>
                <th>Fecha final</th>
     
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/crear_planilla.js"></script>
<?php 
}
ob_end_flush();
?>