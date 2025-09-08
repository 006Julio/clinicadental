CREATE DATABASE IF NOT EXISTS clinica_dental;
USE clinica_dental;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,  
  `rol` enum('administrador','doctor','asistente') NOT NULL,
  `creado_en` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar usuarios de ejemplo
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`) VALUES
('Admin User', 'admin@clinica.com', 'admin123', 'administrador'),
('Dr. López', 'drlopez@clinica.com', 'doctor123', 'doctor'),
('Ana Asistente', 'ana@clinica.com', 'asistente123', 'asistente');


