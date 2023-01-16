
DROP TABLE IF EXISTS log_event;

CREATE TABLE log_event (
  log_id int(11) NOT NULL AUTO_INCREMENT,
  log_user varchar(100) NOT NULL,
  log_action varchar(255) NOT NULL,
  log_page varchar(255) NOT NULL,
  log_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  log_ip varchar(255) NOT NULL,
  log_description text,
  log_status tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (log_id),
  KEY log_user (log_user,log_action,log_page)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

 

DROP TABLE IF EXISTS log_friends_byzone;

CREATE TABLE log_friends_byzone (
  log_id bigint(20) NOT NULL AUTO_INCREMENT,
  log_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  area varchar(20) DEFAULT NULL,
  percentage varchar(70) DEFAULT NULL,
  log_ipaddress varchar(50) DEFAULT NULL,
  PRIMARY KEY (log_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (1,'2023-01-06 12:04:40','Bangkok','54.4',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (2,'2023-01-06 12:04:42','Southern','9.9',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (3,'2023-01-06 12:04:44','NorthEastern','9.4',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (4,'2023-01-06 12:04:46','Eastern','8.7',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (5,'2023-01-06 12:04:48','Northern','8.5',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (6,'2023-01-06 12:04:51','Central','8.2',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (7,'2023-01-06 12:04:53','Western','0.6',NULL);
insert  into log_friends_byzone(log_id,log_date,area,percentage,log_ipaddress) values (8,'2023-01-06 12:04:55','unknown','0.4',NULL);


DROP TABLE IF EXISTS log_friends_overview;

CREATE TABLE log_friends_overview (
  log_id bigint(20) NOT NULL AUTO_INCREMENT,
  log_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  contacts int(11) DEFAULT NULL,
  targetReaches int(11) DEFAULT NULL,
  blocks int(11) DEFAULT NULL,
  PRIMARY KEY (log_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (1,'2021-09-17 00:00:00',9854650,2483512,3160980);
insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (2,'2021-09-18 00:00:00',9855047,2483446,3160971);
insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (3,'2021-09-19 00:00:00',9855320,2483357,3160935);
insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (4,'2021-09-20 00:00:00',9856108,2483111,3161541);
insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (5,'2021-09-21 00:00:00',9856652,2483150,3161591);
insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (6,'2021-09-22 00:00:00',9857301,2482777,3162205);
insert  into log_friends_overview(log_id,log_date,contacts,targetReaches,blocks) values (7,'2021-09-23 00:00:00',9857429,2482677,3162353);



DROP TABLE IF EXISTS log_login;

CREATE TABLE log_login (
  log_id bigint(20) NOT NULL AUTO_INCREMENT,
  log_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  log_type varchar(70) DEFAULT NULL,
  log_description varchar(2000) DEFAULT NULL,
  log_createby varchar(70) DEFAULT NULL,
  log_ipaddress varchar(50) DEFAULT NULL,
  log_session_id varchar(100) DEFAULT NULL,
  PRIMARY KEY (log_id) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

 

DROP TABLE IF EXISTS log_userevent;

CREATE TABLE log_userevent (
  log_id int(11) NOT NULL AUTO_INCREMENT,
  log_user varchar(100) NOT NULL,
  log_action varchar(255) NOT NULL,
  log_page varchar(255) NOT NULL,
  log_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  log_ip varchar(255) NOT NULL,
  log_description text,
  log_status tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (log_id),
  KEY log_user (log_user,log_action,log_page)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;



DROP TABLE IF EXISTS log_userlogin;

CREATE TABLE log_userlogin (
  log_id bigint(20) NOT NULL AUTO_INCREMENT,
  log_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  log_type varchar(70) DEFAULT NULL,
  log_description varchar(2000) DEFAULT NULL,
  log_createby varchar(70) DEFAULT NULL,
  log_ipaddress varchar(50) DEFAULT NULL,
  log_session_id varchar(100) DEFAULT NULL,
  PRIMARY KEY (log_id) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
