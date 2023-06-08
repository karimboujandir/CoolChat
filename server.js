const WebSocket = require('ws');
const mysql = require('mysql');
const session = require('express-session');
const express = require('express');
const app = express();

// Configuration de la connexion à la base de données
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'karim34500',
  database: 'coolchat'
});

// Établissement de la connexion à la base de données
db.connect((err) => {
  if (err) {
    console.error('Erreur de connexion à la base de données :', err);
  } else {
    console.log('Connecté à la base de données');
  }
});

// Configuration de session
const sessionMiddleware = session({
  secret: 'clef-secrete-bien-securise',
  resave: false,
  saveUninitialized: true
});

// Utilisation du middleware de session dans l'application Express
app.use(sessionMiddleware);

// Création du serveur WebSocket à partir de l'application Express
const server = app.listen(9999, () => {
  console.log('Server started on port 9999');
});

const wss = new WebSocket.Server({ server });

const clients = [];

// Middleware WebSocket pour gérer les connexions
wss.on('connection', function connection(ws, req) {
  // Utilise le middleware de session pour accéder aux informations de session
  sessionMiddleware(req, {}, () => {
    // Récupère le nom d'utilisateur depuis la session
    const user = req.session.user && req.session.user.Pseudo ? req.session.user.Pseudo : 'utilisateur inconnu';

    clients.push(ws);

    ws.on('message', function incoming(message) {
      console.log('received: %s', message);
      const messageWithUsername = `${user}: ${message}`;

      // Requête SQL pour insérer le message dans la base de données
      const sql = 'INSERT INTO messages (username, message) VALUES (?, ?)';
      db.query(sql, [user, message], (err, result) => {
        if (err) {
          console.error('Erreur lors de l\'enregistrement du message :', err);
        } else {
          console.log('Message enregistré dans la base de données');
        }

        // Diffuser le message à tous les clients connectés
        broadcast(messageWithUsername);
      });
    });

    ws.send('Bienvenue sur CoolChat!');
  });
});

function broadcast(message) {
  clients.forEach(function(client) {
    client.send(message);
  });
}



