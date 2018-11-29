# Prepared by group xdc353_2
- Stephanie Chiang (40024879)
- Tommy Mei (40032865)
- Jeffrey Li (40030477)
- Jason Chung Kow Chong (27480822)
- Abishand Ariyanayagam (40030544)

# INSTALLATION GUIDE
Running on localhost
1. You will need to install XAMPP to run APACHE.
```https://www.apachefriends.org/index.html```
2. Download MySQL Workbench for your local data
```https://www.mysql.com/products/workbench/```
- You must create a connection first, click on the + icon on MySQL Workbench connections to create a connection with the connection name as localhost, username as root, and enter your password. After the connection is complete, run your connection.

3. Copy Paste the `script.sql` file onto your MySQL Workbench and excute it by clicking on execute (the lightning icon). This will create a new schema and all the tables. Make sure that the first 2 line has the code 
```create database if not exists xdc353_2;```
```use xdc353_2;```
4. Open a new file by clicking on the +SQL file icon and Copy Paste the `data.sql` file and execute it, this will create all the values.
5. Open your XAMPP Control Panel and click on start for APACHE. Ensure that your MySQL Workbench server status is running by clicking on Serve Status.
6. Open the `config.local.php` file and ensure that the defined server is localhost, username is root, password is `your password`, and the database name as project.
7. Go to localhost/COMP-353 and you should be able to access all the files from there

Running on Concordia's computer
1. You will need to login to our database, open the terminal and type in “mysql -h xdc353.encs.concordia.ca -u xdc353_2 -p xdc353_2” and enter the password “AJJST353”. 

2. Type in “show tables;” on the command line to make sure that all nine tables are there.

3. Open a new terminal and type “cd /www/groups/x/xd_comp353_2”, this will bring you to our directory where all the .php files are saved. Type in “ls” to ensure that all .php and .css files are there.


4. Type in “vim config.php” this will open vim editor, make sure that the config.php file only contains the following code: 
`<?php
   define('DB_SERVER', 'xdc353.encs.concordia.ca');
   define('DB_USERNAME', 'xdc353_2');
   define('DB_PASSWORD', 'AJJST353');
   define('DB_DATABASE', 'xdc353_2');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>`
`(To exit vim press the ecs key and type in :q and press enter)`

5. Open a browser and type in the url “https://xdc353.encs.concordia.ca/login.php”


6. Before arriving to the website, a prompt for login will appear, type in “xdc353_2” as the username login and “AJJST353” as the password to login. This will bring you to our banking system login page.

