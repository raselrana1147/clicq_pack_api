# Project Installation Steps

### Step 1
=>Clone project from master branch 
```sh 
 Open Terminal and run this command

 git clone -b master https://github.com/raselrana1147/clicq_pack_api.git
```
### Step 1
=>Go to project directory 
```sh 
 Run 
 cd clicq_pack_api
 ```
### Step 2
=>Install Composer

```sh 
Run 
composer install

```
### Step 3
=>Add .env file
```sh 
Run
copy .env.example .env
```

### Step 4
=>Generate application key
```sh 
Run
php artisan key:generat
```
### Step 5
=>Connect database in .env file
```sh 
Open .env file and chanage DB_CONECTION sqlite to mysql
```

### Step 5
=>Add Migration file to database
```sh 
    Run
    php artisan migrate
```
### Step 6
=>Run project
```sh 
Run 
php artisan serve
```
