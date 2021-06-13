CREATE TABLE tb_catalogo_premi (
	ID INT NOT NULL AUTO_INCREMENT,
	CodicePremio VARCHAR(50),
	DescrizionePremio VARCHAR(1000),
	PuntiRichiesti INT(10),
    PRIMARY KEY (ID)
)


INSERT INTO tb_catalogo_premi (CodicePremio, DescrizionePremio, PuntiRichiesti)
VALUES ('VOUCHER1000P10', 'Voucher per richiedere uno sconto del 10% da utilizzare in qualsiasi ente associato.', 1000);

INSERT INTO tb_catalogo_premi (CodicePremio, DescrizionePremio, PuntiRichiesti)
VALUES ('VOUCHER2000P20', 'Voucher per richiedere uno sconto del 20% da utilizzare in qualsiasi ente associato.', 2000);

INSERT INTO tb_catalogo_premi (CodicePremio, DescrizionePremio, PuntiRichiesti)
VALUES ('VOUCHER3000P30', 'Voucher per richiedere uno sconto del 30% da utilizzare in qualsiasi ente associato.', 3000);

