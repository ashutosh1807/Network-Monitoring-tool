#!/bin/bash
mkdir arp
mkdir ipv4
mkdir udp
mkdir arp/rep
mkdir arp/req
/usr/sbin/tcpdump -ne -c 1000 >file
grep ARP file>arp/ARP
grep IPv4 file>ipv4/IPV4
grep UDP file>udp/UDP
grep Request arp/ARP>arp/request
grep Reply arp/ARP>arp/reply


awk '//{print $1}' arp/request > arp/req/timestamp
awk '//{print $2}' arp/request > arp/req/sourceMAC
awk '//{print substr($4, 1, length($4)-1)}' arp/request > arp/req/destMAC
awk '//{print substr($9, 1, length($9)-1)}' arp/request > arp/req/length
awk '//{print substr($14, 1, length($14)-1)}' arp/request > arp/req/sourceip
awk '//{print $12}' arp/request > arp/req/destip


awk '//{print $1}' arp/reply > arp/rep/timestamp
awk '//{print $2}' arp/reply > arp/rep/sourceMAC
awk '//{print substr($4, 1, length($4)-1)}' arp/reply > arp/rep/destMAC
awk '//{print substr($9, 1, length($9)-1)}' arp/reply > arp/rep/length
awk '//{print $11}' arp/reply > arp/rep/sourceip


awk '//{print $1}' udp/UDP > udp/timestamp
awk '//{print $2}' udp/UDP > udp/sourceMAC
awk '//{print substr($4, 1, length($4)-1)}' udp/UDP > udp/destMAC
awk '//{print substr($9, 1, length($9)-1)}' udp/UDP > udp/length
awk '//{print $10}'  udp/UDP > udp/temp
cut -d "." -f1,2,3,4 udp/temp >udp/sourceip
cut -d "." -f5 udp/temp > udp/sourceport
awk '//{print substr($12, 1, length($12)-1)}' udp/UDP > udp/temp
cut -d "." -f1,2,3,4 udp/temp > udp/destip
cut -d "." -f5 udp/temp > udp/destport
rm udp/temp


awk '//{print $1}' ipv4/IPV4 > ipv4/timestamp
awk '//{print $2}' ipv4/IPV4 > ipv4/sourceMAC
awk '//{print substr($4, 1, length($4)-1)}' ipv4/IPV4 > ipv4/destMAC
awk '//{print substr($9, 1, length($9)-1)}' ipv4/IPV4 > ipv4/length
awk '//{print $10}' ipv4/IPV4 > ipv4/temp
cut -d "." -f1,2,3,4 ipv4/temp >ipv4/sourceip
cut -d "." -f5 ipv4/temp > ipv4/sourceport
awk '//{print substr($12, 1, length($12)-1)}' ipv4/IPV4 > ipv4/temp
cut -d "." -f1,2,3,4 ipv4/temp > ipv4/destip
cut -d "." -f5 ipv4/temp > ipv4/destport
rm ipv4/temp

paste arp/req/timestamp arp/req/sourceMAC arp/req/destMAC arp/req/length arp/req/sourceip arp/req/destip >ARP
paste arp/rep/timestamp arp/rep/sourceMAC arp/rep/destMAC arp/rep/length arp/rep/sourceip  >>ARP
paste udp/timestamp udp/sourceMAC udp/destMAC udp/length udp/sourceip udp/sourceport udp/destip udp/destport>UDP
paste ipv4/timestamp ipv4/sourceMAC ipv4/destMAC ipv4/length ipv4/sourceip ipv4/sourceport ipv4/destip ipv4/destport>IPV4



awk '//{print $5}' ARP|sort|uniq -c |sort -nr|head -5 >topARP
awk '//{print $5}' UDP|sort|uniq -c |sort -nr|head -5 >topUDP
awk '//{print $5}' IPV4|sort|uniq -c |sort -nr|head -5 >topIPV4

awk '//{print $1}' topARP>tmp1
awk '//{print $2}' topARP >tmp2
paste tmp1 tmp2> topARP

awk '//{print $1}' topUDP>tmp1
awk '//{print $2}' topUDP >tmp2
paste tmp1 tmp2> topUDP

awk '//{print $1}' topIPV4>tmp1
awk '//{print $2}' topIPV4 >tmp2
paste tmp1 tmp2> topIPV4
rm tmp1 tmp2

mysql -e "

use packets;

DROP TABLE if exists ipv4;
DROP TABLE if exists arp;
DROP TABLE if exists udp;  
DROP TABLE if exists arptop5;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
DROP TABLE if exists udptop5;
DROP TABLE if exists ipv4top5;

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

create table arptop5(
No_of_entries varchar(20),
Source_ip varchar(20)

);

create table udptop5(
    No_of_entries varchar(20),
Source_ip varchar(20)

);

create table ipv4top5(
    No_of_entries varchar(20),
Source_ip varchar(20)

);

LOAD DATA LOCAL INFILE 'ARP' INTO TABLE arp;
LOAD DATA LOCAL INFILE 'UDP' INTO TABLE udp;
LOAD DATA LOCAL INFILE 'IPV4' INTO TABLE ipv4;
LOAD DATA LOCAL INFILE 'topARP' INTO TABLE arptop5;
LOAD DATA LOCAL INFILE 'topUDP' INTO TABLE udptop5;
LOAD DATA LOCAL INFILE 'topIPV4' INTO TABLE ipv4top5;

"

rm -r arp
rm -r ipv4
rm -r udp
rm ARP file IPV4 topARP topIPV4 topUDP UDP


