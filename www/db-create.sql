-- USER TABLE
CREATE TABLE IF NOT EXISTS User (
	username				CHAR(40) PRIMARY KEY,
	password				CHAR(40) NOT NULL,
	email					CHAR(40) UNIQUE NOT NULL,
	profile_pic				TEXT,
	bio						TEXT,
	birthdate				DATE NOT NULL,
	join_date				DATE NOT NULL, -- automatically populated
	profile_last_updated	DATE,
	favorite_character		CHAR(40)
);