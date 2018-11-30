# autoload

Installation Guide
-------------------

create a composer file and add:
{
  "minimum-stability": "dev",

  "require": {
    "php": ">=7.1",
    "obinna/app": "*"
},

  "autoload": {
    "psr-4": {
      "Obinna\\":"src/"
    }
  }
}

Install package:

sudo composer require obinna/app:dev-master

sudo apt-get install php7.2-bcmath

sudo composer require php-amqplib/php-amqplib

sudo composer require vlucas/phpdotenv

Install RabbitMQ Server and set user https://www.rabbitmq.com/download.html

Install php memchached

Prepare project:
copy the index.php file from package to your project directory

Generate optimised autoload file:
composer dumpautoload -o


Copy:

public folder into the root of your app 


Create Database Table:

CREATE TABLE videos( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, video_id VARCHAR(30) NOT NULL, title VARCHAR(500) NOT NULL, created_date TIMESTAMP )


Expectation:

Search Youtube videos (max of 50 at a time)

Save video

View all saved videos

Delete videos

Can select all or deselect all videos / inverted select

Run receiver_1 (1 to 4) on multiple terminals

You should see a queued video saved message when videos are save (a basic demo of rabbitMQ)

The first time you view all saved videos, the system returns record from database and saves it into the cache

If same record is querried within 1 hr, the cached version is returned and cache expires after one hour



View Data Stored in Cache:

ssh into your server

Run: telnet localhost 11211

Run: get select (to view data stored in cache with "select key")
