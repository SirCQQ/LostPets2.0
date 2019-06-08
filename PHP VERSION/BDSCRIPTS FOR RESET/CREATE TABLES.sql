drop table userinfo;
drop table user_pet;
drop table allpets;
drop table ZoneDeInteres;
drop table notificari;

CREATE TABLE UserInfo
 (User_Id Number(10) not null primary key,
 Nume varchar(20) NOT NULL ,
 Prenume varchar(30) NOT NULL,
 Email varchar(40)NOT NULL UNIQUE,
 nrTelefon varchar(10) not NULL,
 user_Password varchar(100) NOT NULL,
 Profile_img varchar(50)
 );
 
CREATE TABLE USER_PET
(User_id NUMBER(10),
Pet_id NUMBER(10)
);
 
CREATE TABLE  AllPets
  (
  Pet_Id number(10) primary key not null,
  Pet_Name varchar(20),
  pet_type varCHAR(20) not null,
  Poza_Img varchar(30)NOT NULL,
  zona_pierdut varCHAR(30) NOT NULL,
  Zona_Gasite varCHAR(30),
  reward varchar(10),
  Finder_ID NUMBER(10),
  date_lost date,
  date_found date,
  pet_details varchar(1000),
  lat_found varchar(30),
  lon_found varchar(30),
  lat_lost varchar(30),
  lon_lost varchar(30),
  pet_status varchar(10)
  );

  CREATE TABLE notificari 
  (
    pet_id number(10),
    nume_zona varchar(50),
    nume_animal varchar(50),
    status_pet varchar(10),
    data_anunt date
  );
  
  
CREATE TABLE ZoneDeInteres 
( 
  Nume_Zona VARCHAR(50),
  Animale_disparute NUMBER(10),
  Animale_gasite NUMBER(10)
);

insert into ZoneDeInteres  values ('Copou' , 0 ,0); 
insert into ZoneDeInteres  values ('Ticau',0,0);
insert into ZoneDeInteres  values ('Zimbru',0,0);
insert into ZoneDeInteres  values ('Sararie',0,0);
insert into ZoneDeInteres  values ('Podu de fier',0,0);
insert into ZoneDeInteres  values ('Agronomie',0,0);
insert into ZoneDeInteres  values ('Targu cucului',0,0);
insert into ZoneDeInteres  values ('Tudor vladimirescu',0,0);
insert into ZoneDeInteres  values ('Bucsinescu',0,0);
insert into ZoneDeInteres  values ('Tatarasi nord',0,0);
insert into ZoneDeInteres  values ('Tatarasi sud',0,0);
insert into ZoneDeInteres  values ('Moara de vant',0,0);
insert into ZoneDeInteres  values ('Ciurchi',0,0);
insert into ZoneDeInteres  values ('Metalurgie',0,0);
insert into ZoneDeInteres  values ('Aviatiei',0,0);
insert into ZoneDeInteres  values ('Zona industriala dancu',0,0);
insert into ZoneDeInteres  values ('Baza 3',0,0);
insert into ZoneDeInteres  values ('Bularga',0,0);
insert into ZoneDeInteres  values ('Bucium',0,0);
insert into ZoneDeInteres  values ('Socola',0,0);
insert into ZoneDeInteres  values ('Frumoasa',0,0);
insert into ZoneDeInteres  values ('Manta rosie',0,0);
insert into ZoneDeInteres  values ('Podu ros',0,0);
insert into ZoneDeInteres  values ('Dimitrie cantemir',0,0);
insert into ZoneDeInteres  values ('Tesatura',0,0);
insert into ZoneDeInteres  values ('Nicolina 1',0,0);
insert into ZoneDeInteres  values ('Nicolina 2',0,0);
insert into ZoneDeInteres  values ('Cug 1',0,0);
insert into ZoneDeInteres  values ('Cug 2',0,0);
insert into ZoneDeInteres  values ('Galata 1',0,0);
insert into ZoneDeInteres  values ('Galata 2',0,0);
insert into ZoneDeInteres  values ('Podu de piatra',0,0);
insert into ZoneDeInteres  values ('Zona industriala sud',0,0);
insert into ZoneDeInteres  values ('Mircea cel batran',0,0);
insert into ZoneDeInteres  values ('Alexandru cel bun',0,0);
insert into ZoneDeInteres  values ('Gara',0,0);
insert into ZoneDeInteres  values ('Dacia',0,0);
insert into ZoneDeInteres  values ('Pacurari',0,0);
insert into ZoneDeInteres  values ('Canta',0,0);
insert into ZoneDeInteres  values ('Pacuret',0,0);
insert into ZoneDeInteres  values ('Moara de foc',0,0);
insert into ZoneDeInteres  values ('Alta locatie',0,0);

set linesize 1000;
set pagesize 1000;
SELECT * FROM ZoneDeInteres;
SELECT * FROM USERINFO;
SELECT * FROM ALLPETS;
SELECT * FROM NOTIFICARI;
SELECT * FROM USER_PET;