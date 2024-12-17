# loginCrud
## TPS php project
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
