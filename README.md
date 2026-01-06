# 📁 File Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/github/license/abdelmoneimbelal/File-Management-System?style=for-the-badge" alt="License">
  <img src="https://img.shields.io/github/stars/abdelmoneimbelal/File-Management-System?style=for-the-badge" alt="Stars">
</p>

<p align="center">
  <a href="https://github.com/abdelmoneimbelal/File-Management-System">View Demo</a> •
  <a href="https://github.com/abdelmoneimbelal/File-Management-System/issues">Report Bug</a> •
  <a href="https://github.com/abdelmoneimbelal/File-Management-System/issues">Request Feature</a>
</p>

A modern, secure, and feature-rich file management system built with Laravel. Upload, manage, preview, and share files with unique download links, all wrapped in a beautiful Bootstrap 5 interface.

## ✨ Features

### 🔐 Authentication & Security
- **Secure User Authentication** - Registration and login system
- **Protected File Access** - Files are only accessible to their owners
- **Unique Download Tokens** - Each file gets a unique shareable link
- **Session Management** - Secure session handling with CSRF protection

### 📤 File Upload
- **AJAX Upload** - Smooth file upload without page refresh
- **Real-time Progress Bar** - Visual feedback during upload
- **File Size Validation** - Maximum 10MB per file
- **Multiple File Types** - Support for images, PDFs, videos, audio, documents, and more

### 👁️ File Preview
- **Images** - PNG, JPG, JPEG, GIF, WebP, SVG
- **PDFs** - Inline PDF viewer with navigation
- **Videos** - MP4, WebM, OGG with built-in player
- **Audio** - MP3, WAV, OGG with controls
- **Text Files** - TXT, JSON, XML, HTML, CSS, JS with syntax highlighting
- **Office Files** - Indication for Word, Excel, PowerPoint files

### 🎨 Modern UI/UX
- **Bootstrap 5** - Modern and responsive design
- **SweetAlert2 Toasts** - Beautiful notification system
- **Bootstrap Icons** - Clean and professional icons
- **Gradient Design** - Eye-catching color schemes
- **Mobile Responsive** - Works perfectly on all devices

### 🔍 File Management
- **Search Functionality** - Quickly find files by name
- **File Information Display** - Name, size, date, time, and day
- **Copy Download Link** - One-click link copying with toast notification
- **Delete Files** - Secure file deletion with confirmation
- **Pagination** - Browse through large file collections easily

## 🚀 Quick Start

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL or MariaDB
- Node.js & NPM (for asset compilation)
- Laragon/XAMPP/WAMP (for local development)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/abdelmoneimbelal/File-Management-System.git
   cd File-Management-System
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Seed Default User (Optional)**
   ```bash
   php artisan db:seed --class=UserSeeder
   ```
   
   Default credentials:
   - Email: `admin@app.com`
   - Password: `admin@123`

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

10. **Compile Assets (Optional)**
    ```bash
    npm run dev
    # or for production
    npm run build
    ```

11. **Access the Application**
    
    Open your browser and navigate to:
    ```
    http://localhost:8000
    ```

## 📖 Usage

### Register/Login
1. Navigate to `/register` to create a new account
2. Or use the seeded credentials to login at `/login`

### Upload Files
1. After login, click **"Upload New File"** button
2. Select your file (max 10MB)
3. Watch the progress bar as it uploads
4. Get instant success notification
5. File appears in your file list with unique download link

### Preview Files
1. Click the **eye icon** (👁️) next to any file
2. View supported files directly in the modal
3. For unsupported types, download to view

### Manage Files
- **Search**: Use the search bar to find files by name
- **Copy Link**: Click the clipboard icon to copy download link
- **Download**: Click download button to get the file
- **Delete**: Remove files you no longer need (with confirmation)

## 🛠️ Technology Stack

- **Backend Framework**: [Laravel 12](https://laravel.com)
- **Frontend Framework**: [Bootstrap 5.3](https://getbootstrap.com)
- **JavaScript**: Vanilla JS with AJAX
- **Icons**: [Bootstrap Icons](https://icons.getbootstrap.com)
- **Notifications**: [SweetAlert2](https://sweetalert2.github.io)
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel's built-in authentication

## 📂 Project Structure

```
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   ├── LoginController.php
│   │       │   └── RegisterController.php
│   │       └── FileController.php
│   └── Models/
│       ├── File.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   └── create_files_table.php
│   └── seeders/
│       └── UserSeeder.php
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── files/
│       │   ├── index.blade.php
│       │   └── upload.blade.php
│       └── layouts/
│           └── app.blade.php
├── routes/
│   └── web.php
└── storage/
    └── app/
        └── public/
            └── uploads/
```

## 🎯 Key Features Explained

### File Preview System
The system intelligently detects file types and displays them appropriately:
- Images are shown with full resolution
- PDFs are embedded with iframe
- Videos and audio have native HTML5 players
- Text files show with proper formatting
- Unsupported types show informative message

### Security Features
- All file operations require authentication
- Users can only access their own files
- Download links use unique tokens instead of file IDs
- CSRF protection on all forms
- SQL injection protection via Eloquent ORM

### AJAX Upload with Progress
- Real-time upload progress tracking
- No page refresh needed
- Error handling with user-friendly messages
- Loading states for better UX

## 🎨 Customization

### Change Color Scheme
Edit the CSS variables in `resources/views/layouts/app.blade.php`:
```css
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --secondary-color: #8b5cf6;
}
```

### Modify File Size Limit
Update in `app/Http/Controllers/FileController.php`:
```php
'file' => 'required|file|max:10240', // Change 10240 (10MB)
```

## 📝 Database Schema

### Files Table
- `id` - Primary key
- `user_id` - Foreign key to users
- `original_name` - Original file name
- `file_name` - Stored file name
- `file_path` - Storage path
- `mime_type` - File MIME type
- `file_size` - Size in bytes
- `download_token` - Unique download token
- `created_at` - Upload timestamp
- `updated_at` - Last update timestamp

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🔗 Links

- **GitHub Repository**: [https://github.com/abdelmoneimbelal/File-Management-System](https://github.com/abdelmoneimbelal/File-Management-System)
- **Report Issues**: [GitHub Issues](https://github.com/abdelmoneimbelal/File-Management-System/issues)

## 👨‍💻 Author

**Abdelmoneim Belal**

- GitHub: [@abdelmoneimbelal](https://github.com/abdelmoneimbelal)
- Repository: [File-Management-System](https://github.com/abdelmoneimbelal/File-Management-System)

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com)
- [Bootstrap Team](https://getbootstrap.com)
- [SweetAlert2](https://sweetalert2.github.io)
- [Bootstrap Icons](https://icons.getbootstrap.com)
- All contributors

## 📞 Support

If you have any questions or need help, please:
- Open an [issue](https://github.com/abdelmoneimbelal/File-Management-System/issues)
- Check the [documentation](https://github.com/abdelmoneimbelal/File-Management-System#readme)

## ⭐ Show your support

Give a ⭐️ if this project helped you!

---

<p align="center">
  Made with ❤️ and Laravel by <a href="https://github.com/abdelmoneimbelal">Abdelmoneim Belal</a>
</p>
