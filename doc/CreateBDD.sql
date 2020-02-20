Start TRANSACTION;
DROP DATABASE IF EXISTS AgenceImmoLievin;
CREATE DATABASE AgenceImmoLievin DEFAULT CHARSET = utf8 COLLATE utf8_bin;
Use AgenceImmoLievin;
SET
  default_storage_engine = INNODB;
Create Table Addresses (
    Id int AUTO_INCREMENT PRIMARY KEY,
    Address1 varchar(80),
    Address2 varchar(80),
    Address3 varchar(80),
    Address4 varchar(80),
    PostCode varchar(20),
    City varchar(80),
    State varchar(80),
    Country varchar(80),
    Created_at datetime default NOW (),
    Updated_at datetime default NOW (),
    Deleted_at datetime,
    Deleted boolean default 0
  );
Create Table PropertyTypes (
    Id int AUTO_INCREMENT PRIMARY KEY,
    Label VARCHAR(50) not null,
    Created_at datetime default NOW (),
    Updated_at datetime default NOW (),
    Deleted_at datetime,
    Deleted boolean default 0
  );
Create Table Users (
    Id int AUTO_INCREMENT PRIMARY KEY,
    IdAddress int not null,
    Email VARCHAR(255) not null,
    Password VARCHAR(255),
    LastName VARCHAR(255),
    FirstName VARCHAR(255),
    IsAdmin boolean default 0,
    Created_at datetime default NOW (),
    Updated_at datetime default NOW (),
    Deleted_at datetime,
    Deleted boolean default 0,
    CONSTRAINT FK_Users_Address FOREIGN KEY (IdAddress) REFERENCES Addresses (Id)
  );
Create Table Messages (
    Id int AUTO_INCREMENT PRIMARY KEY,
    IdUser int not null,
    ObjectMessage varchar (255) not null,
    Content text not null,
    IsRead boolean default 0,
    Created_at datetime default NOW (),
    Updated_at datetime default NOW (),
    Deleted_at datetime,
    Deleted boolean default 0,
    CONSTRAINT FK_Messages_User FOREIGN KEY (IdUser) REFERENCES Users (Id)
  );
Create Table Properties (
    Id int AUTO_INCREMENT PRIMARY KEY,
    IdAddress int not null,
    IdPropertyType int not null,
    IdUser int not null,
    Label VARCHAR(255) not null,
    Description text not null,
    IsRental boolean not null,
    Price FLOAT not null,
    EnergyClass char(1),
    LivingSpace int not null,
    Rooms int,
    BedRooms int,
    IsVisible boolean DEFAULT 0,
    IsTop boolean DEFAULT 0,
    Ref varchar(50),
    Created_at datetime default NOW (),
    Updated_at datetime default NOW (),
    Deleted_at datetime,
    Deleted boolean default 0,
    CONSTRAINT FK_Properties_Address FOREIGN KEY (IdAddress) REFERENCES Addresses (Id),
    CONSTRAINT FK_Properties_PropertyType FOREIGN KEY (IdPropertyType) REFERENCES PropertyTypes (Id),
    CONSTRAINT FK_Properties_User FOREIGN KEY (IdUser) REFERENCES Users (Id)
  );
Create Table Pictures (
    Id int AUTO_INCREMENT PRIMARY KEY,
    IdProperty int,
    Label VARCHAR(50),
    Created_at datetime default NOW (),
    Updated_at datetime default NOW (),
    Deleted_at datetime,
    Deleted boolean default 0,
    CONSTRAINT FK_Pictures_Property FOREIGN KEY (IdProperty) REFERENCES Properties (Id)
  );
Create Table Favorites (
    Id int AUTO_INCREMENT PRIMARY KEY,
    IdUser int,
    IdProperty int,
    Created_at datetime default NOW (),
    CONSTRAINT FK_Favorites_User FOREIGN KEY (IdUser) REFERENCES Users (Id),
    CONSTRAINT FK_Favorites_Property FOREIGN KEY (IdProperty) REFERENCES Properties (Id)
  );
Commit;