# loginCrud
##TPS php project
Descrizione

Questo progetto consiste nella creazione di un semplice portale per una biblioteca. Le entità principali del DB sono le seguenti: UTENTI, LIBRI.

Pagine e funzionalità

Homepage.php: pagina di benvenuto che indirizza alle pagine di registrazione o di login
Login_amministratori.php: pagina di login per gli amministratori
Login_utenti.php: pagina di login per gli utenti
Signup_utenti.php: pagina di registrazione di un nuovo utente
Dashboard_amministratori.php: pagina di controllo degli amministratori
Dashboard_utenti.php: pagina di controllo degli utenti
Funzionalità degli amministratori

Effettuare il logout
Creare ed eliminare utenti
Abilitare/disabilitare un utente
Visualizzare i libri disponibili (lista completa, ricerca per nome, ricerca per autore, ricerca per categoria)
Aggiungere/rimuovere libri
Modificare i dati dei libri
Funzionalità degli utenti

Eseguire il log-out
Cancellare il suo account
Visualizzare i libri disponibili (lista completa, ricerca per nome, ricerca per autore, ricerca per categoria)
Per un libro selezionato l'utente deve poter leggere le recensioni
Prendere in prestito un libro
Restituire un libro, e contestualmente lasciare una recensione
Requisiti di sicurezza

Evitare di salvare le password in chiaro: utilizzare funzioni come crypt() o password_hash() per memorizzare le password.
Utilizzare i prepare statements per prevenire attacchi di tipo SQL Injection
Sanificare l'input dell'utente per rimuovere o neutralizzare i tag e i codici JavaScript dannosi (Cross Site Scripting).
Extra: utilizzo di ulteriori tecniche per aumentare la sicurezza della pagina

CREATE TABLE utenti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50),
  cognome VARCHAR(50),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  ruolo ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE libri (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titolo VARCHAR(255) NOT NULL,
  autore VARCHAR(255) NOT NULL,
  isbn VARCHAR(13) UNIQUE,
  anno_pubblicazione INT(4),
  genere VARCHAR(100),
  quantita INT DEFAULT 0,
  descrizione TEXT,
  data_inserimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO libri (titolo, autore, isbn, anno_pubblicazione, genere, quantita, descrizione) VALUES
('Cent'anni di solitudine', 'Gabriel García Márquez', '9788845292613', 1967, 'Romanzo', 5, 'Un capolavoro della letteratura latinoamericana, che racconta la storia della famiglia Buendía nella città immaginaria di Macondo.'),
('1984', 'George Orwell', '9780451524935', 1949, 'Distopia', 3, 'Un romanzo distopico che esplora le conseguenze di un governo totalitario e onnipresente.'),
('Il Signore degli Anelli', 'J.R.R. Tolkien', '9780261102385', 1954, 'Fantasy', 7, 'Un epico racconto di avventura ambientato nella Terra di Mezzo.'),
('Il Grande Gatsby', 'F. Scott Fitzgerald', '9780743273565', 1925, 'Romanzo', 6, 'Una storia di amore e decadenza ambientata negli anni '20 in America.'),
('To Kill a Mockingbird', 'Harper Lee', '9780061120084', 1960, 'Romanzo', 4, 'Un potente romanzo che affronta temi di razzismo e ingiustizia nell'America del Sud.'),
('L'insostenibile leggerezza dell'essere', 'Milan Kundera', '97805
