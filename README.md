# Syaahi (स्याही)

**Syaahi** (meaning *ink* in Hindi) is a book & stationery e-commerce platform built with PHP, Bootstrap, and MariaDB. Originally developed as a college live project, it features a full shopping experience with product browsing, shopping cart, checkout, wishlists, a blog, and an admin panel.

## Features

- **Shop** — Browse books, notebooks, art supplies, pens & stationery
- **Product Details** — View detailed product info, ratings, and reviews
- **Shopping Cart** — Add items, adjust quantities, and checkout
- **Orders** — Track your order history
- **Wishlist** — Save products for later
- **Blog** — Read and create blog posts
- **User Accounts** — Register, login, manage your profile
- **Contact Form** — Send feedback and inquiries
- **Admin Panel** — Manage products, users, categories, and content

## Tech Stack

| Component | Technology |
|-----------|------------|
| Frontend | HTML5, CSS3, Bootstrap 5, jQuery |
| Backend | PHP 8.2 |
| Database | MariaDB 10.11 |
| Web Server | Apache (via Docker) |
| Dev Tools | Docker, Docker Compose, phpMyAdmin |

## Quick Start

### Prerequisites
- [Docker](https://docs.docker.com/get-docker/) (v20+)
- [Docker Compose](https://docs.docker.com/compose/install/) (v2+)

### Setup

1. **Clone the project** and navigate to the directory:
   ```bash
   cd syaahi
   ```

2. **Copy the environment file:**
   ```bash
   cp .env.example .env
   ```
   Edit `.env` if you want to change default credentials.

3. **Start the containers:**
   ```bash
   docker-compose up -d --build
   ```

4. **Access the application:**

   | Service | URL |
   |---------|-----|
   | Syaahi Website | [http://localhost:8080](http://localhost:8080) |
   | phpMyAdmin | [http://localhost:8081](http://localhost:8081) |
   | Admin Panel | [http://localhost:8080/admin/](http://localhost:8080/admin/) |

5. **Stop the containers:**
   ```bash
   docker-compose down
   ```
   To also remove the database volume: `docker-compose down -v`

## Project Structure

```
syaahi/
├── docker-compose.yml      # Docker services configuration
├── Dockerfile              # Custom PHP+Apache image
├── .env                    # Environment variables (gitignored)
├── .env.example            # Environment template
├── README.md               # This file
├── CREDENTIALS.md          # Demo login credentials
├── db/
│   └── init.sql            # Database schema & seed data
└── src/                    # PHP source code
    ├── index.php           # Home page
    ├── includes/           # Shared components (config, db, navbar, footer)
    ├── pages/              # Page views (shop, cart, login, etc.)
    ├── api/                # Form handlers & AJAX endpoints
    ├── admin/              # Admin panel
    ├── assets/             # CSS, JS, images, webfonts
    └── uploads/            # User-uploaded files
```

## Default Credentials

See [CREDENTIALS.md](CREDENTIALS.md) for all demo login details.

## License

This project was developed as a college assignment. All rights reserved.
