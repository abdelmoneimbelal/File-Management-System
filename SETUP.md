# Setup Instructions

## Required Steps to Run the System:

1. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

2. **Create Storage Link:**
   ```bash
   php artisan storage:link
   ```
   This command links `public/storage` with `storage/app/public` to access uploaded files.

3. **Create Default User (Seeder):**
   ```bash
   php artisan db:seed --class=UserSeeder
   ```
   Or run all seeders:
   ```bash
   php artisan db:seed
   ```
   
   **Default Login Credentials:**
   - Email: `admin@app.com`
   - Password: `admin@123`

4. **Using the System:**
   - Open browser and go to `/login`
   - Login using default credentials or create new account from `/register`
   - After login, you can upload files from `/files`
   - Search for files using the search field
   - Each file has a unique download link that can be shared

## Features:

✅ Secure authentication system
✅ File upload with date and time information
✅ File size display
✅ Unique download link for each file
✅ File search functionality
✅ Delete files
✅ Modern Bootstrap design
✅ **AJAX file upload with Progress Bar**
✅ **SweetAlert2 notifications**
✅ **Loading state during upload**
✅ **Responsive design**

