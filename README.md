Mini Shop (Seafood)

Setup:
1. Place project in your XAMPP `htdocs` folder.
2. Update database credentials in `db.php` if needed.
3. Create the database and import schema:

```sql
-- from MySQL client or phpMyAdmin
SOURCE mini_shop.sql;
```

4. Create an admin password hash on the server (CLI):

```bash
php hash_password.php YourAdminPassword
```

5. Edit `mini_shop.sql` and replace `REPLACE_WITH_HASH`, `REPLACE_WITH_HASH_USER1`, and `REPLACE_WITH_HASH_USER2` with generated hashes:

```bash
php hash_password.php AdminPasswordHere
php hash_password.php user1password
php hash_password.php user2password
```

Then import `mini_shop.sql` in your MySQL client or phpMyAdmin.
6. Ensure `images/` directory is writable by the web server for uploads.

Running:
- Open `http://localhost/mini-shop/` in your browser.

Notes:
- Sample accounts (after replacing hashes):
	- admin / (password you set for admin)
	- user1 / (password you set for user1)
	- user2 / (password you set for user2)

If you prefer, import the SQL first and then create users by running INSERT queries with generated password hashes.
