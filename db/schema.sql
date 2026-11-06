-- MiddleMinds database. Import with:  mysql -u root < db/schema.sql
CREATE DATABASE IF NOT EXISTS middleminds CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE middleminds;

CREATE TABLE IF NOT EXISTS UserScores (
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(60)  NOT NULL UNIQUE,
    score      INT          NOT NULL DEFAULT 0,
    updated_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ParentSurvey (
    id                        INT AUTO_INCREMENT PRIMARY KEY,
    ParentName                VARCHAR(100) NOT NULL,
    ParentEmail               VARCHAR(255) NOT NULL,
    MiddleSchoolChildrenCount INT          NOT NULL,
    BiggestChallenges1        VARCHAR(100) NOT NULL,
    BiggestChallenges2        VARCHAR(100),
    BiggestChallenges3        VARCHAR(100),
    InvolvementLevel          VARCHAR(40)  NOT NULL,
    Suggestions               TEXT,
    submitted_at              TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);
