use detocho;

create table rol(
	rol char(1) primary key,
    roldesc varchar(40)
);

create table generos(
	genero char(1) primary key,
    gdesc varchar(40)
);

create table categorias(
	categoria int auto_increment primary key,
    cdesc varchar(100)
);

create table edificios(
	edificio int auto_increment primary key,
    nombre varchar(100) not null,
    avenida varchar(30) not null,
    calle varchar(30) not null,
    zona char(2)
);

create table estados(
	estado int primary key,
    edesc varchar(100)
);

create table usuarios(
	usuario int auto_increment primary key,
	correo varchar(100) unique,
    nombre varchar(100) not null,
    apellido varchar(100), 
    genero char(1) default '0', 
    fecha_nac date,
    telefono char(12) not null,
    password varchar(200) not null, 
    rol char(1) not null default 0,
    foreign key (genero) references generos(genero),
    foreign key (rol) references rol(rol)
);

create table usuario_direccion(
	usuario_direccion int auto_increment primary key,
	usuario int,
    edificio int,
    numero varchar(100),
    foreign key (usuario) references usuarios(usuario),
    foreign key (edificio) references edificios(edificio)
);

create table productos(
	producto int auto_increment primary key,
    nombre varchar(100) not null,
    pdesc varchar(200),
    precio double not null,
    categoria int not null, 
    inventario int default 0,
    imagen longtext,
    foreign key (categoria) references categorias(categoria)
);

create table favoritos(
	favorito int auto_increment primary key,
    usuario int,
    producto int,
    foreign key (usuario) references usuarios(usuario),
    foreign key (producto) references productos(producto) on delete cascade
);


create table pedidos(
	pedido int auto_increment primary key,
    usuario int,
    fecha datetime,
    estado int, 
    direccion int,
    total double, 
    observaciones varchar(100),
    foreign key (usuario) references usuarios(usuario),
    foreign key (estado) references estados(estado),
    foreign key (direccion) references usuario_direccion(usuario_direccion)
);

create table detalle_pedido(
	pedido int,
    producto int,
    cantidad int, 
    foreign key (pedido) references pedidos(pedido),
    foreign key (producto) references productos(producto)
);