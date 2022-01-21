SELECT IFNULL(Salidas.Salidas,0)-Entradas.Entradas as Ganacia 
From ( Select distinct idproducto From operacion ) as Datos 
Left join ( Select o.idproducto, Sum(cantidad*price_compra) as Entradas from operacion o 
inner join producto p ON p.idproducto=o.idproducto 
WHERE o.tipo_operacion_id='1' AND o.idalmacen='1' and p.tipo_producto='2') as Entradas On Datos.idproducto = Entradas.idproducto 
Left join ( Select o.idproducto, Sum(cantidad*idprecio_lis) as Salidas from operacion o 
inner join producto p ON p.idproducto=o.idproducto 
WHERE o.tipo_operacion_id='2' AND o.idalmacen='1' and p.tipo_producto='2') as Salidas On Datos.idproducto = Salidas.idproducto



SELECT (( Select Sum(cantidad*price_compra) as Entradas from operacion o inner join producto p ON p.idproducto=o.idproducto WHERE o.tipo_operacion_id='1' AND o.idalmacen='1' and p.tipo_producto='2') - ( Select Sum(cantidad*idprecio_lis) as Salidas from operacion o inner join producto p ON p.idproducto=o.idproducto WHERE o.tipo_operacion_id='2' AND o.idalmacen='1' and p.tipo_producto='2')) as TOTAL