# Project Installation Steps

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
