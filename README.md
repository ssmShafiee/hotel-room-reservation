# 🏨 Room Reservation System (Laravel)

A simple room reservation API built with **Laravel**, featuring temporary room booking, automatic expiration, and database locking to prevent double booking.

## 🚀 Features

- Create temporary room reservations (auto-expire after 2 minutes)
- Prevent double booking using database transactions and `lockForUpdate()`
- Automatic cleanup of expired reservations
- RESTful API endpoints (tested with Postman)
- Built with Repository & Service design patterns

---

## 🧩 API Endpoints

### 1️⃣ Reserve a Room
**POST** `/api/reserve`
json
{
  "room_id": 1
}

Responses

✅ 201 Created — Room reserved successfully

⚠️ 409 Conflict — Room is already reserved

❌ 422 Unprocessable Entity — Room not found or invalid request

2️⃣ List All Rooms

GET /api/rooms
Returns all rooms with is_reserved flag.

3️⃣ Expire Old Reservations

POST /api/expire
Marks all expired reservations as "expired".

🧱 Database Schema
Rooms
Column		Type		Description
id			bigint		Primary key
name		string		Room name
floor		string		Floor number
room_type	string		(single, double, family)
capacity	integer		Max guests
timestamps	-			Auto timestamps
Reservations
Column			Type			Description
id				bigint			Primary key
room_id			foreignId		Linked to room
reserved_at		datetime		Reservation start time
expires_at		datetime		Expiration time
status			enum			active / expired
timestamps	-	Auto timestamps
🧰 Installation
git clone https://github.com/ssmShafiee/hotel-room-reservation.git
cd room-reservation
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve

🧪 Tests

You can run unit and feature tests using:

php artisan test

🧑‍💻 Author

Somayeh Shafiee
📧 [sshafiee.88@gmail.com]
🌐 https://github.com/ssmShafiee