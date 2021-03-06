Cache Failover
========

Minimum Requirements
---------
* PHP 5.4
* [MongoDB driver](http://php.net/manual/en/mongo.installation.php#mongo.installation.nix)
* Mongo 2.6
* Redis 3

Installation
------
* $ git clone git@bitbucket.org:easytaxi/interview-cache-failover.git
* $ cd interview-cache-failover/
* $ composer install
* $ php app/console server:run
* Open http://127.0.0.1:8000/customers in your browser (check if everything is fine)
* You can test your database operation by doing a POST into /customers/
* $ curl http://127.0.0.1:8000/customers/ -X POST -d '[{"name":"leandro", "age":26}, {"name":"marcio", "age":30}]'
* Then check your MongoDB collection to see if customers were created or just call the action
* $ curl http://127.0.0.1:8000/customers/

Running tests
------
* Install PHPUnit
* In projects root run: phpunit
