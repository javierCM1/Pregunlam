CREATE TABLE TipoUsuario (
                             id_tipo_usuario INT PRIMARY KEY AUTO_INCREMENT,
                             descripcion_tipo_usuario VARCHAR(50) NOT NULL
);


INSERT INTO TipoUsuario (descripcion_tipo_usuario) VALUES
                                                       ('Administrador'),
                                                       ('Editor'),
                                                       ('Usuario');


CREATE TABLE Sexo (
                      id_sexo INT PRIMARY KEY AUTO_INCREMENT,
                      descripcion_sexo VARCHAR(50) NOT NULL
);


INSERT INTO Sexo (descripcion_sexo) VALUES
                                        ('Masculino'),
                                        ('Femenino'),
                                        ('No especificar');


CREATE TABLE Usuario (
                         id_usuario INT PRIMARY KEY AUTO_INCREMENT,
                         id_tipo_usuario INT NOT NULL,
                         id_sexo INT NOT NULL,
                         userName_usuario VARCHAR(32) NOT NULL UNIQUE,
                         password_usuario VARCHAR(255) NOT NULL,
                         mail_usuario VARCHAR(254) NOT NULL UNIQUE,
                         img_usuario VARCHAR(255),
                         maxPuntaje_usuario INT DEFAULT 0,
                         nombreCompleto_usuario VARCHAR(128) NOT NULL,
                         fechaNacimiento_usuario DATE NOT NULL,
                         pais_usuario VARCHAR(255) NOT NULL,
                         fechaRegistro_usuario DATE NOT NULL DEFAULT CURRENT_DATE,
                         estado_usuario CHAR(1) NOT NULL DEFAULT 'A',
                         cantPregJugadas INT DEFAULT 0,
                         cantPregCorrectas INT DEFAULT 0,
                         FOREIGN KEY (id_tipo_usuario) REFERENCES TipoUsuario(id_tipo_usuario),
                         FOREIGN KEY (id_sexo) REFERENCES Sexo(id_sexo)
);

