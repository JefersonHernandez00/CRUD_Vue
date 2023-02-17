-- Crea una nueva tabla llamada 'personas'
CREATE TABLE personas (
  -- Crea una columna llamada 'id' que sea un número entero, se autoincremente y es la clave primaria de la tabla
  id INT AUTO_INCREMENT PRIMARY KEY,
  -- Crea una columna llamada 'nombre' que sea de tipo VARCHAR con una longitud máxima de 100 caracteres y no puede estar vacía
  nombre VARCHAR(100) NOT NULL,
  -- Crea una columna llamada 'apellido' que sea de tipo VARCHAR con una longitud máxima de 100 caracteres y no puede estar vacía
  apellido VARCHAR(100) NOT NULL,
  -- Crea una columna llamada 'no_identificacion' que sea de tipo VARCHAR con una longitud máxima de 100 caracteres y no puede estar vacía
  no_identificacion VARCHAR(100) NOT NULL,
  -- Crea una columna llamada 'direccion' que sea de tipo VARCHAR con una longitud máxima de 200 caracteres y no puede estar vacía
  direccion VARCHAR(200) NOT NULL
);

-- Inserta tres filas en la tabla 'personas' con los siguientes valores
INSERT INTO `personas` (`nombre`, `apellido`, `no_identificacion`, `direccion`) VALUES
('Juan', 'Hernandez', '1096543278', 'Calle 73537473'),
('Jimena', 'Sanchez', '109783743', 'Crr 73734'),
('Carlos', 'Cruz', '109373633', 'Cll 483773');
