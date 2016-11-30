-- USERS TABLE
CREATE TABLE IF NOT EXISTS Users (
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

-- FORUM_CATEGORIES TABLE
CREATE TABLE IF NOT EXISTS Forum_Categories (
	name					CHAR(40) PRIMARY KEY
);

-- FORUM_THREADS TABLE
CREATE TABLE IF NOT EXISTS Forum_Threads (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	category_name			CHAR(40) NOT NULL, -- foreign key
	title					CHAR(100) NOT NULL,
	user_created_by			CHAR(40) NOT NULL, -- foreign key
	created_datetime		DATETIME NOT NULL, -- automatically populated

	FOREIGN KEY(category_name) REFERENCES Forum_Categories(name),
	FOREIGN KEY(user_created_by) REFERENCES Users(username)
);

-- FORUM_POSTS TABLE
CREATE TABLE IF NOT EXISTS Forum_Posts (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	thread_id				INT NOT NULL, -- foreign key
	content					TEXT NOT NULL,
	user_post_by			CHAR(40) NOT NULL, -- foreign key
	created_datetime		DATETIME NOT NULL, -- automatically populated

	FOREIGN KEY(thread_id) REFERENCES Forum_Threads(id),
	FOREIGN KEY(user_post_by) REFERENCES Users(username)
);

-- WIKI_CATEGORIES TABLE
CREATE TABLE IF NOT EXISTS Wiki_Categories (
	name					CHAR(40) PRIMARY KEY
);

-- WIKI_PAGES TABLE
CREATE TABLE IF NOT EXISTS Wiki_Pages (
	title					CHAR(40) PRIMARY KEY,
	category_name			CHAR(40) NOT NULL, -- foreign key
	content					TEXT NOT NULL,
	user_last_edited_by		CHAR(40) NOT NULL, -- foreign key
	last_edited_datetime	DATETIME NOT NULL, -- automatically populated

	FOREIGN KEY(category_name) REFERENCES Wiki_Categories(name),
	FOREIGN KEY(user_last_edited_by) REFERENCES Users(username)
);