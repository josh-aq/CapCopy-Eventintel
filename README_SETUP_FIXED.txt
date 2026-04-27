EventIntel fixed package

IMPORTANT
Folder name in htdocs must match the folder you open in browser.
If your folder is C:\xampp\htdocs\EVENTINTELmayAPI, open:
http://localhost/EVENTINTELmayAPI/

Setup:
1. Copy/replace this folder into C:\xampp\htdocs\EVENTINTELmayAPI
2. Start Apache and MySQL in XAMPP.
3. Go to http://localhost/phpmyadmin
4. Import database/eventintel.sql into MySQL.
5. Open http://localhost/EVENTINTELmayAPI/

Demo accounts:
admin / password
client / password
supplier / password
coordinator / password

Fixes included:
- Removed login redirect loop.
- Login accepts secure hashed passwords, and upgrades old plain-text local passwords automatically after successful login.
- Admin verification works without missing rejection_reason column.
- Supplier pages are guarded by supplier role.
- Supplier/coordinator verification uses valid ID + business permit + live face capture for admin review.
- Database schema matches signup fields including age, barangay, postal_code, business docs, face capture.
