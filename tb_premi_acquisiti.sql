CREATE TABLE tb_premi_acquisiti (
	ID INT NOT NULL AUTO_INCREMENT,
	CodicePremio VARCHAR(50),
	emailUtente VARCHAR(50),
	CodiceVoucher VARCHAR(50),
	StatoVoucher VARCHAR(50),
	IdAmbiente INT(10),
    PRIMARY KEY (ID)
)
