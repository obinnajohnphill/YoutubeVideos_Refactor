**Installation**

1. Clone project: https://github.com/obinnajohnphill/YoutubeVideo_Non_Laravel.git

2. Rename .env.example to .env

3. Add database credentials and rabbitMQ server login details to .env

4. Install RabbitMQ Server and set user https://www.rabbitmq.com/download.html

5. Install php memchached



**Create a table**

CREATE TABLE videos(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
video_id VARCHAR(30) NOT NULL,
title VARCHAR(500) NOT NULL,
created_date TIMESTAMP
)


**Expectation**

1. Search Youtube videos (max of 50 at a time)

2. Save video

3. View all saved videos

4. Delete videos 

5. Can select all or deselect all videos / inverted select

6. Run receiver_1 (1 to 4) on multiple terminals

7. You should see a queued video saved message when videos are save (a basic demo of rabbitMQ)

8. The first time you view all saved videos, the system returns record from database and saves it into the cache

9. If same record is querried within 1 hr, the cached version is returned and cache expires after one hour 


**View Data Stored in Cache**

1. ssh into your server 

2. Run: telnet localhost 11211 

3. Run: get select (to view data stored in cache with "select key")


**Boot up Kafka Server**

1. Fromm the app roor run: docker-compose up -d

2. Run: docker-compose run --rm --entrypoint php app run_consumer.php (on terminal)

3. Run: docker-compose run --rm --entrypoint php app run_producer.php (on separate terminal)

3. Run: tail data/logs/*.log (another terminal) ; You should see the kafka producer send out message when video is save,
and you should see the kafka message consumer ready to consume messages.


