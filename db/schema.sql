-- Bibletool schema

DROP TABLE IF EXISTS verses;
DROP TABLE IF EXISTS titles;
DROP TABLE IF EXISTS languages;

CREATE TABLE languages (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	name        VARCHAR(10) UNIQUE NOT NULL,
	description VARCHAR(100) NOT NULL,
	PRIMARY KEY(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE titles (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	language_id INTEGER NOT NULL,
	book        INTEGER NOT NULL,
	chapter     INTEGER NOT NULL,
	title       VARCHAR(20) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(language_id) REFERENCES languages(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE verses (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	language_id INTEGER NOT NULL,
	book        INTEGER NOT NULL,
	chapter     INTEGER NOT NULL,
	verse       INTEGER NOT NULL,
	body        VARCHAR(700) NOT NULL,
	PRIMARY KEY(id),
	UNIQUE(language_id, book, chapter, verse),
	FOREIGN KEY(language_id) REFERENCES languages(id)
) ENGINE=InnoDb CHARACTER SET=utf8;
