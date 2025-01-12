# Laravel / Vue.js Project 
<div style="display: flex; justify-content: center; align-items: center;">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
  <a href="https://vuejs.org/" target="_blank">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKvAz8bSMDxZvg1ZjElGs285z3WDhxMySLcA&s" height="120" alt="Vue Logo">
  </a>
</div>
<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 0px">
  <a href="https://vite.dev/" target="_blank">
    <img src="https://de.vitejs.dev/logo-with-shadow.png" height="50" alt="Vite Logo">
  </a>
  <a href="https://www.postgresql.org/" target="_blank">
    <img src="https://www.unixmen.com/wp-content/uploads/2017/07/postgresql-logo.png" height="50" alt="postgresql Logo">
  </a>
  <a href="https://github.com/mailhog" target="_blank">
    <img src="https://avatars.githubusercontent.com/u/10258541?s=200&v=4" height="50" alt="mailhog Logo">
  </a>
  <a href="https://www.docker.com/ target="_blank">
    <img src="https://www.logo.wine/a/logo/Docker_(software)/Docker_(software)-Logo.wine.svg" height="100" alt="docker Logo">
  </a>
</div>

This repository contains a full-stack application using **Laravel** for the backend and **Vue.js with Vite** for the frontend together with **PostgreSQL**. The project is **Dockerized** for easy setup and deployment. It includes **Mailhog**, **unit testing**, and is set up and ready for **GTM and Google Analytics 4 (cookies)**.

---

## Test it out first

The project is live under the following domain: [http://138.197.191.191](http://138.197.191.191)  
- **Frontend**: [http://138.197.191.191:4173](http://138.197.191.191:4173)  
  - Fill in the form and send your message.  
  - Refresh the page if you receive a successful response to see all (old and new) contacts in the database (click **Show** button).  
- **Backend**: [http://138.197.191.191:8000/api/contacts](http://138.197.191.191:8000/api/contacts)  
  - You should receive a response like this:  
    ```json
    {
      "data": [
        {
          "id": 7,
          "name": "TestUser",
          "email": "test@test.com",
          "subject": "Testing the form",
          "message": "Hello world! We are live!!! :)",
          "created_at": "2024-12-20T22:13:48.000000Z",
          "updated_at": "2024-12-20T22:13:48.000000Z"
        },
        ...
      ]
    }
    ```
- **Mailhog**: [http://138.197.191.191:8025/](http://138.197.191.191:8025/)

---

## Prerequisites

Ensure you have the following installed on your machine:

- [Node.js](https://nodejs.org/) (version **22** or higher)
- [npm](https://www.npmjs.com/) (version **10** or higher)
- [PHP](https://www.php.net/) (version **8.4** or higher)
- [Composer](https://getcomposer.org/) (version **2.8** or higher)
- [Laravel](https://laravel.com/docs/installation) (version **5.11** or higher)
- [Docker](https://www.docker.com/) (latest version)
- [Docker Compose](https://docs.docker.com/compose/) (latest version)

---

## Getting Started

#### 1. Clone the repository in the folder of your choice:

```bash
git clone https://github.com/konnikamii/fullstack_app.git .
```

## Backend Setup

#### 1. Navigate to the backend directory:
 
```bash
cd backend
```

#### 2. Copy the example environment file and configure it:

```bash
cp .env.example .env
```
  
#### 3. Install PHP dependencies using Composer: (only if running locally)

```bash
composer install
```
  
#### 4. Generate a new application key: (only if running locally)

```bash
php artisan key:generate
```
  
#### 5. Run database migrations: (only if running locally)

```bash
php artisan migrate
```
  
#### 6. Start the Laravel development server: (only if running locally)

```bash
php artisan serve
```



## Frontend Setup

#### 1. Navigate to the frontend directory:
 
```bash
cd frontend
```

#### 2. Copy the example environment file and configure it:

```bash
cp .env.example .env.local 
```
  
#### 3. Install Node.js dependencies using npm: (only if running locally)

```bash
npm install
```

#### 4. Start the Vite development server: (only if running locally)

```bash
npm run dev
```



## Docker Setup

#### 1. Navigate to the root directory:
 
```bash
cd .. 
```

#### 2. Build and start the Docker containers:
 
```bash
docker-compose up --build
```
  
### Access the application:

By default:  
- The **frontend** will be available at [http://localhost:3000](http://localhost:3000)  
- The **backend** will be available at [http://localhost:8000](http://localhost:8000)  

Try sending a message with the contact form and refresh the page to see it.

---

### Additional Information:

- **Mailhog**:  
  Mailhog is included in the Docker setup to catch outgoing emails.  
  Access it at [http://localhost:8025](http://localhost:8025).

- **Database**:  
  The Docker setup includes a PostgreSQL database. Configure the connection in the `.env` file.  

By default, the copied `.env` files should work when you run `docker-compose up --build`.  
However, if any errors occur, ensure the correct hostnames, ports, and credentials are specified for PostgreSQL and Mailhog.  
Also, check the frontend and backend URLs.

---

### Running Locally Without Docker:

You need the following:

- **PostgreSQL**:  
  Install PostgreSQL with its GUI `pgAdmin4` (optional) and create a database matching the name in your `.env` file.  
  - Default port: `5432`  
  - Ensure the `.env` file and PostgreSQL are on the same port.  
  - You can use the default `postgres` user and set a new password.  
  - Ensure the host environment variable matches your local DB hostname (e.g., `DB_HOST=127.0.0.1`).

- **Mailhog**:  
  Install and configure Mailhog to run on the following ports:  
  - SMTP: `1025`  
  - HTTP: `8025`  

  [Here is a helpful guide for Windows users](https://runcloud.io/blog/mailhog-email-testing).

---

If Mailhog isn't configured or you don't want it in your setup you can just skip it. The backend will ignore it if there is no connection and will not throw an exception.



### Testing
There are some test units in the backend directory for some of the routes.
In order to run them make sure you can connect to the db ,i.e. all .env variables are set correctly and execute the following script:

```bash
php artisan test
```

You should see that all tests are successful. If not something with the setup is incorrect.


#### Helpfull commands for PostgreSQL 

**Windows:**
```bash
pg_ctl status -D "C:\Program Files\PostgreSQL\[version]\data"  # checks the PostgreSQL process status
pg_ctl restart  -D "C:\Program Files\PostgreSQL\[version]\data"  # restart the PostgreSQL process
pg_ctl.exe register -N "PostgreSQL" -U "NT AUTHORITY\NetworkService" -D "C:\Program Files\PostgreSQL\[version]\data" -w  # creates a service to start on boot
```


**Linux:**
```bash
pg_ctl status -D /var/lib/postgresql/[version]/main  # checks the PostgreSQL process status
pg_ctl restart -D /var/lib/postgresql/[version]/main  # restart the PostgreSQL process
pg_ctl start -D /var/lib/postgresql/[version]/main  # start the PostgreSQL process
pg_ctl stop -D /var/lib/postgresql/[version]/main  # stop the PostgreSQL process
```


####  GTM & GA4 
If you want to connect your application to google services you need to create GTM account and GA4 account. Then copy each of the unique IDs and replace them in your frontend .env file.

