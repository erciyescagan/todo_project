Author : Mert Erciyes Çağan<br>
Project : To Do Planning<br>
Requirements
------------

  * PHP 7.3 or higher
  * Laravel 8.12 or higher

Installation
------------

1 - Run composer update 

```bash
$ composer update
```
2 - Run migration 
```bash
$ php artisan migrate   
```
3 - Run Seeder
```bash
$ php artisan db:seed   
```

Usage
-----

1 - Need to use below command for get tasks from providers
```bash
$ php artisan get:task {url} {provider_class_name}
```
Ex :
```bash
$ php artisan get:task https://www.mediaclick.com.tr/api/5d47f235330000623fa3ebf7.json ProviderOne
```
2 - Need to use below command for remove spesific task or all tasks
 ```bash
$ task:remove {--task_name=}
```
Ex : 

 ```bash
$ task:remove --task_name='Business Task 50'
``` 
OR

 ```bash
$ task:remove --task_name=all
```

3 - Need to use below command for create a new developer
  
```bash
 $ developer:create name={name} level={level}
 ```
Ex :
```bash
 $ developer:create --name=Dev6 --level=3
 ```


4 - Serve Project 

 ```bash
$ php artisan serve
```
