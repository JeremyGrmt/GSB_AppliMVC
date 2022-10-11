drop table if exists utilisateur;
drop table if exists role;
drop table if exists user_roles;

create table if not exists utilisateur(
	id char(4) not null,
	nom char(30),
	prenom char(30),
	login char(20),
	mdp char(20),
	adresse char(30),
	cp char(5),
	ville char(30),
	dateembauche date,
        constraint Pk_utilisateur primary key (id)
);

create table if not exists role(
	id int not null auto_increment,
	role varchar(30) not null,
        constraint PK_role primary key (id)
);

create table if not exists user_roles(
	id_user char(4) not null,
	id_role int not null,
	constraint PK_userrole primary key (id_user, id_role),
	constraint FK_userrole_utilisateur foreign key (id_user) references utilisateur(id),
	constraint FK_userrole_utilisateur foreign key (id_role) references role(id)
);

alter table fichefrais drop foreign key `fichefrais_ibfk_2`;

alter table fichefrais add constraint FK_fichefrais_utilisateur foreign key (idvisiteur) references utilisateur(id);

alter table role auto_increment=1;

INSERT INTO utilisateur (id, nom, prenom, login, mdp, adresse, cp, ville, dateembauche) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', 'jux7g', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21'),
('a17', 'Andre', 'David', 'dandre', 'oppg5', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'Bedos', 'Christian', 'cbedos', 'gmhxd', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12'),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'ktp3s', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01'),
('b13', 'Bentot', 'Pascal', 'pbentot', 'doyw1', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09'),
('b16', 'Bioret', 'Luc', 'lbioret', 'hrjfs', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11'),
('b19', 'Bunisset', 'Francis', 'fbunisset', '4vbnd', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21'),
('b25', 'Bunisset', 'Denise', 'dbunisset', 's1y1r', '23 rue Manin', '75019', 'paris', '2010-12-05'),
('b28', 'Cacheux', 'Bernard', 'bcacheux', 'uf7r3', '114 rue Blanche', '75017', 'Paris', '2009-11-12'),
('b34', 'Cadic', 'Eric', 'ecadic', '6u8dc', '123 avenue de la République', '75011', 'Paris', '2008-09-23'),
('b4', 'Charoze', 'Catherine', 'ccharoze', 'u817o', '100 rue Petit', '75019', 'Paris', '2005-11-12'),
('b50', 'Clepkens', 'Christophe', 'cclepkens', 'bw1us', '12 allée des Anges', '93230', 'Romainville', '2003-08-11'),
('b59', 'Cottin', 'Vincenne', 'vcottin', '2hoh9', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18'),
('c14', 'Daburon', 'François', 'fdaburon', '7oqpv', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11'),
('c3', 'De', 'Philippe', 'pde', 'gk9kx', '13 rue Barthes', '94000', 'Créteil', '2010-12-14'),
('c54', 'Debelle', 'Michel', 'mdebelle', 'od5rt', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23'),
('d13', 'Debelle', 'Jeanne', 'jdebelle', 'nvwqq', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11'),
('d51', 'Debroise', 'Michel', 'mdebroise', 'sghkb', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17'),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', 'f1fob', '14 Place d Arc', '45000', 'Orléans', '2005-11-12'),
('e24', 'Desnost', 'Pierre', 'pdesnost', '4k2o5', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05'),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '44im8', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01'),
('e49', 'Duncombe', 'Claude', 'cduncombe', 'qf77j', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10'),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', 'y2qdu', '25 place de la gare', '23200', 'Gueret', '1995-09-01'),
('e52', 'Eynde', 'Valérie', 'veynde', 'i7sn3', '3 Grand Place', '13015', 'Marseille', '1999-11-01'),
('f21', 'Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10'),
('f39', 'Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01'),
('f4', 'Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01');

insert into role(role) values
('visiteur'),
('comptable');

insert into user_roles(id_user,id_role) VALUES
('a131',1),
('a17',1),
('a55',1),
('a93',1),
('b13',1),
('b16',1),
('b19',1),
('b25',1),
('b28',1),
('b34',1),
('b4', 1),
('b50',1),
('b59',1),
('c14',1),
('c3', 1),
('c54',1),
('d13',1),
('d51',1),
('e22',1),
('e24',1),
('e39',1),
('e49',1),
('e5', 1),
('e52',1),
('f21',1),
('f39',1),
('f4',1);

insert into utilisateur(id,nom,prenom,login,mdp,adresse,cp,ville,dateembauche) VALUES
('a001','Lourd','Herve','hlourd','123456','uneadresse','83000','Toulon','2022-10-03'),
('a002','Gabin','Jean','jgabin','123456','uneadresse','83000','Toulon','2022-10-03'),
('a003','Matin','Martin','mmatin','123456','uneadresse','83000','Toulon','2022-10-03');

insert into user_roles(id_user,id_role) VALUES
('a001',2),
('a002',2),
('a003',2);

