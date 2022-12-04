create database playerstats;

drop databaseplayerstats;

CREATE TABLE Lebron  (
  seasonID int NOT NULL AUTO_INCREMENT,
  seasonDateStart varchar(4),
  seasonDateEnd varchar(4),
  team varchar(255)NOT NULL,
  gamesPlayed int NOT NULL,
  ppg double NOT NULL,
  rpg double NOT NULL,
  apg double NOT NULL,
  totalMins int NOT NULL,
  totalPoints int NOT NULL,
  PRIMARY KEY (seasonID)
);

INSERT INTO lebron VALUES (1, '2003', '2004',"CLE", 79, 20.9, 5.5, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (2, '2004', '2005',"CLE", 80, 27.2, 7.4, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (3, '2005', '2006',"CLE", 79, 31.4, 6.6, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (4, '2006', '2007',"CLE", 78, 27.3, 6.0, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (5, '2007', '2008',"CLE", 75, 30.0, 7.2, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (6, '2008', '2009',"CLE", 81, 29.7, 7.2, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (7, '2009', '2010',"CLE", 76, 26.7, 8.6, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (8, '2010', '2011',"MIA", 62, 27.1, 7.0, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (9, '2011', '2012',"MIA", 76, 26.8, 6.2, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (10, '2012', '2013',"MIA", 77, 27.1, 7.3, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (11, '2013', '2014',"MIA", 69, 26.8, 6.3, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (12, '2014', '2015',"CLE", 76, 27.1, 7.4, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (13, '2015', '2016',"CLE", 74, 25.3, 6.8, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (14, '2016', '2017',"CLE", 82, 26.4, 8.7, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (15, '2017', '2018',"CLE", 82, 26.4, 8.7, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (16, '2018', '2019',"LAL", 55, 27.5, 9.1, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (17, '2019', '2020',"LAL", 67, 25.3, 8.3, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (18, '2020', '2021',"LAL", 45, 25.0, 5.5, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (19, '2021', '2022',"LAL", 56, 30.3, 5.5, 5.9, 3122, 1654);
INSERT INTO lebron VALUES (20, '2022', '2023',"LAL", 13, 25.1, 5.5, 5.9, 3122, 1654);
