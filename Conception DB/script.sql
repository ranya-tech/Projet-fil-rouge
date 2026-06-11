CREATE DATABASE smartphone_store;
USE smartphone_store;

CREATE TABLE Client(
    idClient INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mot_de_passe TEXT NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'client'
);
CREATE TABLE Phones(
    idPhone INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(100),
    prix DECIMAL(10,2),
    description TEXT,
    marque VARCHaR(50),
    stock INT NOT NULL DEFAULT 0,
    ram VARCHAR(20),
    stockage VARCHAR(20),
    couleur VARCHAR(50), 
    batterie VARCHAR(50),
    camera VARCHAR(100),
    image TEXT,
    categorie ENUM('phones', 'accessoirs') DEFAULT 'phones'
);
CREATE TABLE Commande(
    idCommande INT AUTO_INCREMENT PRIMARY KEY,
    dateCmd DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('En attente', 'Expédiée', 'Livrée') DEFAULT 'En attente',
    idClient INT NOT NULL,
    FOREIGN KEY(idClient) REFERENCES Client(idClient)
);
CREATE TABLE Livraison(
    idLivraison INT AUTO_INCREMENT PRIMARY KEY,
    adresse TEXT NOT NULL,
    destinataire TEXT NOT NULL,
    dateLivraison DATETIME NOT NULL,
    idCommande INT NOT NULL,
    FOREIGN KEY(idCommande) REFERENCES Commande(idCommande)
);
CREATE TABLE ProduitCmd(
    idProduitCmd INT AUTO_INCREMENT PRIMARY KEY,
    idPhones INT NOT NULL, 
    idCommande INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    couleur VARCHAR(50),                   
    stockage VARCHAR(20),                  
    FOREIGN KEY (idPhones) REFERENCES Phones(idPhone),
    FOREIGN KEY (idCommande) REFERENCES Commande(idCommande)
);