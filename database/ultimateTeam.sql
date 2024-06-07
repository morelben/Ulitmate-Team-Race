create database ultimate_team_race;
\c ultimate_team_race;

CREATE SEQUENCE seq_admin
    INCREMENT BY 1
    START WITH 1;

create table admin(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'ADMIM' || LPAD(nextval('seq_admin')::TEXT, 3, '0'),
    nomAdmin VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);

CREATE SEQUENCE seq_equipe
    INCREMENT BY 1
    START WITH 1;

create table equipes(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'EQU' || LPAD(nextval('seq_equipe')::TEXT, 3, '0'),
    nomEquipe VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);

CREATE SEQUENCE seq_coureur
    INCREMENT BY 1
    START WITH 1;

create table coureurs(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'COUR' || LPAD(nextval('seq_coureur')::TEXT, 3, '0'),
    nomCoureur VARCHAR(100),
    numero_dossard int UNIQUE,
    genre VARCHAR(100),
    date_naissance date,
    idEquipe VARCHAR(100),
    FOREIGN KEY (idEquipe) REFERENCES equipes(id)
);

CREATE SEQUENCE seq_categ_cour
    INCREMENT BY 1
    START WITH 1;

create table categorie_coureur(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'CATCOU' || LPAD(nextval('seq_categ_cour')::TEXT, 3, '0'),
    categorie VARCHAR(100),
    idCoureur VARCHAR(100),
    FOREIGN KEY (idCoureur) REFERENCES coureurs(id)
);

-- view categorie_coureur
create view view_categorie_coureur as
select
    cc.id as id_categorie_coureur,
    categorie,
    idCoureur,
    c.nomCoureur as nom_coureur,
    c.date_naissance as date_naissance,
    c.idEquipe as equipe_id,
    e.nomEquipe as nom_equipe
from
    categorie_coureur cc
join
    coureurs c on c.id = cc.idCoureur
join
    equipes e on c.idEquipe = e.id;

CREATE SEQUENCE seq_etape
    INCREMENT BY 1
    START WITH 1;

create table etapes(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'ET' || LPAD(nextval('seq_categ_cour')::TEXT, 3, '0'),
    nomEtape VARCHAR(100),
    longueur DOUBLE PRECISION,
    nbrCoureur INT,
    rang INT,
    date_depart timestamp
);

CREATE SEQUENCE seq_etape_coureur
    INCREMENT BY 1
    START WITH 1;

create table etape_coureur(
  id VARCHAR(100) PRIMARY KEY DEFAULT 'ETCOU' || LPAD(nextval('seq_etape_coureur')::TEXT, 3, '0'),
  idEtape VARCHAR(100),
  idCoureur VARCHAR(100),
  FOREIGN KEY (idEtape) REFERENCES etapes(id),
  FOREIGN KEY (idCoureur) REFERENCES coureurs(id)
);

create view view_etape_coureur as
select
    ec.id as idEtapeCoureur,
    ec.idEtape as idEtape,
    e.nometape as nomEtape,
    ec.idCoureur as idCoureur,
    c.nomcoureur as nomCoureur,
    eq.nomequipe as nomEquipe
from
    etape_coureur ec
join
    etapes e on ec.idEtape = e.id
join
    coureurs c on ec.idCoureur = c.id
join
    equipes eq on c.idEquipe = eq.id;

CREATE SEQUENCE seq_penalite
    INCREMENT BY 1
    START WITH 1;

create table equipe_penalite(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'EQP' || LPAD(nextval('seq_penalite')::TEXT, 3, '0'),
    idEtape VARCHAR(100),
    idEquipe VARCHAR(100),
    temp_penalite TIME,
    etat INT,
    FOREIGN KEY (idEtape) REFERENCES etapes(id),
    FOREIGN KEY (idEquipe) REFERENCES equipes(id)
);

insert into equipe_penalite (idEtape, idEquipe, temp_penalite, etat) values ('ET051','EQU015','00:55:45',0);

-- view equipe penalite
create or replace view view_equipe_penalite as
select
         ep.id,
         idEtape as etape_id,
         e.nomEtape as nom_etape,
         idEquipe as equipe_id,
         eq.nomEquipe as nom_equipe,
         ep.temp_penalite,
         ep.etat
from
     equipe_penalite ep
join
     etapes e on e.id = ep.idEtape
join
 equipes eq on eq.id = ep.idEquipe;

-- somme penalite
create or replace view view_somme_penalite as
select
    equipe_id,
    etape_id,
    sum(temp_penalite) as temps_penalite
from
    view_equipe_penalite
group by
    etape_id,equipe_id;



CREATE SEQUENCE seq_param_point
    INCREMENT BY 1
    START WITH 1;

