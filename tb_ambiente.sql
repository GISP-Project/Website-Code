CREATE TABLE tb_Ambiente (
	ID INT NOT NULL AUTO_INCREMENT,
	RagioneSociale VARCHAR(50),
	Indirizzo VARCHAR(50),
	Città VARCHAR(50),
	Provincia VARCHAR(50),
	CAP VARCHAR(50),
	GoogleMap VARCHAR(1000),
	TipoAmbiente VARCHAR(50),
	TipoAmbiente INT(10),
	LimMaxPresenze INT(10),
    PRIMARY KEY (ID)
)



INSERT INTO tb_Ambiente (RagioneSociale, Indirizzo, Città, Provincia, CAP, GoogleMap, TipoAmbiente)
VALUES ('Shopville Le Gru', 'Via Crea, 10', 'Grugliasco', 'TO', '10095', '', 'Centro Commerciale');

INSERT INTO tb_Ambiente (RagioneSociale, Indirizzo, Città, Provincia, CAP, GoogleMap, TipoAmbiente)
VALUES ('Le Fornaci Mega Shopping', 'Str. Torino, 34/36', 'Beinasco', 'TO', '10092', '', 'Centro Commerciale');

INSERT INTO tb_Ambiente (RagioneSociale, Indirizzo, Città, Provincia, CAP, GoogleMap, TipoAmbiente)
VALUES ('Le Fornaci Mega Shopping', 'Str. Torino, 34/36', 'Beinasco', 'TO', '10092', '', 'Centro Commerciale');

INSERT INTO tb_Ambiente (RagioneSociale, Indirizzo, Città, Provincia, CAP, GoogleMap, TipoAmbiente)
VALUES ('Comune di Orbassano', 'Piazza Umberto, 5', 'Orbassano', 'TO', '10043', '', 'Ufficio');


ALTER TABLE tb_ambiente ADD COLUMN PresenzeRealTime INT(10)
ALTER TABLE tb_ambiente ADD COLUMN LimMaxPresenze INT(10)