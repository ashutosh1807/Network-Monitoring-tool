mysql -u root -p  -e "
Drop DATABASE if exists packets;
create database packets;
use packets;


DROP TABLE if exists ipv4;
DROP TABLE if exists arp;
DROP TABLE if exists udp;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      

create table arp(
Time_stamp varchar(20),
Source_mac varchar(20),
Destination_mac varchar(20),
Length varchar(20),
Source_ip varchar(20),
Destination_ip varchar(20));

create table udp(
Time_stamp varchar(20),
Source_mac varchar(20),
Destination_mac varchar(20),
length varchar(20),
Source_ip varchar(20),
Source_port varchar(20),
Destination_ip varchar(20),
Destination_port varchar(20)
);

create table ipv4(
Time_stamp varchar(20),
Source_mac varchar(20),
Destination_mac varchar(20),
length varchar(20),
Source_ip varchar(20),
Source_port varchar(20),
Destination_ip varchar(20),
Destination_port varchar(20)
);

LOAD DATA LOCAL INFILE 'ARP' INTO TABLE arp;
LOAD DATA LOCAL INFILE 'UDP' INTO TABLE udp;
LOAD DATA LOCAL INFILE 'IPV4' INTO TABLE ipv4;

drop table if exists user;
create table user(
    username varchar(100),
    email varchar(100),
    password varchar(100));
"
