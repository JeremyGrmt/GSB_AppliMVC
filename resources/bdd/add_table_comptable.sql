use gsb_frais;

create table if not exists comptable (
	id char(4) NOT NULL,
	nom char(30) DEFAULT NULL,
	prenom char(30)  DEFAULT NULL, 
	login char(20) DEFAULT NULL,
	mdp char(20) DEFAULT NULL,
	adresse char(30) DEFAULT NULL,
	cp char(5) DEFAULT NULL,
	ville char(30) DEFAULT NULL,
	dateembauche date DEFAULT NULL,
	PRIMARY KEY (id)
)ENGINE =InnoDB;