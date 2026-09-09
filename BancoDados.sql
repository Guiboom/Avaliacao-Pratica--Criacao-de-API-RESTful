CREATE DATABASE apiLanHouse;
USE apiLanHouse;

-- Tabela Pai
CREATE TABLE pessoa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100)
);

-- Tabela Filho
CREATE TABLE computador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    numero INT NOT NULL,
    status ENUM('Livre', 'Ocupado', 'Manutencao') DEFAULT 'Livre',
    pessoa_id INT NOT NULL,

    CONSTRAINT fk_computador_pessoa
        FOREIGN KEY (pessoa_id)
        REFERENCES pessoa(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- Dados de teste
INSERT INTO pessoa (nome, telefone, email) VALUES
('Guilherme', '47999990001', 'gui@email.com'),
('Joao', '47999990002', 'joao@email.com'),
('Maria', '47999990003', 'maria@email.com');

INSERT INTO computador (nome, numero, status, pessoa_id) VALUES
('PC Gamer 01', 1, 'Livre', 1),
('PC Gamer 02', 2, 'Ocupado', 1),
('PC Gamer 03', 3, 'Livre', 2),
('PC Gamer 04', 4, 'Manutencao', 3);