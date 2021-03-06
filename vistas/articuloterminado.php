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
                          <h1 class="box-title">Ficha Técnica <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                          <th>Opciones</th>
                            <th>Producto</th>
                            <th>Usuario</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Producto</th>
                            <th>Usuario</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                            
                    </div>


                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12">
                            <label>Producto Termiando(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <select id="idproducto" name="idproducto" class="form-control selectpicker" title="--Seleccione el producto--" data-live-search="true" required="" >
                            </select>
                          </div>
                          
                        
                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Almacen(*):</label>
                            <select onchange="listarArticulos();" name="idalmacen" id="idalmacen" class="form-control selectpicker" title="--Seleccione el almacen--"required="">
                            </select>
                          </div>
                          

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Cantidad Producida:</label>
                            <input type="number" autocomplete="off" class="form-control" name="q" id="q"  placeholder="cantidad">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Insumos M.O. x Unidad:</label>
                            <input type="text" class="form-control" name="totalxproduc" id="totalxproduc" placeholder="Número" disabled>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>% Gastos de operacion:</label>
                            <input type="number" class="form-control" name="gop" id="gop" >
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>% Gastos de admin:</label>
                            <input type="number" class="form-control" name="gad" id="gad" >
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>% Gastos de Log:</label>
                            <input type="number" class="form-control" name="glo" id="glo" >
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Total:</label>
                            <input readonly type="number" step="any" class="form-control" name="totalunitario" id="totalunitario" >
                          </div>
                          
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
                            </a>

                          </div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Stock</th>
                                    <th>Cantidad</th>
                                    <th>Costo</th>
                                    <th>Comentario</th>
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
    <div class="modal-dialog" style="width: 40% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>precio</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>precio</th>
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
<script type="text/javascript" src="scripts/articuloterminado.js"></script>
<?php
}
ob_end_flush();
?>
