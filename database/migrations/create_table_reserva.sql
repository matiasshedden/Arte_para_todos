CREATE TABLE reserva (
    dni VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    nro_personas INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);