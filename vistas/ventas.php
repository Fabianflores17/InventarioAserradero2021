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
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();


  $rsptav = $consulta->Totalventas();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;
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
                          <h1 class="box-title">Venta <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Venta</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Total Venta</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                            <p style="font-size:40px;">Total Q.<?php echo $totalv; ?></p>
                    </div>


                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12">
                            <label>Cliente(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <select id="idcliente" name="idcliente" class="form-control selectpicker" title="--Seleccione el Cliente--" data-live-search="true" >
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" title="--Seleccione Tipo Comprobante--"required="">
                               <option value="1">Boleta</option>
                               <option value="2">Factura</option>
                               <option value="3">Ticket</option>
                            </select>
                          </div>
                        
                          
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Almacen(*):</label>
                            <select onchange="listarArticulos();" name="idalmacen" id="idalmacen" class="form-control selectpicker" title="--Seleccione el almacen--"required="">
                            </select>
                          </div>
                          

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" >
                          </div>
                          <div class="form-group col-lg-1 col-md-2 col-sm-6 col-xs-12">
                            <label>Impuesto:</label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto" >
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Tipo de Pago(*):</label>
                              <select  onchange="fechaprorroga();" id="tipo_pago" name="tipo_pago" title="Seleccione tipo de pago" class="form-control selectpicker"  >
                              </select>
                          </div> 
                          <div id="fecha_pro" class=" form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Dias de Prorroga(*):</label>
                            <input type="number" class="form-control" name="fecha_pro" id="fecha_pro" >
                          </div> 
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" type="button"   class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
                            </a>

                          </div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Stock</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
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
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body table-responsive">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover"  style="width:100%">
            <thead>
                <th>Opciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock</th>
     
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
<script type="text/javascript" src="scripts/ventas1.1.js"></script>
<?php
}
ob_end_flush();
?>
