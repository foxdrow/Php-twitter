# Tweet Academy project
***

## Overview: 

Tweet Academy is a group project aimed at creating a website similar to Twitter.

## How to start: 

-Launch a PHP server from the terminal in the Root directory:

        php -S 0.0.0.0:3000

-Launch MYSQL from the terminal:

        sudo service mysql start

-Add the twitter.sql table at mysql:

        sudo mysql < twitter.sql

-Set your mysql password in Core / Db.php file line 21 if necessary:

        private const DBPASS = 'password';

-In your browser, enter the following url:

        http://localhost:3000/

Enjoy :)