create table parametre_point(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'POET' || LPAD(nextval('seq_param_point')::TEXT, 3, '0'),
    rang INT,
    point_atribuer INT
);

CREATE SEQUENCE seq_tce
    INCREMENT BY 1
    START WITH 1;

create table temps_coureur_etape(
    id VARCHAR(100) PRIMARY KEY DEFAULT 'TCE' || LPAD(nextval('seq_tce')::TEXT, 3, '0'),
    idEtape VARCHAR(100),
    idCoureur VARCHAR(100),
    heure_depart TIMESTAMP,
    heure_arriver TIMESTAMP,
    FOREIGN KEY (idEtape) REFERENCES etapes(id),
    FOREIGN KEY (idCoureur) REFERENCES  coureurs(id)
);

create or replace view view_temp_coureur_etape as
select
    tce.id,
    idEtape as etape_id,
    e.nomEtape as etape_nom,
    idCoureur as coureur_id,
    c.idEquipe as equipe_id,
    eq.nomEquipe as nom_equipe,
    heure_depart,
    heure_arriver
from
    temps_coureur_etape tce
join
    coureurs c on tce.idCoureur = c.id
join
    equipes eq on eq.id = c.idEquipe
join
    etapes e on e.id = tce.idEtape;


create or replace view view_temps_coureur as
select
    tce.id as id_temps_coureur_etape,
    tce.etape_id as etape_id,
    e.nometape as nom_etape,
    e.rang as rang_etape,
    e.longueur as longueur_etape,
    e.nbrcoureur as nbr_coureur,
    tce.coureur_id as coureur_id,
    c.nomcoureur as nom_coureur,
    c.numero_dossard as numero_dossard,
    c.genre as genre,
    c.idequipe as equipe_id,
    eq.nomequipe as nomEquipe,
    tce.heure_depart as temp_depart,
    tce.heure_arriver as temp_arriver,
    coalesce(ep.temps_penalite,'00:00:00') as temps_penalite
from
    coureurs c
left join
    view_temp_coureur_etape tce on c.id = tce.coureur_id
left join
    etapes e on e.id = tce.etape_id
left join
    view_somme_penalite ep on ep.etape_id = tce.etape_id and ep.equipe_id = tce.equipe_id
join
    equipes eq on eq.id = c.idEquipe;


create table point_coureur_etape(
    idEtape VARCHAR(100),
    idCoureur VARCHAR(100),
    point int,
    FOREIGN KEY (idEtape) REFERENCES etapes(id),
    FOREIGN KEY (idCoureur) REFERENCES  coureurs(id)
);

-- view rang
CREATE or replace VIEW view_coureur_rank AS
SELECT
    v.id_temps_coureur_etape AS id,
    v.etape_id,
    v.nom_etape,
    v.longueur_etape,
    v.nbr_coureur,
    v.rang_etape,
    v.coureur_id,
    v.nom_coureur,
    c.categorie,
    v.numero_dossard,
    v.genre,
    v.equipe_id,
    v.nomEquipe,
    v.temp_depart AS temp_depart,
    v.temp_arriver AS temp_arrive,
    v.temps_penalite,
    EXTRACT(EPOCH FROM ((v.temp_arriver - v.temp_depart)+v.temps_penalite )) / 60 AS temps_effectue,
    TO_CHAR(((v.temp_arriver - v.temp_depart )), 'HH24:MI:SS') AS temps_passe,
    TO_CHAR(((v.temp_arriver + v.temps_penalite)), 'HH24:MI:SS') AS temps_finale,
    DENSE_RANK() OVER (PARTITION BY v.etape_id ORDER BY EXTRACT(EPOCH FROM ((v.temp_arriver - v.temp_depart)+v.temps_penalite)) / 60 ASC) AS rang

FROM
    view_temps_coureur v
JOIN
    categorie_coureur c on c.idCoureur = v.coureur_id
ORDER BY
    etape_id,
    rang ASC;


-- view rang avec point
create or replace view view_coureur_rank_point as
select
    v.id,
    v.etape_id,
    v.nom_etape,
    v.longueur_etape,
    v.nbr_coureur,
    v.rang_etape,
    v.coureur_id,
    v.nom_coureur,
    c.categorie,
    v.numero_dossard,
    v.genre,
    v.equipe_id,
    v.nomEquipe,
    v.temp_depart,
    v.temps_penalite,
    v.temp_arrive,
    v.temps_effectue,
    v.temps_passe,
    v.temps_finale,
    v.rang,
    coalesce(p.point_atribuer,0) as point_obtenu
FROM
    view_coureur_rank v
JOIN
    categorie_coureur c on c.idCoureur = v.coureur_id
