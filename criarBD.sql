-- banco de dados
DROP DATABASE IF EXISTS condominio;
CREATE DATABASE condominio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE condominio;

-- tabela moradores
CREATE TABLE moradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    apartamento VARCHAR(20) NOT NULL,
    bloco CHAR(1) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    servicos TEXT NULL,
    observacoes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- indicies perf
ALTER TABLE moradores ADD INDEX idx_email (email);
ALTER TABLE moradores ADD INDEX idx_bloco (bloco);
ALTER TABLE moradores ADD INDEX idx_apartamento (apartamento);
