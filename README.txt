# My Laravel and Vue.js Project

This repository contains a full-stack application using Laravel for the backend and Vue.js with Vite for the frontend. The project is Dockerized for easy setup and deployment.

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [Node.js](https://nodejs.org/) (version 22 or higher)
- [npm](https://www.npmjs.com/) (version 10 or higher)
- [PHP](https://www.php.net/) (version 8.4 or higher)
- [Composer](https://getcomposer.org/) (version 2.8 or higher)
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
  
3. **Start the Vite development server:**

  npm run dev


### Docker Setup

1. **Navigate to the root directory:**
 
  cd .. 

2. **Build and start the Docker containers:**
 
  docker-compose up --build
  

### Access the application:

  By default the backend will be available at http://localhost:8000
  By default the frontend will be available at http://localhost:3000

  Try sending a sending a message with the contact form and refresh the page to see it available


  
### Additional Information:

Mailhog: Mailhog is included in the Docker setup to catch outgoing emails. Access it at http://localhost:8025

Database: The Docker setup includes a PostgreSQL database. Configure the connection in the .env file.



If you want to run it LOCALLY you would need to have installed: 

 - PostgreSQL with its GUI pgAdmin4 (optional) and create a database with the name in your .env file. 
By default the port is 5432 but you could change that as well, just make sure but the .env and PostgreSQL are on the same port.
You can also use the default postgres user and just set a new password.

 - Mailhog configured to run on port 1025 for SMTP and port 8025 for HTTP. 
This is a good guide here for windows users: https://runcloud.io/blog/mailhog-email-testing





