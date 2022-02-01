SELECT IFNULL(Salidas.Salidas,0)-Entradas.Entradas as Ganacia 
From ( Select distinct idproducto From operacion ) as Datos 
Left join ( Select o.idproducto, Sum(cantidad*price_compra) as Entradas from operacion o 
inner join producto p ON p.idproducto=o.idproducto 
WHERE o.tipo_operacion_id='1' AND o.idalmacen='1' and p.tipo_producto='2') as Entradas On Datos.idproducto = Entradas.idproducto 
Left join ( Select o.idproducto, Sum(cantidad*idprecio_lis) as Salidas from operacion o 
inner join producto p ON p.idproducto=o.idproducto 
WHERE o.tipo_operacion_id='2' AND o.idalmacen='1' and p.tipo_producto='2') as Salidas On Datos.idproducto = Salidas.idproducto



SELECT (( Select Sum(cantidad*price_compra) as Entradas from operacion o inner join producto p ON p.idproducto=o.idproducto WHERE o.tipo_operacion_id='1' AND o.idalmacen='1' and p.tipo_producto='2') - ( Select Sum(cantidad*idprecio_lis) as Salidas from operacion o inner join producto p ON p.idproducto=o.idproducto WHERE o.tipo_operacion_id='2' AND o.idalmacen='1' and p.tipo_producto='2')) as TOTAL



SELECT SUM(Datos.sueldos-(Datos.sueldos/30*ifnull(Falta.Falta,0)))as totalplanilla,datos.idplanilla,Falta.idpersona,Datos.sueldos 
From ( Select pa.idplanilla,dt.sueldos From planilla pa inner join datos_planilla dt ON pa.idplanilla=dt.idplanilla) as Datos 
Left join ( Select pa.idplanilla,asis.idpersona,COUNT(asis.tipo_asistencia) as Falta from asistencia asis 
INNER JOIN persona p ON asis.idpersona=p.idpersona 
INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado
WHERE asis.tipo_asistencia='2' AND asis.fecha BETWEEN pa.fecha_inicio and pa.fecha_final 
GROUP by asis.idpersona,pa.idplanilla) as Falta On Datos.idplanilla = Falta.idplanilla 
GROUP by Falta.idpersona,Falta.idplanilla 
ORDER by Falta.idplanilla asc



Select DISTINCT pa.idplanilla,asis.idpersona, COUNT(asis.tipo_asistencia) as Falta from asistencia asis
 INNER JOIN persona p ON asis.idpersona=p.idpersona 
 INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado 
 Inner Join datos_planilla dt ON dt.idplanilla=pa.idplanilla
  WHERE asis.tipo_asistencia='2'AND asis.fecha 
BETWEEN pa.fecha_inicio and pa.fecha_final GROUP by asis.idpersona,pa.idplanilla,dt.idpersona


SELECT SUM(Datos.sueldos-(Datos.sueldos/30*ifnull(Falta.Falta,0)))as totalplanilla,datos.idplanilla,Falta.idpersona,Datos.sueldos 
From ( Select pa.idplanilla,dt.sueldos From planilla pa inner join datos_planilla dt ON pa.idplanilla=dt.idplanilla) as Datos 
Left join ( Select DISTINCT pa.idplanilla,asis.idpersona, COUNT(asis.tipo_asistencia) as Falta from asistencia asis
 INNER JOIN persona p ON asis.idpersona=p.idpersona 
 INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado 
 Inner Join datos_planilla dt ON dt.idplanilla=pa.idplanilla
  WHERE asis.tipo_asistencia='2'AND asis.fecha 
BETWEEN pa.fecha_inicio and pa.fecha_final GROUP by asis.idpersona,pa.idplanilla,dt.idpersona) as Falta On Datos.idplanilla = Falta.idplanilla 
GROUP by Falta.idpersona,Falta.idplanilla 
ORDER by Falta.idplanilla asc


SELECT (datos.sueldos-(datos.sueldos/30*ifnull(Falta.Falta,0)))as totalplanilla,Falta.idpersona From ( Select pa.idplanilla,dt.sueldos,dt.idpersona From planilla pa inner join datos_planilla dt ON pa.idplanilla=dt.idplanilla) as Datos Left join ( Select DISTINCT dt.idplanilla,asis.idpersona, COUNT(asis.tipo_asistencia) as Falta from asistencia asis INNER JOIN persona p ON asis.idpersona=p.idpersona INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado Inner Join datos_planilla dt ON dt.idplanilla=pa.idplanilla WHERE asis.tipo_asistencia='2' and p.tipo_person='3'AND asis.fecha BETWEEN pa.fecha_inicio and pa.fecha_final GROUP by asis.idpersona,pa.idplanilla,dt.idpersona) as Falta On Datos.idplanilla = Falta.idplanilla GROUP BY Falta.idpersona,Falta.idplanilla