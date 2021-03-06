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
                          <h1 class="box-title">Compras por pagar </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadocredito" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                 
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Total Credito</th>
                            <th>Dias</th>
                            <th>Estado</th>
                         
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
          
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Total Credito</th>
                            <th>Dias</th>
                            <th>Estado</th>
                    
                          </tfoot>
                        </table>
                            
                    </div>


                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="col-lg-12">
                        <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12" >
                            <label>Cliente(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <input type="hidden" id="idcliente" name="idcliente" class="form-control" >
                            <input readonly id="idcliente1" name="idcliente1" class="form-control" >
                          </div>
                          </div>
                        
                          <div class="col-lg-12">
                          <div class="form-group col-lg-4 col-md-2 col-sm- col-xs-12">
                            <label>Almacen(*):</label>
                            <select name="idalmacen" id="idalmacen" class="form-control selectpicker" title="--Seleccione el almacen--" disabled>
                            </select>
                          </div>
                          </div>

                          <div class="col-lg-12">
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Total:</label>
                            <input type="text" class="form-control" name="total_credito" id="total_credito" placeholder="Total" disabled>
                          </div>
                          </div>

                          <div class="col-lg-12" id="pagoborrador" >
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Pago:</label>
                            <input type="text"   class="form-control" name="pago" id="pago"  placeholder="Ingrese monto a pagar" >
                          </div>
                          
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Art??culos</button>
                            </a>
                          </div>
                          

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Art??culo</th>
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
                            <button class="btn btn-primary" type="submit" onclik="validarpago()" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

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
    <div class="modal-dialog" style="width: 40% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Art??culo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>C??digo</th>
                <th>Nombre</th>
                <th>Stock</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>C??digo</th>
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
<script type="text/javascript" src="scripts/compracredito.js"></script>
<?php
}
ob_end_flush();
?>
