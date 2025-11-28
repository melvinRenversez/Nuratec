use nuratec;


CREATE TABLE type_appareil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL
);


CREATE TABLE marque_appareil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES type_appareil(id) ON DELETE CASCADE
);


CREATE TABLE modele_appareil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    marque_id INT NOT NULL,
    FOREIGN KEY (marque_id) REFERENCES marque_appareil(id) ON DELETE CASCADE
);

create TABLE prise_en_charge (
	id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL
);

insert into prise_en_charge (libelle) VALUES (
'Ecran'),
('Batterie'),
('Connecteur de charge'),
('Camera');


select * from prise_en_charge;
-- Insertion des types d'appareils
INSERT INTO type_appareil (libelle) VALUES
('Smartphone'),
('Ordinateur'),
('Tablette');

-- Insertion des marques (chaque marque appartient à un type)
INSERT INTO marque_appareil (libelle, type_id) VALUES
('Apple', 1),        -- Smartphone
('Samsung', 1),      -- Smartphone
('Dell', 2),         -- Ordinateur
('HP', 2),           -- Ordinateur
('Apple', 3);        -- Tablette

-- Insertion des modèles (chaque modèle appartient à une marque)
INSERT INTO modele_appareil (libelle, marque_id) VALUES
('iPhone 14', 1),
('iPhone 15', 1),
('Galaxy S23', 2),
('Galaxy S24', 2),
('XPS 15', 3),
('Inspiron 16', 3),
('Spectre x360', 4),
('iPad Pro', 5),
('iPad Air', 5);



select * from type_appareil;
select * from marque_appareil;
select * from modele_appareil;


select t.id as id_type, 
	t.libelle as type_nom, 
	ma.id as id_marque, 
	ma.libelle as marque_nom, 
	mo.id as id_model, 
	mo.libelle as modele_nom
from type_appareil t
join marque_appareil ma on ma.type_id = t.id
join modele_appareil mo on mo.marque_id = ma.id;



CREATE TABLE communes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE codes_postaux (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code_postal VARCHAR(10) NOT NULL,
    commune_id INT NOT NULL,
    FOREIGN KEY (commune_id) REFERENCES communes(id) ON DELETE CASCADE
);


select * from communes where nom like "%aubry%";
select * from codes_postaux;

delete from codes_postaux where id between 1 and 10000000000;
delete from communes where id between 1 and 10000000000;

ALTER TABLE communes AUTO_INCREMENT = 1;
ALTER TABLE codes_postaux AUTO_INCREMENT = 1;

select count(commune_id)
from codes_postaux
group by commune_id
having count(commune_id) > 15
;

select * from communes where nom like '%Aubry%';

select * from codes_postaux where commune_id = 21773;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    mail VARCHAR(150) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    adresse VARCHAR(255),
    ville_id INT,
    code_postal_id INT,
    FOREIGN KEY (ville_id) REFERENCES communes(id) ON DELETE SET NULL,
    FOREIGN KEY (code_postal_id) REFERENCES codes_postaux(id) ON DELETE SET NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE credentials (
    user_id INT PRIMARY KEY,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



select nuratec.verifyPassword('Melvin', hashPassword('Melvin'));

insert into users(nom, prenom, mail, telephone, adresse, ville_id, code_postal_id) values (
'melvin',
'renversez',
'mail@gmail.Com',
'0606060606',
'31 ville de la ville',
'21773',
'22088'
);


insert into credentials (user_id, password_hash) values (
2,
hashPassword('melvinmdp')
);

select * from users;
select * from credentials;

select u.id, nom, prenom, mail, password_hash
from users u
join credentials c on c.user_id = u.id
where mail = 'mail@gmail.com';



SELECT u.id as user_id, verifyPassword('melvinmdp', password_hash) AS password_match
FROM users u
JOIN credentials c ON c.user_id = u.id
WHERE mail = 'mail@gmail.com';


select * from codes_postaux;

select * 
from users u
join codes_postaux cp on cp.id = u.code_postal_id
join communes co on co.id = u.ville_id;


select u.id 
from users u 
join credentials c on c.user_id = u.id
where u.mail = 'melvinrenversez003@gmail.com' and verifyPassword('tretretre' , c.password_hash);





