Basically, project to manage companies and their employees.

## Docker environment
```shell
# environment
$ php artisan about --only=environment
Laravel Version 11.23.5
PHP Version 8.3.11
Composer Version 2.7.9
Timezone UTC
Locale en

# web server
$ nginx -V
nginx version: nginx/1.24.0

# mysql
$ mysql -V
mysql  Ver 8.0.25 for Linux on x86_64 (MySQL Community Server - GPL)
```

## Prerequisites
Before getting started, ensure that you have the following prerequisites installed on your system if you want start-up with Docker:

* Docker: [Installation Guide](https://docs.docker.com/get-docker/)
* Docker Compose: [Installation Guide](https://docs.docker.com/compose/install/)

## Start-up
__Clone this repository to your local machine.__
```shell
$ git clone https://github.com/zalkarz/test-skills.git
```

__Navigate to the cloned repository__
```shell
$ cd ~/test-skills
```

__Start-up Docker containers__
```shell
$ make init
```
This command will build the necessary images and run the containers in the background.

__Stop Docker containers__

```shell
$ make stop
```

## Application URL
http://localhost:8084
