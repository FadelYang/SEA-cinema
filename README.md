![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/f593d44a-3378-4639-a41f-b8c4e6ff1cd3)

# Laravel Compfest Movie App
## A Web App About Movie Ticketing

This my submission for Compfest 15 Software Engineering Academy, this website is build with Laravel 9 and Bootstrap 5. you can login, top up some balance, and buy movies ticket with thats balances. make sure you have enough balance before buy the ticket. or you can just top up the balance as much as you want.

this web app is build with
* laravel 9
* Bootstrap 5
* Mysql
* Apache

## Getting Started

make sure u have
* laravel 8 or above (this is minimum requirement for Laravel 9)
* Composer
* git
* mysql & apache (or simply just use XAMPP)
* npm 7.*

## How To Install

1. clone this repository with 'git clone'
2. run 'composer install'
3. copy .env.example, paste it, and rename it with .env
4. run 'php artisan key:generate'
5. configure your .env file, change the database name by your new database
6. run 'php artisan migrate'
7. run 'npm install && npm run dev'
 
## Example How To Use It (The App)
* this is the home page, as an ordinary user, you can only see the list of movie and the detail movie
![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/5d695f9f-9445-4778-bf3e-c7d68a860f04)

* you can create an account by click register menu and fill the information needed

* after create an account, you can try buy a ticketm or top up first in menu in top right corner, after top up or buy ticket, you can see your transaction history in your user profile menu
![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/f9952033-ef6e-48e8-9e9b-0c26b8748812)

* you also can cancel the ticket if you not want watch it, you will 100% refund
![image](https://github.com/FadelYang/SEA-cinema/assets/75234524/211468a1-c983-499a-8514-cef542a71b2c)

## How To Contribute

this app is are already using service repository patter as the main architectur, you can look closely thats aare Service, Repository, and Controller folder in app module. ther than that it's the same as how to use laravel by default.
