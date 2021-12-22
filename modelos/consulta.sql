Select Datos.`idproducto`,p.codigo, p.nombre,c.nombre, Entradas.Entradas - IFNULL(Salidas.Salidas,0) 
From ( Select distinct `idproducto` From operacion ) Datos 
Left join ( Select `idproducto`, Sum(`cantidad`) Entradas from operacion WHERE `tipo_operacion_id`="1" AND `idalmacen`='1' 
Group by `idproducto`) Entradas On Datos.`idproducto` = Entradas.`idproducto` 
Left join ( Select `idproducto`, Sum(`cantidad`) Salidas from operacion WHERE `tipo_operacion_id`="2" AND `idalmacen`='1' 
Group by `idproducto`) Salidas On Datos.`idproducto` = Salidas.`idproducto`
INNER JOIN producto as p ON Datos.idproducto=P.idproducto 
INNER JOIN categoria as c ON c.idcategoria=p.idcategoria
WHERE p.condicion='1'