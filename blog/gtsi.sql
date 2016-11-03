-- Suppression de la base de donnees "blog" (si elle existe)
DROP DATABASE IF EXISTS blog;

-- Creation de la base de donnees "blog"
CREATE DATABASE blog ENCODING 'UTF8' LC_COLLATE = 'fr_FR.UTF-8' LC_CTYPE = 'fr_FR.UTF-8';

-- Connexion a la base de donnees "blog"
\c blog postgres

-- Revocation de tous les privileges sur les tables
REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA PUBLIC FROM PUBLIC;

-- Revocation de tous les privileges sur les fonctions
REVOKE ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA PUBLIC FROM PUBLIC;

-- Creation des utilisateurs
CREATE ROLE gtsiadmin NOSUPERUSER NOCREATEDB NOCREATEROLE NOINHERIT NOREPLICATION NOLOGIN;
CREATE ROLE gtsi NOSUPERUSER NOCREATEDB NOCREATEROLE NOINHERIT NOREPLICATION LOGIN ENCRYPTED PASSWORD 'gtsi*';

-- Suppression de la bdd et des sequences
DROP SEQUENCE IF EXISTS categorie_id_seq;
DROP SEQUENCE IF EXISTS article_id_seq;
DROP SEQUENCE IF EXISTS user_id_seq;

-- Creation des tables (article et categorie)
CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1;

CREATE TABLE categorie (id INT NOT NULL DEFAULT nextval('categorie_id_seq'),
                        titre VARCHAR(255) NOT NULL,
                        description TEXT NOT NULL,
                        slug VARCHAR(255) NOT NULL,
                        PRIMARY KEY(id));
CREATE TABLE article (id INT NOT NULL DEFAULT nextval('article_id_seq'),
                      rubrique_id INT NOT NULL,
                      user_id INT NOT NULL,
                      titre VARCHAR(255) NOT NULL,
                      contenu TEXT NOT NULL,
                      cdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                      udate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                      slug VARCHAR(255) NOT NULL,
                      image VARCHAR(25) NOT NULL,
                      PRIMARY KEY(id));
CREATE TABLE comment (id INT NOT NULL DEFAULT nextval('comment_id_seq'),
                      article_id INT NOT NULL,
                      user_id INT NOT NULL,
                      contenu TEXT NOT NULL,
                      cdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                      udate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                      PRIMARY KEY(id));
CREATE TABLE "user" (id INT NOT NULL DEFAULT nextval('user_id_seq'),
                     username VARCHAR(255) NOT NULL,
                     password VARCHAR(255) NOT NULL,
                     email VARCHAR(255) NOT NULL,
                     rdate TIMESTAMP(0) WITHOUT TIME ZONE default current_timestamp,
                     is_admin BOOLEAN DEFAULT FALSE,
                     activated BOOLEAN DEFAULT FALSE,
                     PRIMARY KEY(id));

CREATE TABLE activation_token (user_id INT NOT NULL,
                               token VARCHAR(255) NOT NULL,
                               expire TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL);


-- Creation des INDEX et FOREIGN KEY
CREATE INDEX article_rubrique_index ON article (rubrique_id);
ALTER TABLE article ADD CONSTRAINT fk_rubrique_id FOREIGN KEY (rubrique_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE INDEX article_user_index ON article (user_id);
ALTER TABLE article ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE INDEX comment_user_index ON comment (user_id);
ALTER TABLE comment ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
-- CREATE INDEX activation_token_user_index ON activation_token (user_id);
-- ALTER TABLE activation_token ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE;

-- Insertion dans la table user

INSERT INTO "user" (username, password, email, is_admin, activated) VALUES
    ('admin', 'admin*',
     'admin@mywebapp.stage-gtsi.fr', TRUE, TRUE),
    ('jdujardin', 'jdujardin*',
     'jdujardin@mywebapp.stage-gtsi.fr', FALSE, TRUE);

-- Insertion dans la table categorie
INSERT INTO categorie (titre, description, slug) VALUES
    ('Actualités', 'Actu IT', 'actualites'),
    ('Tutoriels', 'La liste de tous mes tutos', 'tutoriels'),
    ('Outils', 'Les outils que je développe', 'outils');

-- Insertion dans la table article
INSERT INTO article (rubrique_id, user_id, titre, contenu, cdate, udate, slug, image) VALUES
    (1, 1, 'Article 1', 'Lorem ipsum...', '2014-01-01 12:30:00', '2014-09-01 12:30:00', 'article-1', 'nIzjMu2lOdvANM0CMTkM.jpg'),
    (2, 2, 'Article 2', 'Lorem ipsum...', '2014-01-17 14:41:00', '2014-01-17 14:41:00', 'article-2', 'sAUvWg189qOPhewm1NTo.jpg'),
    (3, 1, 'Article 3', 'Lorem ipsum...', '2014-02-02 17:30:00', '2014-02-02 17:30:00', 'article-3', 'mmftBjgjN4muGhn9dZas.jpg'),
    (2, 2, 'Article 4', 'Lorem ipsum...', '2014-02-23 11:12:00', '2014-02-23 11:12:00', 'article-4', 'RNYmB7x23zaDHyNUJol1.jpg'),
    (1, 1, 'Article 5', 'Lorem ipsum...', '2014-02-27 10:33:00', '2014-02-27 10:33:00', 'article-5', 'zg8eLm8YYKJciUvBQpH6.jpg');

GRANT CONNECT ON DATABASE blog TO gtsi;
GRANT SELECT, INSERT, UPDATE, DELETE ON categorie, article, comment, "user", activation_token TO gtsi;
GRANT UPDATE ON categorie_id_seq, article_id_seq, comment_id_seq, user_id_seq TO gtsi;

