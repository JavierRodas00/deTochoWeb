use detocho;

insert into estados values(0, 'Pendiente');
insert into estados values(1, 'En Proceso');
insert into estados values(2, 'Enviado');
insert into estados values(3, 'Finalizado');

insert into generos values('0', "No especifica");
insert into generos values('1', "Hombre");
insert into generos values('2', "Mujer");

insert into rol values('0', "Cliente");
insert into rol values('1', "Repartidor");
insert into rol values('2', "Administrados");

insert into usuarios(correo, nombre, password, rol) values ('admin','admin',md5('admin'),'2');