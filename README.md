# Project Installation Steps

 Required PHP 8.2.0 or greater.

### Step 1
Clone project from master branch 

 Open Terminal and run this command
```sh
 git clone -b master https://github.com/raselrana1147/clicq_pack_api.git
```
### Step 2
Go to project directory 
```sh 
 cd clicq_pack_api
 ```
### Step 3
Install Composer
```sh 
composer install
```
### Step 4
Add .env file
```sh 
copy .env.example .env
```
### Step 5
Generate application key
```sh 
php artisan key:generat
```
### Step 6
Open .env file and chanage DB_CONECTION sqlite to mysql

Remove # comment from following line

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=click_pack_backend

DB_USERNAME=root

DB_PASSWORD=

Provide database credentials

### Step 7
Add Migration file to database
```sh 
php artisan migrate
```
### Step 8
Run project
```sh 
php artisan serve
```

### After do these steps you have to install frotend project. Fromtend install processes are given in frontend repository 
