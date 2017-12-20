# Kubernetes 
- an open-source
- a system for automating deployment and scaling
- a container management technology (manage containerized applications)
- developed in Google lab & hosted by Cloud Native Computing Foundation (CNCF)

## Terminology 
### 1. Pods
A Pod is a logical wrapper around running containers which hold an application.
For example, a Pod may have mysql database container, microservices container,
and wordpress container running together as an application.

<img src='./pods.png' height='200px' alt='Pods'>

### 2. Replication Controllers
Replication controllers ensure that a specific number of pod replicas are
running at any one time. It manages cluster (group of pods), scale up cluster (by
creating extra pod copies), scale down cluster (by removing a few copies). It
can monitor each pod and if one is unresponsive or misbehave, it can kill that
one and bring on a suitable replacement.

<img src='./replicationcontroller.png' height='350px' alt='Replication
Controller'>

### 3. Services
Services defines a logical set of Pods and a policy by which to access them over 
the network. For example, a service preserves IP addresses and ports so that DNS
names can map to the same thing.

<img src='./servies.png' height='350px' alt='Services'>

### 4. Volume
A place to store data that lives longer than a pod for an application.

<img src='./volume.png' height='390px' alt='Volumes'>

### 5. Namespaces
A way of encapsulating pods, replication controllers, services and volumes into
big group called namespace. It isolate its contents from everybody's stuff. 

<img src='./namespaces.png' height='390px' alt='Namespaces'>

### 6. Deployment
To deploy your containerized applications you need to create a Kubernetes Deployment configuration. It instructs Kubernetes how to create/update instances of your application, generate pods and connect to other services. 

### 7. Secret 
A secret hold sensitive information such as passowords, OAuth token, and ssh keys. It allow for more control, secure and flexible storage of sensitive information.

### 8. PVC
PersistentVolume (PV) provides an API for users and administrators that abstracts details of how storage is provided from how it is consumed.

PersistantVolumeClaim (PVC) is a request for storage by a user. It is similar to a pod. Pods consume node resources and PVCs consume PV resources.

### 9. Quota
It's useful to know about the aggregate resource consumption per namespace as you will at times check if the namespace has enough computational resources for your pod.

- Get quota name `kubectl get quota`
- Describe `kubectl describe quota <quota-name>`
```
Name:            compute-resources
Namespace:       webops-uat
Resource         Used    Hard
--------         ----    ----
limits.cpu       1850m   4
limits.memory    3584Mi  8Gi
pods             4       8
requests.cpu     1200m   2
requests.memory  2560Mi  4Gi
```

## Kubectl basics

### `kubectl get <deployments|pods|services>`

**Examples:**
```
  # List all pods in ps output format.
  kubectl get pods

  # List all pods in ps output format with more information (such as node name).
  kubectl get pods -o wide

  # Get a specified deployment file configuration in YAML output format.
  kubectl get deployment <deployment_file_name> -o yaml

  # List a single replication controller with specified NAME in ps output format.
  kubectl get replicationcontroller web

  # List a single pod in JSON output format.
  kubectl get -o json pod web-pod-13je7

  # List all replication controllers and services together in ps output format.
  kubectl get rc,services

  # List one or more resources by their type and names.
  kubectl get rc/web service/frontend pods/web-pod-13je7

  # List all resources with different types.
  kubectl get all
```

### `kubectl describe <deployments|pods|services>`
Show details of a specific resource or group of resources.

**Example**
```
  # Describe a node
  kubectl describe nodes kubernetes-node-emt8.c.myproject.internal

  # Describe a pod
  kubectl describe pods/nginx

  # Describe a pod identified by type and name in "pod.json"
  kubectl describe -f pod.json
```

### `kubectl log <OPTIONS>`
Print the logs for a container in a pod or specified resource. 

**Example**
```
  # Return snapshot logs from pod nginx with only one container
  kubectl logs nginx

  # Return snapshot logs for the pods defined by label app=nginx
  kubectl logs -lapp=nginx

  # Display only the most recent 20 lines of output in pod nginx
  kubectl logs --tail=20 nginx

  # Return snapshot logs from first container of a job named hello
  kubectl logs job/hello
```

### `kubectl <create|replace|apply> -f path/to/yaml/config/file`
`kubectl create` To create a resource from a file

`kubectl apply` To apply a configuration to a resource by filename

`kubectl replace` To replace a resource by filename

**Example**
```
  # Create a pod using the data in pod.json.
  kubectl create -f ./pod.json

  # Apply the configuration in pod.json to a pod.
  kubectl apply -f ./pod.json

  # Replace a pod using the data in pod.json.
  kubectl replace -f ./pod.json

  # Force replace, delete and then re-create the resource
  kubectl replace --force -f ./pod.json
```  

### `kubectl exec`
Execute a command in a container.

**Example:**
```
  # Execute bash in specified pod in interactive mode
  kubectl exec -it <POD_NAME> bash

  # Get output from running 'date' from pod 123456-7890, using the first container by default
  kubectl exec 123456-7890 date
```

## An example of Conceptual Kubernetes Deployment

- Build your docker image file
- Push the image to docker registry (see build.sh)
- To run build.sh `bash build.sh -v 0.0.2`
- To see deployment file `vim kube/academy-mysql-deployment.yml`
- To replace/create deployment file in kuberneties server `kubectl
  [replace/create] -f kube/academy-mysql-deployment.yml`
- See all deployments `kubectl get deployments`
- See all pods `kubectl get pods`
- See detail of deployed application `kubectl describe deploy [application_name]`
- Create/Replace/Apply services same as deployment `kubectl create -f
  kube/academy-mysql-service.yml`
- See all services `kubectl get services`
- `kubectl get pod academy-3544580744-2fq3e -o yaml`
- `kubectl get pvc -o yaml`
- Execute container bash:w
- `kubectl exec -it academy-3544580744-2fq3e bash`
