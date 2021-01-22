CREATE DATABASE sistemasdistribuidos;

CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    access_token VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE aluno (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    morada VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE curso (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255),
    descricao VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE alunocurso (
    curso_id INT NOT NULL,
    aluno_id INT NOT NULL,
    nota INT,
    PRIMARY KEY(curso_id, aluno_id),
    CONSTRAINT FK_CURSO_ALUNO
        FOREIGN KEY (curso_id)
            REFERENCES curso(id),
    CONSTRAINT FK_ALUNO_CURSO
        FOREIGN KEY (aluno_id)
            REFERENCES aluno(id)
);