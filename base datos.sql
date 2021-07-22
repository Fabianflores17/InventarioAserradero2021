create database sistemainvent
use sistemainvent


-- Estructura de tabla para la tabla `usuario`--
create table usuario(
	id int not null auto_increment primary key,
	nombre varchar(50) not null,
	apellido varchar(50) not null,
	telefono varchar(20),
	email varchar(255) not null,
	cargo varchar(50) not null,
	login varchar(50) not null,
	password varchar(60) not null,
	imagen varchar(255),
	condicion tinyint(1) NOT NULL DEFAULT '1',
	created_at datetime not null
);

-- Estructura de tabla para la tabla `permiso`--
create table permiso(
	id int not null auto_increment primary key,
	nombre varchar(50) not null
);


-- Estructura de tabla para la tabla `usuario_permiso`--
create table Usuario_permiso(
	id int not null auto_increment primary key,
	idusuario int(11) NOT NULL,
  	idpermiso int(11) NOT NULL
);

create table categoria(
	id int not null auto_increment primary key,
	nombre varchar(50) not null,
	descripcion varchar(50) default null,
	condicion  tinyint(1) NOT NULL DEFAULT '1',
	created_at datetime not null
);


/*
table: producto
kind: 1. product, 2. service
*/
create table producto(
	id int not null auto_increment primary key,
	imagen varchar(255),
	codigo varchar(50) not null,
	nombre varchar(50) not null,
	descripcion text not null,
	inventario_min int not null default 10,
	precio_en float not null,
	id_precio_lis float null,
	unit varchar(255) not null,
	presentation varchar(255) not null,
	idusuario int not null,
	idcategoria int,
	created_at datetime not null,
	kind int not null default 1,
	condicion  tinyint(1) NOT NULL DEFAULT '1',
	foreign key (idcategoria) references categoria(id),
	foreign key (idusuario) references usuario(id)
);


/*
person kind
1.- Cliente
2.- Proveedor
3.- Colaborador
*/
create table persona(
	id int not null auto_increment primary key,
	nombre varchar(255) not null,
	apellido varchar(50) not null,
	nit varchar(20),
	empresa varchar(50),
	direccion varchar(50),
	telefono varchar(25),
	telefono1 varchar(25),
	email varchar(50),
	cargo varchar(50),
	activar_credito boolean not null default 0,
	limite_credito double, /* 0 para credito ilimitado */
	tipo_person int,
	condicion  tinyint(1) NOT NULL DEFAULT '1',
	created_at datetime not null
);

create table almacen(
	id int not null auto_increment primary key,
	nombre varchar(50) not null,
	direccion varchar(255),
	telefono varchar(25),
	email varchar(255),
	is_principal boolean not null,
	created_at datetime not null
);



create table caja(
	id int not null auto_increment primary key,
	idalmacen int not null,
	created_at datetime not null
);


/* Tabla transaccion: Ventas, compras, traspasos*/
create table transaccion(
	id int not null auto_increment primary key,
	codigo_factura varchar(255),
	invoice_file varchar(255),
	comentario text,
	ref_id int,
	sell_from_id int,
	idpersona int ,
	idusario int ,
	tipo_operacion_id int default 2,
	caja_id int,
	tipo_pago int,
	estatus int,
	forma_pago int,
	total double,
	efectivo double,
	iva double, /* impuesto actual del producto */
	descuento double,
	is_draft boolean not null default 0,
	almacen_to_id int,
	almacen_des_id int,
	status int default 1,
	foreign key (caja_id) references caja(id),
	foreign key (idusario) references usuario(id),
	foreign key (idpersona) references persona(id),
	created_at datetime not null
);

create table operacion(
	id int not null auto_increment primary key,
	idproducto int not null,
	idalmacen int not null,
	idalmacen_des int,
	operation_from_id int,
	cantidad float not null,
	price_compra double, /* precio actual del producto */
	idprecio_lis double, /* precio actual del producto */
	tipo_operacion_id int not null,
	trasaccion_id int,
	status int default 1,
	is_draft boolean not null default 0,
	is_traspase boolean not null default 0,
	created_at datetime not null,
	foreign key (idalmacen) references almacen(id),
	foreign key (idalmacen_des) references almacen(id),
	foreign key (idproducto) references producto(id),
	foreign key (trasaccion_id) references transaccion(id)
);

create table gastos_ingreso(
	id int not null auto_increment primary key,
	nombre varchar(50) not null,
	total double,
	caja_id int,
	created_at datetime,
	foreign key(caja_id) references caja(id)
);



/* (1,"Cargo"),(2,"Abono") */

create table credito(
	id int not null auto_increment primary key,
	tipo_pago_id int not null,
	transaccion_id int,
	idpersona int not null,
	total double,
	created_at datetime not null,
	foreign key (idpersona ) references persona(id),
	foreign key (trasaccion_id) references transaccion(id)
);

/* caja chica*/

create table cajachica(
	id int not null auto_increment primary key,
	nombre varchar(255),
	descripcion text,
	monto float,
	date_at date,
	kind int,/*1. in, 2. out*/
	created_at datetime
);

/* mensaje */

create table mensaje(
	id int not null auto_increment primary key,
	codigo varchar(255),
	mensaje varchar(255),
	user_from int not null,
	user_to int not null,
	is_read boolean not null default 0,
	created_at datetime
);

create table pago(
	id int not null auto_increment primary key,
	tipo_pago int,
	cantidad float,
	pago double,
	idpersona int,
	idusuario int,
	created_at datetime not null,
	foreign key (idpersona) references persona(id),
	foreign key (idusuario) references usuario(id)
);




