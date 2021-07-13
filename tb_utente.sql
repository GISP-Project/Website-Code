CREATE TABLE tb_utente (
    email VARCHAR(100) PRIMARY KEY,
    pwd VARCHAR(25) NOT NULL,
    preferiti VARCHAR(100),
    ruolo VARCHAR(25),
    punti INT(10)
)