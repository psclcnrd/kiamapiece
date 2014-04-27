-- Creation de la base pour le site kiamapiece.com
-- CONRAD Pascal
-- Version 1.0 08/04/2014

-- Version 1.1 23/04/2014 - Ajout de la table des régions
-- Version 1.2 26/04/2014 - Ajout de la table des villes


-- Création de la base de données forcé en UTF8
create database if not exists kiamapiece DEFAULT CHARACTER SET UTF8;

use kiamapiece;

-- Création de la table des région (V 1.1)
create table if not exists Region (
  Id bigint primary key not null auto_increment,
  Description varchar(120) not null
);

-- Création de la table des villes (V 1.2)
create table if not exists Towns (
  Id bigint primary key not null auto_increment,
  CP integer not null,
  Name varchar(250) not null
);


-- Création de la base des utilisateurs
create table IF NOT EXISTS MainUser (
  Id bigint primary key not null auto_increment,
  Email varchar(200) not null,
  Name varchar(80) not null,
  Surname varchar(120) not null,
  phone1 varchar(20) not null,
  phone2 varchar(20),
  MainAddress bigint not null,
  CreateDate DateTime not null,
  LastActivity DateTime,
  Note bigint default -1,
  Revoked enum('Y','N') default 'N',
  RegionId integer not null,
  PrivateUser enum('Y','N') default 'Y',
  index idx_mainuser_region (RegionId),
  constraint foreign key fk_mainuser_region (RegionId) references Region(Id)
);

-- Création de la base des Adresses
create table if not exists Addresses (
  Id bigint primary key not null auto_increment,
  UserId bigint not null,
  Number integer,
  Street varchar(120) not null,
  Complement varchar(100),
  PostalCode integer not null,
  Town varchar(100) not null,
  Country integer not null,
  MainAddress enum('Y','N') default 'Y',
  index idx_Addresses_User (UserId),
  constraint foreign key fk_address_user(UserId) references MainUser(Id)
);

-- Création de la table des marques
create table if not exists Brand (
  Id bigint primary key not null auto_increment,
  Description varchar(120) not null
);

-- Création de la table des types d'appareils
create table if not exists ApplianceType (
  Id bigint primary key not null auto_increment,
  Description varchar(120) not null
);

-- Création de la table des status
create table if not exists Status (
  Id bigint primary key not null,
  Description varchar(120) not null
);

insert into Status values (1,"Disponible");
insert into Status values (2,"Traitement en cours");
insert into Status values (3,"Traitement terminé");
insert into Status values (4,"Refusé");
insert into Status values (5,"Annulé par dépositaire");
insert into Status values (6,"Annulé par demandeur");

create table if not exists SendingMode (
  Id bigint primary key not null,
  Description varchar(120) not null
);

insert into SendingMode values (1,"Par courrier");
insert into SendingMode values (2,"A démonter sois même");

create table if not exists PieceType (
  Id bigint primary key not null auto_increment,
  ApplianceTypeId bigint,
  Description varchar(120) not null,
  index idx_piecetype_appliance (ApplianceTypeId),
  constraint foreign key fk_piecetype_appl (ApplianceTypeId) references ApplianceType(Id)
);

-- Creation de la table des logs
-- Pas de contraintes, afin d'accelerer le traitement.
create table if not exists logs (
  Id bigint primary key not null auto_increment,
  UserId bigint not null,
  Operation varchar(200) not null,
  OperationDate timestamp not null,
  RequestId bigint not null,
  index idx_logs_OpDate (OperationDate),
  index idx_logs_User (UserId),
  index idx_logs_Request (RequestId)
);

-- Création de la base des Piéces détachées
create table if not exists Pieces (
  Id bigint primary key not null auto_increment,
  UserId bigint not null,
  AddressId bigint not null,
  BrandId bigint not null,
  ApplianceTypeId bigint not null,
  PieceTypeId bigint not null,
  SendingModeId bigint not null,
  CreateDate DateTime not null,
  StatusId bigint not null default 1,
  Comments text,
  index idx_pieces_User (UserId),
  index idx_pieces_p1 (BrandId,StatusId),
  index idx_pieces_p2 (BrandId,ApplianceTypeId,StatusId),
  index idx_pieces_p3 (BrandId,ApplianceTypeId,PieceTypeId,StatusId),
  constraint foreign key fk_pieces_user(UserId) references MainUser(Id),
  constraint foreign key fk_pieces_address(AddressId) references Addresses(Id),
  constraint foreign key fk_pieces_brand(BrandId) references Brand(Id),
  constraint foreign key fk_pieces_Appliance(ApplianceTypeId) references ApplianceType(Id),
  constraint foreign key fk_pieces_piecetype(PieceTypeId) references PieceType(Id),
  constraint foreign key fk_pieces_sendingmode(SendingModeId) references SendingMode(Id),
  constraint foreign key fk_pieces_status(StatusId) references Status(Id)
);

-- Création de la base des demandes
create table if not exists Request (
  Id bigint primary key not null auto_increment,
  UserDepositaryId bigint not null,
  UserApplicantId bigint not null,
  DateRequest DateTime not null,
  PieceId bigint not null,
  index idx_request_user1 (UserDepositaryId),
  index idx_request_user2 (UserApplicantId),
  constraint foreign key fk_request_user1(UserDepositaryId) references MainUser(Id),
  constraint foreign key fk_request_user2(UserApplicantId) references MainUser(Id),
  constraint foreign key fk_request_piece(PieceId) references Pieces(Id)
);

-- Création de l'utilisateur
grant select,insert,delete,update on kiamapiece.* to kmp_user@localhost identified by '2OjDialgIn';
