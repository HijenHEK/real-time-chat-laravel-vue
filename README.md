# WhatsGood

## Real time chat app with Laravel and Vuejs

Real time chat app with Laravel and Vuejs that utilises [Laravel-websockets](https://github.com/beyondcode/laravel-websockets) &  [laravel-echo](https://www.npmjs.com/package/laravel-echo)

## Installation

- `git clone git@github.com:HijenHEK/real-time-chat-laravel-vue.git`
- `cd real-time-chat-laravel-vue`
- `cp .env.example .env` then add you database connection details
- `php artisan migrate` use `--seed` to get some seed users and some messages (./database/seeders/DatabaseSeeder.php)
- `npm install`
- `php artisan serve`
   
## features 

- real time chat
- friend request
- users search by username



