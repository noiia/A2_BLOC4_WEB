CREATE database Inter_net_BDD;
USE Inter_net_BDD;
CREATE TABLE Users(
   ID_users INT(255) AUTO_INCREMENT,
   Login VARCHAR(50) NOT NULL,
   Password VARCHAR(50) NOT NULL,
   Name VARCHAR(50) NOT NULL,
   Surname VARCHAR(50) NOT NULL,
   Birth_date DATE,
   Profile_description TEXT,
   Email VARCHAR(319) NOT NULL,
   Role TINYINT(255) NOT NULL,
   Del BOOL NOT NULL,
   PRIMARY KEY(ID_users)
);

CREATE TABLE Skills(
   ID_skills INT(255) AUTO_INCREMENT,
   Name VARCHAR(50) NOT NULL,
   Del BOOL NOT NULL,
   PRIMARY KEY(ID_skills)
);

CREATE TABLE Location(
   ID_location INT(255) AUTO_INCREMENT,
   City VARCHAR(50) NOT NULL,
   Zip_code CHAR(5) NOT NULL,
   Departement CHAR(2) NOT NULL,
   Del BOOL NOT NULL,
   PRIMARY KEY(ID_location)
);

CREATE TABLE Sector(
   ID_sector BOOL,
   Name VARCHAR(50) NOT NULL,
   Del BOOL NOT NULL,
   PRIMARY KEY(ID_sector)
);

CREATE TABLE Promotion(
   ID_promotion INT(255) AUTO_INCREMENT,
   Name VARCHAR(50) NOT NULL,
   Del BOOL NOT NULL,
   ID_location INT(255) NOT NULL,
   PRIMARY KEY(ID_Promotion),
   FOREIGN KEY(ID_location) REFERENCES Location(ID_location)
);

CREATE TABLE Company(
   ID_company INT(255) AUTO_INCREMENT,
   Name VARCHAR(50) NOT NULL,
   SIRET VARCHAR(50) NOT NULL,
   Creation_date DATE,
   Staff VARCHAR(50) NOT NULL,
   Type VARCHAR(50) NOT NULL,
   Company_description TEXT,
   Del BOOL NOT NULL,
   ID_sector BOOL NOT NULL,
   ID_location INT(255) NOT NULL,
   PRIMARY KEY(ID_company),
   FOREIGN KEY(ID_sector) REFERENCES Sector(ID_sector)
);

CREATE TABLE Internship(
   ID_Internship INT(255) AUTO_INCREMENT,
   Title VARCHAR(50) NOT NULL,
   Duration TINYINT(255),
   Starting_date DATE,
   Hourly_rate FLOAT(4,2),
   Max_places INT(255),
   Advantages VARCHAR(300),
   Worktime INT(255),
   Description TEXT,
   Del BOOL NOT NULL,
   ID_company INT(255) NOT NULL,
   ID_location INT(255) NOT NULL,
   PRIMARY KEY(ID_Internship),
   FOREIGN KEY(ID_company) REFERENCES Company(ID_company),
   FOREIGN KEY(ID_location) REFERENCES Location(ID_location)
);

CREATE TABLE Rate(
   ID_rate INT(255) AUTO_INCREMENT,
   Note TINYINT(255) NOT NULL,
   Description VARCHAR(50),
   Del BOOL NOT NULL,
   ID_company INT(255) NOT NULL,
   ID_users INT(255) NOT NULL,
   PRIMARY KEY(ID_rate),
   FOREIGN KEY(ID_company) REFERENCES Company(ID_company),
   FOREIGN KEY(ID_users) REFERENCES Users(ID_users)
);

CREATE TABLE Seek(
   ID_Internship INT(255),
   ID_skills INT(255),
   PRIMARY KEY(ID_Internship, ID_skills),
   FOREIGN KEY(ID_Internship) REFERENCES Internship(ID_Internship),
   FOREIGN KEY(ID_skills) REFERENCES Skills(ID_skills)
);

CREATE TABLE Wishlist(
   ID_users INT(255),
   ID_Internship INT(255),
   PRIMARY KEY(ID_users, ID_Internship),
   FOREIGN KEY(ID_users) REFERENCES Users(ID_users),
   FOREIGN KEY(ID_Internship) REFERENCES Internship(ID_Internship)
);

CREATE TABLE Appliement(
   ID_users INT(255),
   ID_Internship INT(255),
   Accepted BOOL NOT NULL,
   PRIMARY KEY(ID_users, ID_Internship),
   FOREIGN KEY(ID_users) REFERENCES Users(ID_users),
   FOREIGN KEY(ID_Internship) REFERENCES Internship(ID_Internship)
);

CREATE TABLE Manage_company(
   ID_users INT(255),
   ID_company INT(255),
   PRIMARY KEY(ID_users, ID_company),
   FOREIGN KEY(ID_users) REFERENCES Users(ID_users),
   FOREIGN KEY(ID_company) REFERENCES Company(ID_company)
);

CREATE TABLE Have_proms(
   ID_users INT(255),
   ID_Promotion INT(255),
   PRIMARY KEY(ID_users, ID_Promotion),
   FOREIGN KEY(ID_users) REFERENCES Users(ID_users),
   FOREIGN KEY(ID_Promotion) REFERENCES Promotion(ID_Promotion)
);

CREATE TABLE Look_for(
   ID_Internship INT(255),
   ID_Promotion INT(255),
   PRIMARY KEY(ID_Internship, ID_Promotion),
   FOREIGN KEY(ID_Internship) REFERENCES Internship(ID_Internship),
   FOREIGN KEY(ID_Promotion) REFERENCES Promotion(ID_Promotion)
);