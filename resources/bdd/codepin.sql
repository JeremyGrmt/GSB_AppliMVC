/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  pascal.crochard
 * Created: 17 nov. 2022
 */

ALTER TABLE utilisateur ADD email TEXT NULL;
UPDATE utilisateur SET email = CONCAT(login,"@swiss-galaxy.com");

ALTER TABLE utilisateur ADD codea2f CHAR(4);