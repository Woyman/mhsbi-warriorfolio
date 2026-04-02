<p align="center">
  <h1 align="center">Warriorfolio 2 · Custom fork</h1>
  <p align="center">A Modern Portfolio & Blog Platform Built with Laravel</p>
  <p align="center"><sub>Fork of <a href="https://github.com/mviniciusca/warriorfolio">mviniciusca/warriorfolio</a> — customized for personal needs.</sub></p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Filament-3.x-FFAA00?style=flat" alt="Filament">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

<p align="center">
  <img src="https://raw.githubusercontent.com/mviniciusca/warriorfolio/main/public/img/core/demo/featured.png" alt="Warriorfolio 2 Preview">
</p>

---

## Introduction

Warriorfolio is a powerful, modular portfolio and blog platform that empowers users to create personalized, professional websites with ease. Built on Laravel's robust foundation, it combines flexibility with user-friendly administration.

**Repositori ini** adalah clone/fork dari [Warriorfolio](https://github.com/mviniciusca/warriorfolio) (MIT) yang disesuaikan untuk kebutuhan pengembangan pribadi. Fitur inti dan arsitektur mengikuti upstream; dokumentasi resmi tetap relevan untuk hal yang tidak diubah di sini — lihat [Warriorfolio documentation](https://warriorfolio.vercel.app/).

**Key Highlights:**
- **Modular Architecture** - Components integrate seamlessly like building blocks
- **No-Code Management** - 100% managed through an intuitive Control Panel
- **Flexible Deployment** - From simple landing pages to complex multi-page sites
- **Professional Results** - Perfect for developers, designers, and creative professionals

---

## Customizations in this fork

Perubahan pada versi fork ini dibanding upstream:

| Area | Perubahan |
|------|-----------|
| **Profile** | Section baru **Experience** — menampilkan pengalaman kerja/profesional di area profil (themes yang mendukung partial Experience). |

Untuk riwayat rilis resmi Warriorfolio (Juno, gallery, search, dll.), lihat [Upstream releases](https://github.com/mviniciusca/warriorfolio/releases).

---

## Features

### Content Management
- Blog system with password protection and reading time
- Portfolio/Projects with categories, tags, and SEO optimization
- Page builder with modular content blocks
- Newsletter subscription integration
- Advanced search and filtering

### User Interface
- **Saturn UI** - Modern, responsive design system
- Multiple themes (Default, Juno)
- Dark/Light mode with inverse theme support
- Browser mockup component for project showcases
- Customizable hero sections with multiple layouts

### Professional Tools
- **Experience (fork)** — section pengalaman di profil, selaras dengan data resume/kontrol panel
- Resume/CV management and download
- LinkedIn "Open to Work" badge integration
- Skills and certifications display
- Course tracking
- Customer/Client showcase
- Social media integration

### Admin Panel
- Intuitive Filament-powered dashboard
- Real-time notifications and alerts
- Analytics integration (Google Analytics)
- Contact form with reCAPTCHA v2
- WhatsApp integration
- Email inbox management

### Developer Features
- Modular component architecture
- Maintenance and Discovery modes
- SEO-friendly URLs and meta tags
- Query optimization for performance
- Comprehensive documentation
- Module visibility controls

---

## Installation

### This repository (fork)

```bash
git clone https://github.com/Woyman/mhsbi-warriorfolio.git
cd mhsbi-warriorfolio
```

Lanjutkan dari langkah **Install dependencies** di bawah (sama seperti upstream).

### Upstream (official Warriorfolio) via Composer

Jika ingin proyek vanilla tanpa kustomisasi fork ini:

```bash
composer create-project mviniciusca/warriorfolio
cd warriorfolio
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
php artisan serve
```

### Manual Installation (same steps after clone)

```bash
# After cloning this fork or upstream
cd mhsbi-warriorfolio   # or: warriorfolio

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate
php artisan storage:link

# Setup database
php artisan migrate:fresh --seed

# Start development servers
php artisan serve

# In a new terminal
npm run dev
```

---

## System Requirements

**Server Requirements:**
- PHP 8.2 or higher
- PHP Extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo, GD, Zip
- Database: MySQL 5.7+, PostgreSQL 10+, or SQLite 3.8+
- Composer 2.0 or higher
- Node.js 18+ and NPM 10.2+

**Recommended:**
- PHP 8.3+
- MySQL 8.0+ or PostgreSQL 14+
- Redis for caching and sessions

---

## Advanced Features

### Content Blocks
The application provides versatile code blocks and structural components that enable countless customization possibilities. Components are organized into three categories:
- **Components** - Reusable UI elements
- **Design** - Layout and styling options
- **Core** - Fundamental system modules

### Maintenance Mode
Enable maintenance mode while keeping essential features active:
- Contact form accessibility
- Social media links
- Custom maintenance message

### Discovery Mode
Preview your application during maintenance:
- Visible only to administrators
- Visual indicator banner
- Test changes before going live

### Module Management
Customize which core modules appear on your site:
- Header & Navigation
- Hero Section
- About Section
- Projects/Portfolio
- Customers/Clients
- Contact Form
- Newsletter
- Footer

---

## Documentation

Comprehensive documentation is available at [warriorfolio.vercel.app](https://warriorfolio.vercel.app/)

**Topics covered:**
- Installation and configuration
- Module customization
- Theme development
- Component usage
- API integration
- Deployment guides

---

## Technology Stack

Warriorfolio is built with industry-leading technologies:

| Technology | Purpose | Creator |
|------------|---------|---------|
| **Laravel** | PHP Framework | Taylor Otwell |
| **Filament** | Admin Panel Toolkit | Dan Harrin, Zep Fietje & Community |
| **Livewire** | Real-time Components | Caleb Porzio |
| **Tailwind CSS** | Utility-first CSS | Adam Wathan |
| **Alpine.js** | JavaScript Framework | Caleb Porzio |

---

## Contributing

Untuk perbaikan bug dan fitur **inti Warriorfolio**, pertimbangkan berkontribusi ke [repositori upstream](https://github.com/mviniciusca/warriorfolio). Fork pribadi ini mengikuti alur kontribusi umum di bawah untuk eksperimen lokal.

We welcome contributions from the community! Here's how you can help:

### Reporting Issues
- Use GitHub Issues for bug reports
- Include steps to reproduce
- Provide environment details
- Add screenshots if applicable

### Pull Requests
- Fork the repository
- Create a feature branch
- Follow PSR-12 coding standards
- Write descriptive commit messages
- Update documentation as needed

### Feature Requests
- Open a discussion on GitHub
- Describe the use case
- Explain the expected behavior

---

## Security

If you discover a security vulnerability, please email security contact privately. Do not open public issues for security concerns.

---

## License

Warriorfolio is open-source software licensed under the [MIT license](LICENSE).

---

## Acknowledgments

**Upstream:** Proyek ini berbasis [**Warriorfolio**](https://github.com/mviniciusca/warriorfolio) oleh [Marcos Coelho](https://twitter.com/marcosvca_) — terima kasih kepada maintainer dan komunitas atas karya sumber terbukanya.

**Special Thanks (upstream):**
- Warriorfolio 1 users and early adopters
- All contributors and community members
- Taylor Otwell and the Laravel team
- Dan Harrin, Zep Fietje, and the Filament team
- Caleb Porzio for Livewire and Alpine.js
- The entire PHP and Laravel community

---

## Support

- **Documentation (upstream):** [warriorfolio.vercel.app](https://warriorfolio.vercel.app/)
- **Fork (this repo):** [Woyman/mhsbi-warriorfolio](https://github.com/Woyman/mhsbi-warriorfolio)
- **Upstream issues / discussions:** [Issues](https://github.com/mviniciusca/warriorfolio/issues) · [Discussions](https://github.com/mviniciusca/warriorfolio/discussions)
- **Twitter (upstream author):** [@marcosvca_](https://twitter.com/marcosvca_)

---

<p align="center">
  <strong>Upstream: <a href="https://github.com/mviniciusca/warriorfolio">Warriorfolio</a> by <a href="https://twitter.com/marcosvca_">Marcos Coelho</a></strong><br>
  <sub>Fork ini menyertakan kustomisasi lokal; lisensi tetap mengikuti <a href="LICENSE">MIT</a> dari proyek dasar.</sub>
</p>

