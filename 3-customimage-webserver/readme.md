## Dockerfile

**Description:**

- Use Ubuntu image as a base to our image
- Run command to update all packages on the Ubuntu system
- Run command to install apache2 on our image
- Run command to install apache2 utility packages
- Run command to clean unnecessary files
- CMD command to run apache2 in the background

### Build Image from Dockerfile
`docker build -t myubuntuserver:latest .`

### Run Docker Image
`docker run -d -p 8080:80 myubuntuserver:latest`

Go to //localhost:8080 url.

### Get bash access of the running container
- Create container `docker run -d -p 8080:80 myubuntuserver:latest`
- Copy the container id by running `docker ps`
- Finally, `docker exec -it <CONTAINER_ID> /bin/bash`
```cmd
root@<CONTAINER_ID>:/# whoami
root
root@<CONTAINER_ID>:/# uname
Linux
root@<CONTAINER_ID>:/# exit
exit
```
