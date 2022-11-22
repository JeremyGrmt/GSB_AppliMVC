/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pascal.crochard
 * Created: 22 nov. 2022
 */

INSERT INTO utilisateur(id,nom,prenom,login,mdp,adresse,cp,ville,dateembauche) VALUES
('a001','Lourd','Herve','hlourd','123456','une adresse','83000','Toulon','22-10-03'),
('a002','Gabin','Jean','jgabin','123456','une adresse','83000','Toulon','22-10-03'),
('a003','Matin','Martin','mmatin','123456','une adresse','83000','Toulon','22-10-03');

INSERT INTO user_roles(id_user,id_role) VALUES
('a001',2),
('a002',2),
('a003',2);