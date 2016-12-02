CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE logger (
    date DATETIME NOT NULL PRIMARY KEY,
    log TEXT NOT NULL
);
;
CREATE TABLE relay_changes (
    date DATETIME NOT NULL PRIMARY KEY,
    relay_number INTEGER NOT NULL,
    action INTEGER NOT NULL,
    log TEXT NOT NULL
);
;
CREATE TABLE external_temperature (
    date DATETIME NOT NULL PRIMARY KEY,
    humidity DOUBLE NOT NULL,
    temperature DOUBLE NOT NULL,
    log TEXT NOT NULL
);
;
CREATE TABLE infrared_events (
    date DATETIME NOT NULL PRIMARY KEY,
    device VARCHAR(255) NOT NULL,
    event VARCHAR(255) NOT NULL,
    extended TEXT NOT NULL
);
;
CREATE TABLE ups (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    location TEXT NOT NULL,
    name TEXT NOT NULL,
    setting TEXT NULL
);
CREATE TABLE ups_status (
    id NOT NULL,
    date DATETIME NOT NULL,
    status TEXT NOT NULL,
    change TEXT NOT NULL,
    CONSTRAINT `FK_upsstatus_ups` FOREIGN KEY (`id`) REFERENCES `ups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE TABLE "user" (
"id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"email"  VARCHAR(128) NOT NULL,
"role"  VARCHAR(128) NOT NULL,
"password"  VARCHAR(128) NOT NULL,
"ipaddress"  VARCHAR(16)
);
CREATE TABLE "setting" (
"id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"setting_id"  VARCHAR(255) NOT NULL,
"setting"  VARCHAR(255) NOT NULL,
"extended"  TEXT(255),
"comment"  TEXT
);
CREATE TABLE "flags" (
"flag_name"  TEXT,
"date"  DATETIME,
"status"  TEXT
);
CREATE TABLE internal_temperature (
    "date" DATETIME NOT NULL PRIMARY KEY,
    "temperature" VARCHAR(255) NOT NULL
, "type" TEXT  NOT NULL  DEFAULT ('CPU'));
;
