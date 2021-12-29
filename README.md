## How to install ?

Firstly, you need to clone git repo. (Run it in your terminal)

<code>git clone https://github.com/meteoguzhan/beyn.git </code>

After clone project, you need to install packages. (Make sure your system exists composer)

<code>composer install </code>

You need to copy .env-example file and rename it as .env
Make sure you have a database to migrate which is described in .env file and exist in your database server.

<code> php artisan migrate </code>

You need to seed database with seeders.

<code> php artisan db:seed --class=ServiceSeeder </code>

Update the cache driver field in the .env file as follows
<pre>CACHE_DRIVER=redis</pre>

Update the redis information in the .env file as follows. redis connection info on your own server
<pre>REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379</pre>

You are ready to start server.

<code> php artisan serve </code>

Unit test run command.

<code> php artisan test </code>

Pull, build and update cars from API command

<code> php artisan v1:car:updateOrCreate </code>
