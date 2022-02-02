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
                          <h1 class="box-title">Pagos Planilla <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Total</th>
                            <th>Forma de pago</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Total</th>
                            <th>Forma de pago</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                           
                    </div>


                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" title="--Seleccione Tipo Comprobante--"required="">
                               <option value="1">Voucher</option>
                            
                            </select>
                          </div>
                        
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Forma de Pago(*):</label>
                              <select onchange="fechaprorroga()" id="forma_pago" name="forma_pago" title="Seleccione forma de pago" class="form-control selectpicker">
                              <option value="1">Caja chica</option>
                               <option value="2">Socios</option>
                               <option value="3">Finanzas</option>
                              </select>
                          </div> 
                          
                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12" id="total1">
                          <input type="hidden" name="idventa" id="idventa">
                            <!-- <label>Total(*):</label>
                            <input type="text" class="form-control" name="totalpago" id="totalpago" value="totalpago" required=""> -->
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12" id="tipo">
                            <label>Seleccione:</label>
                              <select  id="idsocio" name="idsocio" title="Seleccione tipo de pago" class="form-control selectpicker"  >
                              <option value="1">Socio 1</option>
                               <option value="2">Socio 2</option>
                              </select>
                          </div> 
                          <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Colaborador</button>
                            </a>
                          </div>
                          <h3 id="totalCaja"></h3>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Colaborador</th>
                                    <th>Cargo</th>
                                    <th>Dias/Mes</th>
                                    <th>Pago</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Q/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>


                    <!--Fin centro -->
                  </div><!-- /.box -->
                  <!--Fin centro -->
                </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->



  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Colaborador</h4>
        </div>
        <div class="modal-body table-responsive">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Cargo</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>cargo</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>



  <!-- Fin modal -->
<script type="text/javascript" src="scripts/cliente-venta.js"></script>


<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/pago.js"></script>
<?php
}
ob_end_flush();
?>
