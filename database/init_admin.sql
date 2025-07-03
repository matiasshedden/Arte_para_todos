CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Inserta el usuario admin con la contraseña hasheada
-- Genera el hash en PHP y reemplázalo aquí
INSERT INTO admins (username, password_hash) VALUES (
    'admin',
    '$2y$10$ObjHy3igRje0E9m5584XR.ak5GPHXWN.J8FwJD8J//7sQisUmWzSm'
);

