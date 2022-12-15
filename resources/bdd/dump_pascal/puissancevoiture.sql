use gsb_frais;


create table if not exists typeVoiture (
id int not null auto_increment ,
libelle varchar(50) not null,
prix float not null,
constraint PK_voiture primary key (id)
);


insert into typeVoiture (libelle, prix)
values ('4CV diesel', 0.52),
 ('5/6CV diesel', 0.58),
('4CV essence', 0.62),
('5/6CV essence', 0.67);

alter table lignefraisforfait add  idTypeVoiture int null;
-- add constraint FK_utilisateur_voiture foreign key (idvoiture) references voiture(id);



