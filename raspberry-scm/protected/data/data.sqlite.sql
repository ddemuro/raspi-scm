/*
Navicat SQLite Data Transfer

Source Server         : data
Source Server Version : 30623
Source Host           : localhost:0

Target Server Type    : SQLite
Target Server Version : 30623
File Encoding         : 65001

Date: 2016-12-12 20:39:14
*/

PRAGMA foreign_keys = OFF;

-- ----------------------------
-- Table structure for "main"."external_temperature"
-- ----------------------------
DROP TABLE "main"."external_temperature";
CREATE TABLE external_temperature (
    date DATETIME NOT NULL PRIMARY KEY,
    humidity DOUBLE NOT NULL,
    temperature DOUBLE NOT NULL,
    log TEXT NOT NULL
);

-- ----------------------------
-- Records of external_temperature
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."flags"
-- ----------------------------
DROP TABLE "main"."flags";
CREATE TABLE "flags" (
"flag_name"  TEXT,
"date"  DATETIME,
"status"  TEXT,
PRIMARY KEY ("flag_name" ASC),
CONSTRAINT "unidate" UNIQUE ("date")
);

-- ----------------------------
-- Records of flags
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."infrared_events"
-- ----------------------------
DROP TABLE "main"."infrared_events";
CREATE TABLE infrared_events (
    date DATETIME NOT NULL PRIMARY KEY,
    device VARCHAR(255) NOT NULL,
    event VARCHAR(255) NOT NULL,
    extended TEXT NOT NULL
);

-- ----------------------------
-- Records of infrared_events
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."internal_temperature"
-- ----------------------------
DROP TABLE "main"."internal_temperature";
CREATE TABLE internal_temperature (
    "date" DATETIME NOT NULL PRIMARY KEY,
    "temperature" VARCHAR(255) NOT NULL
, "type" TEXT  NOT NULL  DEFAULT ('CPU'));

-- ----------------------------
-- Records of internal_temperature
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."logger"
-- ----------------------------
DROP TABLE "main"."logger";
CREATE TABLE logger (
    date DATETIME NOT NULL PRIMARY KEY,
    log TEXT NOT NULL
);

-- ----------------------------
-- Records of logger
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."relay_changes"
-- ----------------------------
DROP TABLE "main"."relay_changes";
CREATE TABLE relay_changes (
    date DATETIME NOT NULL PRIMARY KEY,
    relay_number INTEGER NOT NULL,
    action INTEGER NOT NULL,
    log TEXT NOT NULL
);

-- ----------------------------
-- Records of relay_changes
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."setting"
-- ----------------------------
DROP TABLE "main"."setting";
CREATE TABLE "setting" (
"id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"setting_id"  VARCHAR(255) NOT NULL,
"setting"  VARCHAR(255) NOT NULL,
"extended"  TEXT(255),
"comment"  TEXT,
CONSTRAINT "uniq" UNIQUE ("id") ON CONFLICT REPLACE
);

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO ""."setting" VALUES ('1', 'external_temp_sensor_pin', '7', '-V11', 'To allow multiple sensors.');
INSERT INTO ""."setting" VALUES ('2', 'relay_1', 'Server', 'MVD02', 'Relay 1 identificaiton');
INSERT INTO ""."setting" VALUES ('3', 'relay_2', 'Router', 'ROUTER', 'Relay 2 identification');
INSERT INTO ""."setting" VALUES ('4', 'relay_3', 'Server', 'MVD01', 'Relay 3 identification');
INSERT INTO ""."setting" VALUES ('5', 'ir_util_name', 'ac', 'AirConditioner', 'Air Conditioner Controller');
INSERT INTO ""."setting" VALUES ('6', 'ups', 'forza-850', '127.0.0.1', 'UPS Forza Information');

-- ----------------------------
-- Table structure for "main"."sqlite_sequence"
-- ----------------------------
DROP TABLE "main"."sqlite_sequence";
CREATE TABLE sqlite_sequence(name,seq);

-- ----------------------------
-- Records of sqlite_sequence
-- ----------------------------
INSERT INTO ""."sqlite_sequence" VALUES ('user', '1');
INSERT INTO ""."sqlite_sequence" VALUES ('setting', '6');

-- ----------------------------
-- Table structure for "main"."ups"
-- ----------------------------
DROP TABLE "main"."ups";
CREATE TABLE "ups" (
"ups_details"  TEXT,
"date"  DATETIME NOT NULL,
"setting"  TEXT,
PRIMARY KEY ("date" ASC),
CONSTRAINT "uni_date" UNIQUE ("date" ASC)
);

-- ----------------------------
-- Records of ups
-- ----------------------------

-- ----------------------------
-- Table structure for "main"."user"
-- ----------------------------
DROP TABLE "main"."user";
CREATE TABLE "user" (
"id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"email"  VARCHAR(128) NOT NULL,
"role"  VARCHAR(128) NOT NULL,
"password"  VARCHAR(128) NOT NULL,
"ipaddress"  VARCHAR(16)
);

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO ""."user" VALUES ('1', 'admin@admin.com', 'admin', '6c622944c0b919f5628f80d1306b4a7a3c9262a7', null);
