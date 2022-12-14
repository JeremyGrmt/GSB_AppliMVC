use gsb_frais;
create table if not exists typeVoiture (
id int not null auto_increment primary key,
libelle varchar(50) not null,
montant float not null
);

alter table lignefraisforfait
add column idTypeVoiture int null;
