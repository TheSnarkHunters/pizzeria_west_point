CREATE DATABASE ecommerce;
USE ecommerce;

-- UTENTI
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    ruolo ENUM('admin', 'cliente') DEFAULT 'cliente'
);

-- PRODOTTI
CREATE TABLE prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descrizione TEXT,
    prezzo DECIMAL(10,2),
    quantita INT DEFAULT 0
);

-- ORDINI
CREATE TABLE ordini (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    totale DECIMAL(10,2),
    FOREIGN KEY (utente_id) REFERENCES utenti(id)
);

-- DETTAGLI ORDINE
CREATE TABLE dettagli_ordine (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordine_id INT,
    prodotto_id INT,
    quantita INT,
    prezzo DECIMAL(10,2),
    FOREIGN KEY (ordine_id) REFERENCES ordini(id),
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id)
);

-- ADMIN DI DEFAULT (password: admin123)
INSERT INTO utenti (nome, email, password, ruolo)
VALUES ('Admin', 'admin@mail.com', 
SHA2('admin123', 256), 'admin');