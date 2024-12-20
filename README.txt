# My Laravel and Vue.js Project

This repository contains a full-stack application using Laravel for the backend and Vue.js with Vite for the frontend together with PostgreSQL. The project is Dockerized for easy setup and deployment. It includes Mailhog, unit testing, and is setup and ready for GTM and Google Analytics 4 (cookies).


## Test it out first

The project is live under the following domain http://138.197.191.191
If you want to test it navigate to http://138.197.191.191:4173
Fill in the form and send your message. 
Refresh the page if you receive successful response to see all (old and new) contacts in the db. (click show button)
If you want to test the backend navigate to http://138.197.191.191:8000/api/contacts
You should receive something like this:
{"data":[
  {"id":7,"name":"TestUser","email":"test@test.com","subject":"Testing the form","message":"Hello world! We are live!!! :)","created_at":"2024-12-20T22:13:48.000000Z","updated_at":"2024-12-20T22:13:48.000000Z"},
  ...]}
If you want to see mailhog's interface navigate to http://138.197.191.191:8025/


## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [Node.js](https://nodejs.org/) (version 22 or higher)
- [npm](https://www.npmjs.com/) (version 10 or higher)
- [PHP](https://www.php.net/) (version 8.4 or higher)
- [Composer](https://getcomposer.org/) (version 2.8 or higher)
- [Laravel](composer global require laravel/installer) (version 5.11 or higher)
- [Docker](https://www.docker.com/) (@latest)
- [Docker Compose](https://docs.docker.com/compose/) (@latest)

## Getting Started

### Backend Setup

1. **Navigate to the backend directory:**
 
  cd backend

2. **Install PHP dependencies using Composer:**

  composer install
  
3. **Copy the example environment file and configure it:**

  cp .env.example .env
  
4. **Generate a new application key:**

  php artisan key:generate
  
5. **Run database migrations:**

  php artisan migrate
  
6. **Start the Laravel development server:**

  php artisan serve
  


### Frontend Setup

1. **Navigate to the frontend directory:**
 
  cd frontend

2. **Install Node.js dependencies using npm:**

  npm install
  
3. **Copy the example environment file and configure it:**

  cp .env.example .env.local 

4. **Start the Vite development server:**

  npm run dev



### Docker Setup

1. **Navigate to the root directory:**
 
  cd .. 

2. **Build and start the Docker containers:**
 
  docker-compose up --build
  

### Access the application:

  By default the backend will be available at http://localhost:8000
  By default the frontend will be available at http://localhost:3000

  Try sending a message with the contact form and refresh the page to see it


  
### Additional Information:

Mailhog: Mailhog is included in the Docker setup to catch outgoing emails. Access it at http://localhost:8025

Database: The Docker setup includes a PostgreSQL database. Configure the connection in the .env file.

By default the copied .env files should work when you run docker-compose up --build , however if any errors occur make sure the correct hostnames, ports, and credentials are specified for postgres and mailhog. Also check the frontend and backend urls.



If you want to run it LOCALLY you would need to have installed: 

 - PostgreSQL with its GUI 'pgAdmin4' (optional) and create a database with the name in your .env file. 
By default the port is 5432, but you could change that as well, just make sure that the .env and PostgreSQL are on the same port.
You can also use the default postgres user and just set a new password.
(also make sure the host env variable also matches your local db hostname, e.g. DB_HOST=127.0.0.1)

 - Mailhog configured to run on port 1025 for SMTP and port 8025 for HTTP. 
This is a good guide here for windows users: https://runcloud.io/blog/mailhog-email-testing

Otherwise, just comment out this part in the file located at './backend/app/Http/Controllers/ContactController.php': 
***
Mail::raw($validatedData['message'], function ($message) use ($validatedData) {
    $message->to('test@mailhog.local')
            ->subject($validatedData['subject'])
            ->from($validatedData['email'], $validatedData['name']);
});
***



*** Testing *** 
There are some test units in the backend directory for some of the routes.
In order to run them make sure you can connect to the db ,i.e. all .env variables are set correctly and execute the following script:

php artisan test

You should see that all tests are successful. If not something with the setup is incorrect.


*** Helpfull commands for PostgreSQL ***

Windows:
pg_ctl status -D "C:\Program Files\PostgreSQL\[version]\data"  -> checks the PostgreSQL process status
pg_ctl restart  -D "C:\Program Files\PostgreSQL\[version]\data"  -> restart the PostgreSQL process
pg_ctl.exe register -N "PostgreSQL" -U "NT AUTHORITY\NetworkService" -D "C:\Program Files\PostgreSQL\[version]\data" -w  -> creates a service to start on boot


Linux: 
pg_ctl status -D /var/lib/postgresql/[version]/main  -> checks the PostgreSQL process status
pg_ctl restart -D /var/lib/postgresql/[version]/main  -> restart the PostgreSQL process
pg_ctl start -D /var/lib/postgresql/[version]/main  -> start the PostgreSQL process
pg_ctl stop -D /var/lib/postgresql/[version]/main  -> stop the PostgreSQL process


*** GTM & GA4 *** 
If you want to connect your application to google services you need to create GTM account and GA4 account. Then copy each of the unique IDs and replace them in your frontend .env file.