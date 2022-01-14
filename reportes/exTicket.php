<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['ventas']==1)
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/pago.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Colaborador();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->pagocabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = "Corporacion G&G.";
$documento = "20477157772";
$direccion = "Pasasagua, San Agustin Ac, El Progeso";
$telefono = "5555555";
$email = "g&g.@gmail.com";

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        </td>
    </tr>
    <tr>
        <td align="center"><?php echo $reg->fecha; ?></td>
    </tr>
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del Colaborador en el documento HTML -->
        <td>Colaborador: <?php echo $reg->colaborador; ?></td>
    </tr>
    <tr>
       <!-- <td> < ?php echo $reg->tipo_documento.": ".$reg->num_documento; ?></td> -->
    </tr>
    <tr>
        <!-- <td>Nº de venta: < ?php echo $reg->serie_comprobante." - ".$reg->num_comprobante ; ?></td> -->
    </tr>    
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="300px">
    <tr>
        <td>DIAS/MES.</td>
        <td>PAGO</td>
        <td align="right">SUBTOTA<L/td>
    </tr>
    <tr>
      <td colspan="3">==========================================</td>
    </tr>
    <?php
    $rsptad = $venta->listarDetalle($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".$regd->cantidad."</td>";
        echo "<td>".$regd->pago;
        echo "<td align='right'>Q. ".$regd->cantidad*$regd->pago."</td>";
        echo "</tr>";
        $cantidad+=$regd->cantidad;
    }
    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL:</b></td>
    <td align="right"><b>Q.  <?php echo $reg->cantidad*$reg->pago;  ?></b></td>
    </tr>
    <tr>
     
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>      
    <tr>
      <td colspan="3" align="center">¡Pago realizado!</td>
    </tr>
    <tr>
      <td colspan="3" align="center">G&G</td>
    </tr>
    <tr>
      <td colspan="3" align="center">San Agustin AC - El progreso</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>