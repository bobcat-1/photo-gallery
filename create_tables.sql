create table albums (
	id int auto_increment not null, 
	name varchar(50) not null, 
	description varchar(200) not null, 
	photographer varchar(50) not null, 
	email varchar(50), 
	phone varchar(25) default null,
	creation_date int(11) not null,
	modification_date int(11) default null,
	PRIMARY KEY (id)
);


create table photos (
	id int auto_increment not null,
	album_id int not null,
	title varchar(50) not null,
	address_photo varchar(200),
	filename varchar(255) not null,
	creation_date int(11) not null,
	primary key (id),
	foreign key (album_id) references albums(id)
);