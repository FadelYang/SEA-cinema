![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/f593d44a-3378-4639-a41f-b8c4e6ff1cd3)	# Penjuang Event (evenin)

![Alt text](image.png)
# Laravel Compfest Movie App	## Tentang Pejuang Event
## A Web App About Movie Ticketing	Pejuang Event adalah sebuah platform yang dapat digunakan untuk manajemen dan mempromosikan event. tersedia berbagai tawaran menarik paket promosi event, dan gratis untuk kamu yang seorang pelajar atau mahasiswa.


This my submission for Compfest 15 Software Engineering Academy, this website is build with Laravel 9 and Bootstrap 5. you can login, top up some balance, and buy movies ticket with thats balances. make sure you have enough balance before buy the ticket. or you can just top up the balance as much as you want.	Pejuang Event dibangun dengan

- Laravel 9
this web app is build with	- Tailwind CSS 3
* laravel 9	- MySQL
* Bootstrap 5	- Windmill Dashboard Admin
* Mysql	
* Apache	## Fitur Pejuang Event


## Getting Started	- Membuat event dan tiket

- Manajemen konten event yang terbit
make sure u have	- Pembayaran tiket melalui e-wallet dan bank (sudah terintegrasi payment gateway)
* php 8 or above (this is minimum requirement for Laravel 9)	- Admin dashboard untuk kurasi event yang akan tayang
* Composer	
* git	---
* mysql & apache (or simply just use XAMPP)	# Cara Menjalankan Pejuang Event
* npm 7.*	## Hal - hal  yang dibutuhkan

- PHP 8.2.4
## How To Install	- MySQL

- NPM 9.8.1
1. clone this repository with `git clone`	- Git
2. run `composer install`	- Composer 2.5.7
3. copy .env.example, paste it, and rename it with .env	
4. run `php artisan key:generate`	## Cara Install
5. configure your .env file, change the database name by your new database	- Clone atau download repository ini
6. run `php artisan migrate`	- Jalankan `composer install`
7. run `npm install && npm run dev`	- copy file .env.example, paste, lalu rubah namanya menjadi .env

- siapkan database dan rubah nama database di file .env DB_DATABASE
## Example How To Use It (The App)	- jalankan `php artisan key:generate`
* this is the home page, as an ordinary user, you can only see the list of movie and the detail movie	- jalankan `npm install && npm run dev`
![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/5d695f9f-9445-4778-bf3e-c7d68a860f04)	- jalankan `php artisan migrate`

- jalankan `php artisan db:seed`
* you can create an account by click register menu and fill the information needed	- jalankan `php artisan serve` di terminal baru

* after create an account, you can try buy a ticketm or top up first in menu in top right corner, after top up or buy ticket, you can see your transaction history in your user profile menu	
![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/f9952033-ef6e-48e8-9e9b-0c26b8748812)	

* you also can cancel the ticket if you not want watch it, you will 100% refund	
![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/211468a1-c983-499a-8514-cef542a71b2c)	

## How To Contribute	

this app is are already using service repository patter as the main architectur, you can look closely thats aare Service, Repository, and Controller folder in app module. ther than that it's the same as how to use laravel by default.	
