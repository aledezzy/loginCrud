-- SQLBook: Code
CREATE TABLE
    utenti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50),
        cognome VARCHAR(50),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(255),
        ruolo ENUM ('user', 'admin') NOT NULL DEFAULT 'user',
        data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    libri (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titolo VARCHAR(255) NOT NULL,
        autore VARCHAR(255) NOT NULL,
        isbn VARCHAR(13) UNIQUE,
        anno_pubblicazione INT (4),
        genere VARCHAR(100),
        quantita INT DEFAULT 0,
        descrizione TEXT,
        data_inserimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

INSERT INTO
    libri (
        titolo,
        autore,
        isbn,
        anno_pubblicazione,
        genere,
        quantita,
        descrizione
    )
VALUES
    (
        'Cent\'anni di solitudine',
        'Gabriel García Márquez',
        '9788845292613',
        1967,
        'Romanzo',
        5,
        'Un
capolavoro della letteratura latinoamericana, che racconta la storia della famiglia Buendía nella
città immaginaria di Macondo.'
    ),
    (
        '1984',
        'George Orwell',
        '9780451524935',
        1949,
        'Distopia',
        3,
        'Un romanzo distopico che esplora
le conseguenze di un governo totalitario e onnipresente.'
    ),
    (
        'Il Signore degli Anelli',
        'J.R.R. Tolkien',
        '9780261102385',
        1954,
        'Fantasy',
        7,
        'Un epico racconto di
avventura ambientato nella Terra di Mezzo.'
    ),
    (
        'Il Grande Gatsby',
        'F. Scott Fitzgerald',
        '9780743273565',
        1925,
        'Romanzo',
        6,
        'Una storia di amore
e decadenza ambientata negli anni \'20 in America.'
    ),
    (
        'To Kill a Mockingbird',
        'Harper Lee',
        '9780061120084',
        1960,
        'Romanzo',
        4,
        'Un potente romanzo
che affronta temi di razzismo e ingiustizia nell\'America del Sud.'
    ),
    (
        'L\'insostenibile leggerezza dell\'essere',
        'Milan Kundera',
        '9780571135394',
        1984,
        'Romanzo',
        5,
        'Un romanzo filosofico che esplora la vita di quattro persone durante l\'invasione sovietica della
Cecoslovacchia.'
    ),
    (
        'Il Codice Da Vinci',
        'Dan Brown',
        '9780307474278',
        2003,
        'Thriller',
        8,
        'Un thriller che mescola
storia, arte e codici segreti.'
    ),
    (
        'Il Piccolo Principe',
        'Antoine de Saint-Exupéry',
        '9780156012195',
        1943,
        'Fiaba',
        7,
        'Una fiaba
filosofica e una critica sociale raccontata attraverso gli occhi di un bambino.'
    ),
    (
        'Moby Dick',
        'Herman Melville',
        '9780142437247',
        1951,
        'Romanzo',
        3,
        'La famosa storia della
caccia alla balena bianca da parte del capitano Ahab.'
    ),
    (
        'Il processo',
        'Franz Kafka',
        '9780805209990',
        1925,
        'Romanzo',
        4,
        'Un romanzo che esplora temi di
alienazione e persecuzione attraverso il processo giudiziario di un bancario.'
    ),
    (
        'Cento anni di solitudine',
        'Gabriel García Márquez',
        '9785845392613',
        1967,
        'Romanzo',
        5,
        'Un
capolavoro della letteratura latinoamericana, che racconta la storia della famiglia Buendía nella
città immaginaria di Macondo.'
    ),
    (
        'Anna Karenina',
        'Lev Tolstoj',
        '9780679783305',
        1941,
        'Romanzo',
        4,
        'Un intenso romanzo che
esplora temi di amore, famiglia e politica nella Russia del XIX secolo.'
    ),
    (
        'Il giro del mondo in 80 giorni',
        'Jules Verne',
        '9788853008083',
        1873,
        'Avventura',
        6,
        'La storia di
un viaggio incredibile che sfida i limiti del possibile nell\'epoca vittoriana.'
    );