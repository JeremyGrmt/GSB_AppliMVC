drop table if exists journalisationechecconnexion;

create table if not exists journalisationechecconnexion(
    ip varchar(100) not null,
    nbEchec int not null default 0,
    horodatage date,
    constraint PK_journalisationechecconnexion PRIMARY KEY (ip)
);
