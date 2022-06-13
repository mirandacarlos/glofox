# Requeriments
- Docker

# Installation
1. Clone the repository:
`git clone https://github.com/mirandacarlos/glofox.git`
2. Enter the project folder:
`cd glofox`
3. Configure environment:
`cp .env.example .env`
4. Install dependencies:
`docker run --rm -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest composer install`
5. Start docker containers:
`./vendor/bin/sail up -d`
6. Create database and test data:
`./vendor/bin/sail migrate --path database/migrations/glofox --seed` (--seed is optional, it creates 5 classes and 5 bookings)
7. You can run the seed separately running:
`./vendor/bin/sail db:seed`

# Seeders
If you want to create more test data you can use seeders to generate it by running:
`./vendor/bin/sail db:seed --class ClassName`
Available ClassNames:
- **LessonsSeeder**: creates 5 classes.
- **BookingsSeeder**: create 5 bookings (if there are no classes it will create one)
- **LessonsWithBookingsSeeder**: creates 1 class with 1 booking, 1 class with 3 bookings and 1 class with 5 bookings .

# Endpoints
## Classes
`/api/classes`
### Available attributes:
**name**: string
**start**: date
**end**: date
**capacity**: integer
## Bookings
`/api/bookings`
### Available attributes:
**member_name**: string
**date**: date
**lesson_id**: integer (class id)

# Tests
To run tests execute the following command:
`./vendor/bin/sail tests`