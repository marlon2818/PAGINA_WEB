const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const cors = require('cors');
const bcrypt = require('bcrypt');

const app = express();
const port = 3000;

// Configurar middleware
app.use(cors());
app.use(bodyParser.json());

// Configuración de la base de datos
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root', // Usuario de XAMPP
    password: '', // Contraseña en blanco por defecto en XAMPP
    database: 'grupo3'
});

// Conectar a la base de datos
db.connect(err => {
    if (err) {
        console.error('Error al conectar a la base de datos:', err);
        return;
    }
    console.log('Conectado a la base de datos');
});

// Ruta para registrar un usuario
app.post('/register', (req, res) => {
    const { nombre, email, telefono, password } = req.body;

    // Verificar si el usuario ya existe
    db.query('SELECT * FROM users WHERE email = ?', [email], (err, results) => {
        if (err) {
            console.error('Error en la consulta:', err);
            return res.status(500).send('Error en la base de datos');
        }

        if (results.length > 0) {
            return res.status(400).send('El correo electrónico ya está registrado');
        }

        // Encriptar la contraseña
        bcrypt.hash(password, 10, (err, hash) => {
            if (err) {
                console.error('Error al encriptar la contraseña:', err);
                return res.status(500).send('Error al registrar el usuario');
            }

            // Insertar nuevo usuario
            db.query('INSERT INTO users (nombre, email, telefono, password) VALUES (?, ?, ?, ?)', 
            [nombre, email, telefono, hash], (err) => {
                if (err) {
                    console.error('Error al registrar el usuario:', err);
                    return res.status(500).send('Error al registrar el usuario');
                }
                res.status(201).send('Usuario registrado con éxito');
            });
        });
    });
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor corriendo en http://localhost:${port}`);
});
