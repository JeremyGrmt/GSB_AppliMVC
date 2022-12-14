use gsb_frais;

create table voiture(
	id int not null auto_increment,
	voiture varchar(50),
	prix float not null,
    constraint PK_voiture primary key (id)
);

alter table utilisateur add column idvoiture int;

alter table utilisateur add constraint FK_utilisateur_voiture foreign key (idvoiture) references voiture(id);