ArtisanHub – Local Handicraft Marketplace
============================================

How to run (XAMPP):
1) Create database `artisanhub` in phpMyAdmin.
2) Import `init_db.sql` from this project.
3) Copy the `ArtisanHub` folder to `htdocs` (Windows: C:\xampp\htdocs).
4) Start Apache & MySQL in XAMPP Control Panel.
5) Open http://localhost/ArtisanHub in your browser.
6) Login as admin: first registered user becomes admin (ID=1).

Sample login after SQL import:
Email: demo@user.com
Password: 123456

Admin login page:
http://localhost/ArtisanHub/admin/admin_login.php
(Use the above credentials; after first login the user with ID=1 acts as admin)

Images:
- Add your product images under assets/images and save the file path in the product form.
- A placeholder image is already included.

Tech used: PHP (mysqli), MySQL, HTML, CSS, JS (vanilla).

Note: Orders table follows the spec (one product per row).
