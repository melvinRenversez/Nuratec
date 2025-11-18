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


select * from communes;
select * from codes_postaux;

delete from codes_postaux where id between 1 and 10000000000;
delete from communes where id between 1 and 10000000000;

ALTER TABLE communes AUTO_INCREMENT = 1;
ALTER TABLE codes_postaux AUTO_INCREMENT = 1;



