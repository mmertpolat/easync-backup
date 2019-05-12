# Easync Backup Tool

Easync tool allows you to get full backup of your website in seconds.

## Getting Started

Project coded in PHP. Just copy the project files to the directory you want to get full backup.

### Prerequisites

PHP 7.2+ because of .zip protection system.

Add these lines to your .htaccess file.

```
php_value memory_limit 8192M
php_value post_max_size 8192M
php_value upload_max_filesize 8192M
php_value max_execution_time 0
php_value memory_limit -1
```

Important Note: If you are using CloudFlare, you may get error related to timeout.

### Installing

Edit protect-this.php and login.php for login password. You should edit this line:

```
$password = 'test';
```
Just copy the project files to the directory you want to get full backup. If you have not database in your website. You can leave all fields empty.

```
If you want get backup of database, you should complete database information fields.
```

## Built With

* [PHP](http://www.php.net) - The programming language used.

## Authors

* **[Muhammet Mert POLAT](http://muhammedmertpolat.com)**
