# Docker -Develop, ship and run anywhere.

- Provide smaller footprint of the OS
- Docker containers make it easier for teams to work seamlessly across different 
  units, such as development, QA, and Operations
- Deploy containers anywhere (physical, virtual machines and even the cloud)
- Containers are pretty lightweight hence very easily scalable.

**Images** The Images contain all definitions how to boot up the Linux
environment.

**Containers** The Containers are instances of docker images. A Container or its
data are not persistent and to make persistent it requires volume.

**Volumes** The Volumes can be used as the underlying data layer. All data stored 
in the volume could be used by all Containers connected to it.

**Network** Dockers comes with its own networking capacities. The name of a
container is its hostname. (Eg. http://container-name/)

**Docker Engine** It is used for building Docker images and creating Docker
containers.

**Docker Hub** This is the registry which is used to host various Docker images.

**Docker Compose** This is used to define applications using multiple Docker
containers.

## Docker Basic Command
- docker images (List all locally available images)
- docker ps (Show currently running only containers)
- docker ps -a (Show all containers)
- docker-compose up -d
- docker exec -it 6da7468e01f1 bash (using container ID)
- docker rmi <imageID> (Remove image)
- docker inspect <image> (View details of an image or container)

## Dockerfile
A text document that contains all the commands a user could call on the command
line to assemble an image.

Basic demo of Dockerfile ([Refer to 1-dockerfile-demo](./1-dockerfile-demo))

**Directory Structure**
```
.
|-- 1-dockerfile-demo
    |-- Dockerfile
    |-- src
        |-- index.php
```

**File 1: src/index.php**
```php
<?php
 echo "Hello World!";
?>
```

**File 2: Dockerfile**
```
FROM php:7.0-apache
Copy src/ /var/www/html  
Expose 8080
```
Go to project directory `$ cd 1-dockerfile-demo`

Build `docker build -t hello-world .`

Run `docker run -p 8080:80 hello-world`

Go to browser `http://localhost:8080`

Mount volume `docker run -p 8080:80 -v
/Users/damber/Sites/damber/docker-proj/hello-world/src/:/var/www/html/
hello-world`
It is useful to reflect the changes without rebuilding container after each
change.

