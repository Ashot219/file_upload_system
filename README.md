##Overview
This project allows users to upload PDF and DOCX files, manage them, and automatically delete files after 24 hours. Additionally, email notifications are sent upon file deletion via RabbitMQ.

##Requirements
PHP 8.x
Laravel 8.x
MySQL
RabbitMQ
Composer
Docker (Optional for containerization)
Installation
Clone the repository:

git clone <your-repository-url>
cd <project-folder>
Install dependencies: Run the following command to install the required dependencies: composer install

Set up environment variables: Copy .env.example to .env and update the database and RabbitMQ credentials:
cp .env.example .env

Generate application key: Generate the Laravel application key:
php artisan key:generate

Migrate database: Run the migration to create the required tables in the database: 
php artisan migrate

To create a new job, use the following Artisan command:
php artisan make:job JobName

To dispatch a job, you can use the dispatch method inside your controller or anywhere in the code:
JobName::dispatch($parameter);

To process queued jobs, you need to run the queue worker:
php artisan queue:work

You can schedule commands to run automatically. For example, to create a command that you want to schedule, use:
php artisan make:command CommandName


