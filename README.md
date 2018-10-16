# Example application

## Introduction

This is a example application based on Zend Framework Skeleton Application.
This is a base UI for currency converter library.

## Installation

```
git clone https://github.com/GrzegorzDrozd/ExampleApplication.git example
```
Then run composer:
```
cd example
composer install
```
If during installation composer asks similar question:
```
Please select which config file you wish to inject 'Zend\Hydrator' into:
  [0] Do not inject
  [1] config/modules.config.php
  [2] config/development.config.php.dist
  Make your selection (default is 0):1
```
Please answer with "config/modules.config.php" option and on the following question:
```
  Remember this option for other packages of the same type? (y/N)
```
Answer with "y".

You can now serve application using built in php server:
```
php -S 127.0.0.1:8080 -t public
``` 
Open browser and enter following url:
```
http://127.0.0.1:8080
```

## Requirements
This application was written on php 7.2.10. I did not test it on different version of php.
Required extensions: curl, openssl, sockets
