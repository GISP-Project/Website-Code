CREATE TABLE tb_catalogo_premi (
    ID INT NOT NULL AUTO_INCREMENT,
    CodicePremio VARCHAR(50),
    DescrizionePremio VARCHAR(1000),
    PuntiRichiesti INT(10),
    PRIMARY KEY (ID)
)