# Lubb - Your Digital Content Summary Hub 📚🎬🎧

<div align="center">

![Lubb Logo](public/images/logo.png)

[![Laravel](https://img.shields.io/badge/Laravel-v10.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v3.2-4299E1?style=for-the-badge)](https://filamentphp.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

</div>

## 🌟 About Lubb

Lubb is a sophisticated content summary platform that brings together concise summaries of audiobooks, movies, and podcasts in one elegant interface. Our platform is designed to help busy professionals, students, and knowledge enthusiasts quickly grasp the key insights from various media formats without spending hours consuming the full content.

## ✨ Key Features

### 📚 For Audiobooks
- Comprehensive chapter-by-chapter summaries
- Key takeaways and insights
- Author background and context
- Genre categorization and recommendations
- Reading time estimates

### 🎬 For Movies
- Plot summaries without spoilers
- Character analysis
- Themes and messages
- Director's perspective
- Critical reviews and ratings
- Genre classification

### 🎧 For Podcasts
- Episode summaries
- Main discussion points
- Guest speaker highlights
- Topic categorization
- Time-stamped key moments

## 🚀 Technology Stack

- **Backend Framework**: Laravel 10.x
- **Admin Panel**: Filament 3.2
- **Authentication**: Laravel Breeze & Socialite
- **Authorization**: Spatie Permissions
- **Database**: MySQL 8
- **Containerization**: Docker
- **Frontend**: Tailwind CSS, Alpine.js
- **Testing**: PHPUnit

## 🛠️ Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- Docker (optional)
- MySQL

### Local Setup

1. Clone the repository
```bash
git clone https://github.com/yourusername/lubb-filament.git
cd lubb-filament
```

2. Install PHP dependencies
```bash
composer install
```

3. Install NPM dependencies
```bash
npm install
```

4. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lubb
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

7. Start the development server
```bash
php artisan serve
npm run dev
```

### Docker Setup

1. Build and start containers
```bash
docker-compose up -d
```

2. Access the application container
```bash
docker-compose exec app bash
```

3. Follow steps 2-6 from Local Setup inside the container

## 👥 User Roles

- **Administrators**: Full access to manage content, users, and settings
- **Content Managers**: Create and edit summaries
- **Moderators**: Review and approve user submissions
- **Regular Users**: Access and interact with content

## 🔒 Security

- Robust authentication system
- Role-based access control
- Social media authentication (Google)
- API token authentication for mobile access
- Regular security updates

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📧 Contact

For support or queries, reach out to us at:
- Email: support@lubb.com
- Twitter: [@LubbApp](https://twitter.com/lubbapp)
- Website: [www.lubb.com](https://www.lubb.com)

## 👨‍💻 Author

- [@OuisAlhetar](https://github.com/OuisAlhetar)
- X: [@OuisAlhetar](https://x.com/ouis_alhetar?s=35)

## 🙏 Acknowledgments

- Laravel Team
- Filament Team
- All our contributors and supporters

---

<div align="center">
Made with ❤️ by the Lubb Team
</div>
