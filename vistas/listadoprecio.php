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
                          <h1 class="box-title">Ingrese Listado de precio <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Estado</th>
                      
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Producto</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12">
                            <label>Proveedor(*):</label>
                            <input type="hidden" name="idingreso" id="idingreso">
                            <select id="idproducto" name="idproducto" title="Seleccione prodcuto" class="form-control selectpicker" data-live-search="true" required>
                            </select>
              
                          </div>
                
                            <div class="container">
                              <div class="row">
                            <div class="col-md-2 ">
                            <label>Precio No1:</label>
                              <input type="text" class="form-control hol" id="precio1" name="precio1" placeholder="Ingrese precio">
                              <label>Precio No3:</label>
                              <input type="text" class="form-control hol" id="precio3" name="precio3" placeholder="Ingrese precio" >
                              <label>Precio No5:</label>
                              <input type="text" class="form-control hol" id="precio5" name="precio5" placeholder="Ingrese precio" >
                              <label>Precio No7:</label>
                              <input type="text" class="form-control hol" id="precio7" name="precio7" placeholder="Ingrese precio" >
                              <label>Precio No9:</label>
                              <input type="text" class="form-control hol" id="precio9" name="precio9" placeholder="Ingrese precio" >
                            </div>
                            <div class="col-md-2 ">
                            <label>Precio No2:</label>
                              <input type="text" class="form-control hol" id="precio2" name="precio2" placeholder="Ingrese precio" >
                              <label>Precio No4:</label>
                              <input type="text" class="form-control hol" id="precio4" name="precio4" placeholder="Ingrese precio" >
                              <label>Precio No6:</label>
                              <input type="text" class="form-control hol" id="precio6" name="precio6" placeholder="Ingrese precio" >
                              <label>Precio No8:</label>
                              <input type="text" class="form-control hol" id="precio8" name="precio8" placeholder="Ingrese precio" >
                              <label>Precio No10:</label>
                              <input type="text" class="form-control hol" id="precio10" name="precio10" placeholder="Ingrese precio" >
                            </div>
                            </div>  </div>
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


<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/listadoprecio.js"></script>
<?php
}
ob_end_flush();
?>
