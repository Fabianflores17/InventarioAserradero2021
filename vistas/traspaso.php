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

if ($_SESSION['compras']==1)
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
                          <h1 class="box-title">Traspaso 2.0 <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                           <th>Opciones</th>
                            <th>Almacen origen</th>
                            <th>Almacen destino</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                           
                        
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                          <th>Almacen origen</th>
                            <th>Almacen destino</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12">
                            <label>Almacen Origen(*):</label>
                            <input type="hidden" name="idtransaccion" id="idtransaccion">
                            <select onchange="listarArticulos();" title="Seleccione el almacen" id="idalmacen" name="idalmacen" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                          </div>
                   
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Alamacen destino(*):</label>
                           <select name="idalmacen2" id="idalmacen2" title="Seleccione el almacen" class="form-control selectpicker"  required="">
                           </select>
                          </div>
                          
                          <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                            <!--<label>Almacen Origen(*):</label>
                            <input type="hidden" name="idingreso" id="idingreso">
                            <select  id="idalmacen" name="idalmacen" class="form-control selectpicker" data-live-search="true" required>
                            </select>-->
                            <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
                            </a>
                          </div>

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>stock</th>
                                    <th>Cantidad</th>
                                    <th>precio compra</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Q/. 0.00</h4><input type="hidden" name="total_compra" id="total_compra"></th>
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
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>precio Entrada</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
            <th>Opciones</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>precio Entrada</th>
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
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/traspaso.js"></script>
<?php
}
ob_end_flush();
?>