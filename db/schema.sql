-- Bibletool schema

DROP TABLE IF EXISTS cache_versions;
DROP TABLE IF EXISTS subject_verses;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS glossary_verses;
DROP TABLE IF EXISTS glossary_notes;
DROP TABLE IF EXISTS glossary;
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
	subtitle    VARCHAR(80),
	body        VARCHAR(700) NOT NULL,
	PRIMARY KEY(id),
	UNIQUE(language_id, book, chapter, verse),
	KEY(book, chapter, verse),
	FOREIGN KEY(language_id) REFERENCES languages(id),
	FOREIGN KEY(language_id, book) REFERENCES books(language_id, book)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE glossary (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	strokes     INTEGER NOT NULL,
	letter      CHAR(1),
	chinese     VARCHAR(80),
	english     VARCHAR(80),
	definition  VARCHAR(700),
	PRIMARY KEY(id),
	KEY(strokes),
	KEY(letter)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE glossary_notes (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	glossary_id INTEGER NOT NULL,
	notes       VARCHAR(700) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(glossary_id) REFERENCES glossary(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE glossary_verses (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	glossary_id INTEGER NOT NULL,
	book        INTEGER NOT NULL,
	chapter     INTEGER NOT NULL,
	start_verse INTEGER NOT NULL,
	end_verse   INTEGER NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(glossary_id) REFERENCES glossary(id),
	FOREIGN KEY(book, chapter) REFERENCES verses(book, chapter)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE subjects (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	parent_id   INTEGER,
	name        VARCHAR(40) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(parent_id) REFERENCES subjects(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE subject_verses (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	subject_id  INTEGER NOT NULL,
	book        INTEGER NOT NULL,
	chapter     INTEGER NOT NULL,
	start_verse INTEGER NOT NULL,
	end_verse   INTEGER NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(subject_id) REFERENCES subjects(id)
) ENGINE=InnoDb CHARACTER SET=utf8;

CREATE TABLE cache_versions (
	id          INTEGER AUTO_INCREMENT NOT NULL,
	entity      VARCHAR(50) NOT NULL,
	ts          INTEGER NOT NULL,
	PRIMARY KEY(id),
	UNIQUE(entity)
) ENGINE=InnoDb CHARACTER SET=utf8;

