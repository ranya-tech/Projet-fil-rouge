CREATE DATABASE smartphone_store;
USE smartphone_store;

CREATE TABLE Client(
    idClient INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    adresse TEXT NOT NULL
)
CREATE TABLE Produit(
    idProduit INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prix DECIMAL(10,2),
    description TEXT,
    marque VARCHaR(50),
    stock INT NOT NULL DEFAULT 0
)
CREATE TABLE Commande(
    idCommande INT AUTO_INCREMENT PRIMARY KEY,
    dateCmd DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('En attente', 'Expédiée', 'Livrée') DEFAULT 'En attente',
    total DECIMAL(10, 2) DEFAULT 0.00,
    idClient INT NOT NULL,
    FOREIGN KEY(idClient) REFERENCES Client(idClient)
)