EventIntel PHP/MySQL Setup

MERGE INSTRUCTIONS:
1. Extract eventintel_FULL_PART1.zip into C:\xampp\htdocs
2. Extract eventintel_FULL_PART2.zip into C:\xampp\htdocs
   Both ZIPs contain the same eventintel/ root folder. Let Windows merge folders.

DATABASE:
1. Start XAMPP Apache and MySQL.
2. Open phpMyAdmin.
3. Import: eventintel/database/eventintel.sql

OPEN:
http://localhost/eventintel/

Demo accounts:
admin / password
client / password
supplier / password
coordinator / password

Important:
- Your original HTML/CSS files are preserved.
- PHP versions were added for working backend flow.
- OpenAI API is optional. Put your key in environment variable OPENAI_API_KEY or config/db.php.
- GPS uses Google Maps links/embed and browser geolocation.
- Face scan is used during Supplier/Coordinator registration for admin verification against uploaded ID.
- RSVP invitation design is editable per event.
