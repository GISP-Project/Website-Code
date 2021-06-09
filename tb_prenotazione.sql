CREATE TABLE tb_prenotazione (
	idPrenotazione VARCHAR(100) PRIMARY KEY,
	emailUtente VARCHAR(100) NOT NULL,
	idAmbiente VARCHAR(100) NOT NULL,
	RagSocAmbiente VARCHAR(100) NOT NULL,
	dataoraPrenotazione VARCHAR(20) NOT NULL,
	statoPrenotazione VARCHAR(20) NOT NULL
)

