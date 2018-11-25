# INSTALLATION GUIDE
Running on localhost
1. You will need to install XAMPP to run APACHE.
```https://www.apachefriends.org/index.html```
2. Download MySQL Workbench for your local data
```https://www.mysql.com/products/workbench/```
- You must create a connection first, click on the + icon on MySQL Workbench to create a connection with the connection name as localhost, username as root, and enter 123acb as the password. After the connection is complete, run your connection.
3. Copy Paste the `script.sql` file onto your MySQL Workbench and excute it by clicking on execute (the lightning icon). This will create a new schema and all the tables.
4. Open a new file by clicking on the +SQL file icon and Copy Paste the `data.sql` file and execute it, this will create all the values.
5. Open your XAMPP Control Panel and click on start for APACHE. Ensure that your MySQL Workbench server status is running by clicking on Serve Status.
6. Open the `config.local.php` file and ensure that the defined server is localhost, username is root, password is 123abc, and the database name as project.
7. go to localhost/COMP-353 and you should be able to access all the .php files from there
