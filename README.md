# Rest API to manage companies
Basically, project to manage companies and their employees.

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