LEFT JOIN
    parametre_point p on p.rang = v.rang
ORDER BY
    v.rang;

SELECT pp.etape_id,pp.nom_etape ,sum(point_2) point_etape FROM
    (SELECT
         v.*,
         DENSE_RANK() OVER (ORDER BY v.temps_effectue  ASC) AS place_2,
         COALESCE(p.point_atribuer, 0) AS point_2
     FROM
         (SELECT
              *,
              DENSE_RANK() OVER (PARTITION BY etape_id  ORDER BY temps_effectue ASC) AS place_2
          FROM
              view_coureur_rank_point vr
                  JOIN categorie_coureur cc on cc.idCoureur = vr.coureur_id
         ) v
             LEFT JOIN
         parametre_point p
         ON
         v.place_2 = p.rang where equipe_id = 'EQU070' ) pp  group by pp.etape_id,pp.nom_etape ;


-- classement equipe
create or replace view view_team_rank as
select
    equipe_id,
    nomEquipe,
    SUM(temps_effectue) as total_temps_effectue,
    SUM(temps_passe::interval) as total_temps_passe,
    SUM(point_obtenu) as total_point_obtenu,
    DENSE_RANK() OVER (ORDER BY SUM(point_obtenu) DESC) AS rang_equipe
from
    view_coureur_rank_point
group by
    equipe_id,
    nomEquipe;

-- classement general team by genre
WITH equipe_points AS (
    SELECT
        equipe_id,
        ep.nomequipe,
        SUM(point_2) AS total_points_obtenu
    FROM (
             SELECT
                 v.*,
                 DENSE_RANK() OVER (ORDER BY v.temps_effectue ASC) AS place_2,
                 COALESCE(p.point_atribuer, 0) AS point_2
             FROM
                 (SELECT
                      *,
                      DENSE_RANK() OVER (PARTITION BY etape_id, genre ORDER BY temps_effectue ASC) AS place_2
                  FROM
                      view_coureur_rank
                  WHERE
                          genre = 'M') v
                     LEFT JOIN
                 parametre_point p
                 ON
                         v.place_2 = p.rang
         ) AS subquery
             JOIN
         equipes ep ON ep.id = equipe_id
    GROUP BY
        equipe_id, ep.nomequipe
)
SELECT
    equipe_id,
    nomequipe,
    total_points_obtenu,
    DENSE_RANK() OVER (ORDER BY total_points_obtenu DESC) AS rang_equipe
FROM
    equipe_points
ORDER BY
    rang_equipe;

-- -- classement general team by categorie Junior
WITH equipe_points AS (
    SELECT
        equipe_id,
        ep.nomequipe,
        SUM(point_2) AS total_points_obtenu
    FROM (
             SELECT
                 v.*,
                 DENSE_RANK() OVER (ORDER BY v.temps_effectue ASC) AS place_2,
                 COALESCE(p.point_atribuer, 0) AS point_2
             FROM
                 (SELECT
                      *,
                      DENSE_RANK() OVER (PARTITION BY etape_id, categorie ORDER BY temps_effectue ASC) AS place_2
                  FROM
                      view_coureur_rank
                  WHERE
                          categorie = 'Junior') v
                     LEFT JOIN
                 parametre_point p
                 ON
                         v.place_2 = p.rang
         ) AS subquery
             JOIN
         equipes ep ON ep.id = equipe_id
    GROUP BY
        equipe_id, ep.nomequipe
)
SELECT
    equipe_id,
    nomequipe,
    total_points_obtenu,
    DENSE_RANK() OVER (ORDER BY total_points_obtenu DESC) AS rang_equipe
FROM
    equipe_points
ORDER BY
    rang_equipe;

-- import_csv

create table csv_point(
    classement int,
    points int
);

create table csv_etape(
    etape VARCHAR(100),
    longueur double precision,
    nbr_coureur int,
    rang int,
    date_depart date,
    heure_depart time
);

create table csv_resultat(
    etape_rang int,
    numero_dossard int,
    nom varchar(100),
    genre varchar(1),
    date_naissance date,
    equipe varchar(100),
    arrivee timestamp
);

drop sequence seq_equipe cascade;
drop sequence seq_coureur cascade;
drop sequence seq_categ_cour cascade;
drop sequence seq_etape cascade;
drop sequence seq_etape_coureur cascade;
drop sequence seq_penalite cascade;
drop sequence seq_param_point cascade;
drop sequence seq_tce cascade;

CREATE SEQUENCE seq_equipe
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_coureur
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_categ_cour
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_etape
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_etape_coureur
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_penalite
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_param_point
    INCREMENT BY 1
    START WITH 1;
CREATE SEQUENCE seq_tce
    INCREMENT BY 1
    START WITH 1;
