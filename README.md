# Films Task

### Stack
- Backend: Laravel 
- Frontend: VueJS & Blade

### Postman Collection
- [URL](https://github.com/GMT95/films-task/blob/main/Films.postman_collection.json).

### Backend Tasks:
- Films APIs (Get List, Get One, Add, Update, Delete)
- Add comments API (Auth Required)
- Authentication APIs (Login, Register, Logout)
- Users, Genre and Films Seeder with Comment
- Feature and Unit Tests

### Frontend Tasks:
- List Films Page
- Single Film Page
- Add Comment on Single Film Page
- Create Film Page
- Register Page
- Login Page

### Running the Project
1. Clone this repository
2. Copy `.env.example` to `.env` and change the Database Settings in `.env`
3. `cd` into the project folder
4. Into the project directory execute the following commands:
    - `composer install` to install php dependencies
    - `npm install` to install js dependencies
    - `php artisan migrate` to migrate the tables
    - `php artisan db:seed` to seed data
5. Into the project directory run the following command:
    - `php artisan serve` to start laravel application
6. Open new terminal instance, `cd` to project folder and run the following command:
    - `npm run dev` to start vite server for vuejs
7. Open project in browser or test APIs through Postman by importing the collection
8. Project must be running on `localhost:8000` or any other specified port
9. Running Tests: `php artisan test`
