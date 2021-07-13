[03/07 11:06] CORVAGLIA MARCO
    CREATE TABLE tb_ambiente (
    ID INT NOT NULL AUTO_INCREMENT,
    RagioneSociale VARCHAR(50),
    Indirizzo VARCHAR(50),
    Città VARCHAR(50),
    Provincia VARCHAR(50),
    CAP VARCHAR(50),
    GoogleMap VARCHAR(1000),
    TipoAmbiente VARCHAR(50),
    PresenzeRealTime INT(10),
    LimMaxPresenze INT(10),
    emailEnte VARCHAR(100),
    url_thingspeak VARCHAR(1000),
    iframe_thingspeak VARCHAR(1000),
    prenotazione VARCHAR(10),
    PRIMARY KEY (ID)
)
