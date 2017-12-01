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
- docker rm <Names> (Remove container -List container `docker ps -as`)
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

## Docker Build
This method allows the users to build their own Docker images.

**Syntax:** `docker build -t <imageName>:<tagName> ./dockerfile/path`

**Example:** `docker build -t helloWorld:1.1 .`

In above example, 'helloWorld' is the name we are giving to the Image, '1.1'
is the Image tag number and '.' is path to Dockerfile which is current directory.

To view the new Image, run `docker images` command.

## Docker Compose
This method is used to run multiple containers as a single service. 
In below example, the application requires python (that returns product list) 
and php-apache server (to display product list). With the help of 
docker-compose.yml file we can start both the containers as a service without
the need to start each one separately.

**Directory Structure**
```
.
|-- 2-docker-compose-demo
    |-- docker-compose.yml
    |-- product
    |   |-- Dockerfile
    |   |-- products.py
    |   |-- requirements.txt
    |-- website
        |-- index.php
```

**File 1: docker-compose.yml**
```
version: '3'

services: 
    product-service:
        build: ./product
        volumes:
         - ./product:/usr/src/app
        ports:
         - 5001:80

    website:
        image: php:apache
        volumes:
         - ./website:/var/www/html
        ports:
         - 5000:80
        depends_on:
         - product-service
```

**File 2: product/Dockerfile**
```
FROM python:3-onbuild
COPY . /usr/src/app
CMD ["python", "products.py"]
```

**File 3: product/products.py**
```py
# Product service 

from flask import Flask
from flask_restful import Resource, Api

app = Flask(__name__)
api = Api(app)

class Product(Resource):
    def get(self):
        return {
            'product': ['Ice Cream', 
                        'Chocolate',
                        'Fruit',
                        'Eggs']
        }

api.add_resource(Product, '/')

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80, debug=True)
```

**File 4: product/requirements.txt**
```txt
Flask==0.12
flask-restful==0.3.5
```

**File 5: website/index.php**
```php
<html>
    <head>
        <title>My product list</title>
    </head>

    <body>
        <h1>Product List</h1>
        <ul>
        <?php 
            $json = file_get_contents('http://product-service');
            $items = json_decode($json)->product;

            foreach ($items as $item) {
                echo "<li>".$item."</li>";
            }
        ?>
        </ul>
    </body>
</html>
```
## Publish Docker images in Docker Hub
**Example**

Create repository (eg. webgautam) in Docker Hub (//hub.docker.com)

Get the image id (eg: c19250dbff8a) that you want to push and tag it

`docker tag c19250dbff8a webgautam/demorep:1.0`

Login into the Docker Hub repo via command prompt

`docker login`
```
Username: webgautam
Password:
Login Succeeded
```
Push the Image to the Docker Hub repository

`docker push webgautam/demorep:1.0`


**Pull Image** You can now delete images from Docker host
(webgautam/demorep:1.0, 2dockercomposerdemo_product-service) and try to pull the
repository

`docker pull webgautam/demorep:1.0`
