-- Bibletool schema

DROP TABLE IF EXISTS verses;
DROP TABLE IF EXISTS chapters;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS languages;

CREATE TABLE languages (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	name        VARCHAR(10) UNIQUE NOT NULL,
	description VARCHAR(100) NOT NULL,
	PRIMARY KEY(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE books (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	language_id INTEGER NOT NULL,
	book        INTEGER NOT NULL,
	short_name  VARCHAR(30) NOT NULL,
	long_name   VARCHAR(30) NOT NULL,
	PRIMARY KEY(id),
	UNIQUE(language_id, book),
	FOREIGN KEY(language_id) REFERENCES languages(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE chapters (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	language_id INTEGER NOT NULL,
	book        INTEGER NOT NULL,
	chapter     INTEGER NOT NULL,
	title       VARCHAR(20) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(language_id) REFERENCES languages(id),
	KEY(language_id, book, chapter)
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
	FOREIGN KEY(language_id) REFERENCES languages(id),
	FOREIGN KEY(language_id, book) REFERENCES books(language_id, book)
) ENGINE=InnoDb CHARACTER SET=utf8;
