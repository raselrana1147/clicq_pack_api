# Project Installation Steps

### Step 1
=>Clone project from master branch 
```sh 
 Open Terminal and run this command

 git clone -b master https://github.com/raselrana1147/clicq_pack_api.git
```
### Step 2
=>Go to project directory 
```sh 
 Run 
 cd clicq_pack_api
 ```
### Step 3
=>Install Composer

```sh 
Run 
composer install

```
### Step 4
=>Add .env file
```sh 
Run
copy .env.example .env
```

### Step 5
=>Generate application key
```sh 
Run
php artisan key:generat
```
### Step 6
=>Connect database in .env file
```sh 
Open .env file and chanage DB_CONECTION sqlite to mysql
```

### Step 7
=>Add Migration file to database
```sh 
    Run
    php artisan migrate
```
### Step 8
=>Run project
```sh 
Run 
php artisan serve
```
