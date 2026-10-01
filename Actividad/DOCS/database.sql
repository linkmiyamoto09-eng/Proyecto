CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

-- Tabla Usuario basada en el diagrama ER
CREATE TABLE IF NOT EXISTS Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(50) DEFAULT 'usuario',
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- Tabla Tarea con relacion 1:N con Usuario
CREATE TABLE IF NOT EXISTS Tarea (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_creador INT NOT NULL,
    id_proy INT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    f_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    f_termino DATETIME NULL,
    estado VARCHAR(50) DEFAULT 'Pendiente',
    prioridad VARCHAR(20) DEFAULT 'Media',
    categoria VARCHAR(50) DEFAULT 'General',
    FOREIGN KEY (id_creador) REFERENCES Usuario(id) ON DELETE CASCADE
);