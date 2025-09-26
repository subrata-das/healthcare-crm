
## Healthcare CRM – Laravel Assessment Project

This project is a simplified Healthcare CRM system built with Laravel. It is part of an assessment to evaluate proficiency in:
- Laravel backend development
- Database schema design
- API creation
- Security implementation (including role-based access control)



## Project Structure

This Laravel project includes:
✅ User authentication using Laravel Sanctum
✅ Role-based access control (Admin, Doctor, Staff)
✅ CRUD operations for core models (e.g., Patients)
✅ Auditing and logging for key operations
✅ RESTful API endpoints
✅ Database migrations & seeders
✅ Azure deployment readiness




## Requirements

- PHP >= 8.1
- Composer
- MySQL or Azure Database for MySQL
- Laravel = 10.x
- Node.js >= 18.x




## Installation

1. Clone the repository
```
git clone https://github.com/subrata-das/healthcare-crm.git
cd healthcare-crm
```

2. Install dependencies
```
composer install
npm install && npm run dev  # if using frontend assets
```

3. Configure environment

Copy .env.example to .env:
```
cp .env.example .env
```
Update the following in .env:
```
APP_NAME=HealthcareCRM
APP_URL=http://localhost
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

```

4. Run migrations and seeders
```
php artisan migrate --seed
```

5. Serve the app
```
php artisan serve
```




## Project Url

The application will be available at http://localhost:8000 or http://127.0.0.1:8000


## Api Documentation

Postman document available at https://documenter.getpostman.com/view/12811736/2sB3QDvD8A


** Before scheduling an appointment, please ensure that the 'Update Profession Details' section in the doctor's profile is completed after logging in.