# COMP-353
Database project
: The project consists of two parts: warm-up and main, described as follows:
a. The objective of part I, called the Warm-up, is to get acquainted with the MySQL
database management system (DBMS) to which you will be provided access. For
this project, we will provide a relational database design and your team is required
to (1) create the tables in MySQL, (2) populate them with "enough", typical data,
and (3) formulate and run a given set of queries against the database and report
the results.

b. In part II of the course project, called the main project, we will provide a description
of a "realistic" application for which your team should design a database schema.
You need to show details of the steps from the E/R diagram to the refined and
normalized relations. You also need to develop a suitable user interface to
facilitate expressing and executing queries and transactions against the MySQL
DBMS. This would be a two-tier application system using some standard browser
(e.g., Internet Explorer) at the client side. At the server side, the application uses
an http server with a PHP parser. The system is expected to support all
"representative" queries and transactions efficiently. Your final project report
should include descriptions of the database design, refined tables, the queries
formulated, and the results. This is a team project, for both parts. Each team
consists of four students. Each team member will be responsible for the entire
project and at least a well defined portion of the project, to be agreed by the team
members. The demos will be determined later around the end of the term. Each
team will have 20 minutes to demonstrate their working project developed. Your
project report must be submitted at your demo time. We will set a schedule to
book a time slot for your demo. Each team has a manager, chosen by the team
members, whose role is to coordinate the project-related activities of the team
members. After first lecture, each team manager should send an email to
stan@cse.concordia.ca with the following information about their team members:
Full names, student IDs, the ENCS EMAIL accounts, and a single team password
consisting of 8 alpha-numeric characters, with a CC to the course instructor.
Important Notes:
1. You are advised to retain a copy of all your term work until you receive your final grade for
the course. Please backup all your work on diskettes. All programs must have adequate
internal and external documentations. For the project, the hard copy of the report and a
copy on CD of the source code and the SQL scripts for loading the database must be
submitted at the demo time.
2. Students should be aware of the University's code of conduct (academic) as specified in
section 16.3.14 of the aforementioned calendar (page 65), especially the parts concerning
cheating, plagiarism, and possible consequence of violating this code. Sharing codes,
design diagrams, algorithms, etc. amongst teams or using from elsewhere (without proper
citation) is not permitted. No need to mention that you will learn little from copying others
work and, clearly, this will not help you prepare better in this course.
3. Submission format: All submissions in this course must be adequately bound and
include as the cover page, the "Expectations of Originality" form available from the course
web page.
4. Recommendation: We encourage a collaborative learning approach in this course. We
also recommend to start working on the projects and assignments as early as possible! 


DATABASE INFO:
The ENCS usernames in this group are

   a_ariyan,jas_chun,l_jef,s_chian,t_mei

You have been given the "group account" xdc353_2 to do your project work
for this course. "group accounts" are needed so that you can share files
with your partners easily.

2 email aliases have been setup for your group. Sending email to either
xdc353_2@encs.concordia.ca or xd_comp353_2@encs.concordia.ca will send email
to each one of you.

Though you have a group account you do not have to login to it. You have
been added to the "xdc353_2" linux group and you can write in the following
directories:


    /groups/x/xd_comp353_2       This directory is where you should cd into
                                 and use while working on the project.
                                 It is *NOT* available on the web server!


    /www/groups/x/xd_comp353_2   This is the directory where you should place
                                 *ALL* the files to be viewable on the web.


You as a user do not have any disk quota on the above directories but the
linux group "xdc353_2" does. The above directories have the sgid bit set
(the 's' in 'rws' below) which means that any files or directories created
below these ones will automatically belong to the "xdc353_2" group

   permissions     owner       group        location
    drwxrws---    xdc353_2   xdc353_2      /groups/x/xd_comp353_2
    dr-xrws---    nul-web    xdc353_2      /www/groups/x/xd_comp353_2

(The web server initially runs as "nul-web" before switching to "xdc353_2".)


If you change the permissions of any directory under these make sure that
the 's' bit is on (use "chmod g+s name_of_subdirectory" to do so). If you
ever get a message that you are over quota please check the permissions of
the directory you are trying to write into.

The server used for the project runs Scientific Linux 7.4
The version of MYSQL in use this term is 5.6.39 and PHP is version 7.2.5

You can run the command "mysql" on any linux machine in the faculty.

Your MYSQL username is xdc353_2
The name of the MYSQL server is xdc353.encs.concordia.ca
The name of the database you can use is also xdc353_2
The password for your database is AJJST353  (case sensitive)
You cannot change this password.


To run mysql use the following:

[login] 101 => mysql -h xdc353.encs.concordia.ca -u xdc353_2 -p xdc353_2
Enter password: AJJST353

Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 350
Server version: 5.6.39 Source distribution

Copyright (c) 2000, 2014, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> create table employees(SIN dec(9));
Query OK, 0 rows affected (0.03 sec)

mysql> show tables;
```
+--------------------+
| Tables_in_xdc353_2 |
+--------------------+
| employees          |
+--------------------+
```
1 row in set (0.01 sec)

mysql> alter table employees add Name char(25);
Query OK, 0 rows affected (0.03 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> desc employees;
```
+-------+--------------+------+-----+---------+-------+
| Field | Type         | Null | Key | Default | Extra |
+-------+--------------+------+-----+---------+-------+
| SIN   | decimal(9,0) | YES  |     | NULL    |       |
| Name  | char(25)     | YES  |     | NULL    |       |
+-------+--------------+------+-----+---------+-------+
2 rows in set (0.00 sec)
```
mysql> drop table employees;
Query OK, 0 rows affected (0.02 sec)

mysql> show tables;
Empty set (0.00 sec)

mysql> exit
Bye


The User ID  for web access is xdc353_2
The password for web access is AJJST353

The base URL for your web pages is

    https://xdc353.encs.concordia.ca/

Note: it is https not http! The web server will automatically redirect
       to https if the URL starts with http.


As an example you can create a foo.php in /www/groups/x/xd_comp353_2
that contains:
```
<HTML>
<HEAD>
   <TITLE>Date/Time Functions Demo</TITLE>
</HEAD>
<BODY>
<H1>Date/Time Functions Demo</H1>
<P>The current date and time is
<EM><?echo date("D M d, Y H:i:s", time())?></EM>
<P>Current PHP version:
<EM><?echo  phpversion()?></EM>
</BODY>
</HTML>
```

Using the URL https://xdc353.encs.concordia.ca/foo.php
you would see something like

     Date/Time Functions Demo

     The current date and time is Wed Sep 12, 2018 15:41:43

     Current PHP version: 7.2.5


Stan

*****************************************************************************
* Stan Swiercz              * Tel: (514) 848-2424 ext 3054   Fax: 848-2830  *
* Manager Apps and Info Sys * Room:EV-7.165 Email:stan.swiercz@concordia.ca *
* ENCS -- AITS              * WWW: http://users.encs.concordia.ca/~stan     *
* Concordia University      *************************************************
* Montreal, Canada          *  A clean desk is a sure sign of a sick mind!  *
*****************************************************************************

