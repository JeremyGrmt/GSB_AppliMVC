drop TABLE if exists comptable;

create table if not exists comptable(
    id char(4) not null,
    nom char(30), 
    prenom char(30),
    login char(20),
    mdp char(20),
    adresse char(30),
    CP char(5),
    ville char(30),
    dateembauche char(30),
    
    CONSTRAINT PK_comptable PRIMARY KEY(id)
);

INSERT INTO comptable(id, nom, prenom, login, mdp, adresse, CP, ville, dateembauche)
	values
        ('a001', 'Lourd', 'Herve', 'hlourd', 'abcdefg38', '1 rue du murrier', '83720', 'Trans-en-provence', '2017-10-01'), 
        ('a002', 'Gabin', 'Jean', 'jgabin', 'hijklm83', '2 rue du murrier', '83720', 'Trans-en-provence', '2003-10-15'),
        ('a003', 'Matin', 'Martin', 'mmatin', 'nopqrs88', '3 rue du murrier', '83720', 'Trans-en-provence', '1999-05-13');