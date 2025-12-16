use nuratec;

create table prise_en_charge(
id int auto_increment primary key,
libelle varchar(255) not null,

modele_ref int not null,
prix float not null,

created_at timestamp default current_timestamp,
updated_at timestamp default current_timestamp,

foreign key (modele_ref) references modele_appareil(id)


);