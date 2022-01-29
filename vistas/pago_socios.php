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
                          <h1 class="box-title">Reposicion de efectivo a los Socios</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadopagosocios" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha Prorroga</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Total Credito</th>
                            <th>Estado</th>
                            <th>Dias Restante Prorroga</th>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha Prorroga</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Total Credito</th>
                            <th>Estado</th>
                            <th>Dias Restante Prorroga</th>
                          </tfoot>
                        </table>
                            
                    </div>


                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulariopagosocio" id="formulariopagosocio" method="POST">
                          <div class="col-lg-12">
                        <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12" >
                            <label>Planilla(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <input readonly id="idplanilla" name="idplanilla" class="form-control" >
                          </div>
                          </div>

                          <div class="col-lg-12">
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Total:</label>
                            <input type="text" class="form-control" name="total_socio" id="total_socio" placeholder="Total" disabled>
                          </div>
                          </div>

                          <div class="col-lg-12" id="pagoborrador" >
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-4">
                            <label>Pago:</label>
                            <input type="text"   class="form-control" name="pago" id="pago"  placeholder="Ingrese monto a pagar" >
                          </div>
                          </div>

                     
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Pagado por:</label>
                            <select name="forma_pago" id="forma_pago" title="Seleccione el almacen" class="form-control selectpicker"  required="">
                            <option value="1">Estado de cuenta</option>
                          </select>
               
                          </div>
                    
                          <div class="form-group col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label>Saldo estado cuenta:</label>
                            <input type="text" class="form-control" name="total_estado" id="total_estado" placeholder="Total" disabled>
                
                          </div>
                          
                          

                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Planilla</th>
                                    <th>Mes</th>
                                    <th>Total Pago planilla</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                              
                                    <th><h4 id="total">Q/. 0.00</h4><input type="hidden" name="total_socio" id="total_socio"></th>
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
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/pago_socios.js"></script>
<?php
}
ob_end_flush();
?>
