CREATE TABLE utenti (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) UNIQUE,
password VARCHAR(255) 
);

INSERT INTO utenti (username, PASSWORD)
VALUES ('admin', SHA2('admin123', 256));

CREATE table prodotti (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
prezzo DECIMAL(10,2),
quantita INT
);