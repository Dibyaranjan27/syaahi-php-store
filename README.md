<h1 align="center">🌸 Syaahi E-Commerce 📚</h1>

<p align="center">
  A cozy, pastel-themed, fully responsive e-commerce platform for books, manga, and aesthetic stationery.
</p>

<div align="center">
  <img src="https://img.shields.io/badge/PHP-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Bootstrap-%237952B3.svg?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap"/>
  <img src="https://img.shields.io/badge/Docker-%232496ED.svg?style=for-the-badge&logo=docker&logoColor=white" alt="Docker"/>
</div>

---

## 📖 Table of Contents
- [The Story Behind This Project](#-the-story-behind-this-project)
- [Screenshots](#-screenshots)
- [Key Features](#-key-features)
- [Tech Stack](#-tech-stack)
- [Installation and Usage](#-installation-and-usage)
- [File Structure](#-file-structure)
- [Contribution](#-contribution)
- [License](#-license)
- [Author](#-author)

---

## 📜 The Story Behind This Project

**Syaahi** (which means *ink* in Hindi) started as a college live project and has evolved into a beautifully designed, modern e-commerce web application. The goal was to build a fully functional online bookstore featuring a custom pastel/kawaii design system.

The project features a complete shopping experience from browsing manga and stationery to a fully functional shopping cart, secure checkout, order tracking, and even a built-in blogging platform for the community. The UI was heavily customized to be incredibly responsive, providing a native app-like experience on mobile devices with CSS-transformed card tables and elegant typography.

If you think it turned out cool, feel free to drop a **star ⭐** or **fork it 🍴**!

---

## 🖥️ Screenshots

*(Replace the placeholder URLs with actual screenshots of your site!)*
<div align="center">
  <table>
    <tr>
      <td align="center">
        <img src="https://via.placeholder.com/400x250?text=Home+Page" alt="Home Page" width="400">
        <br/>
        <em>Home Page</em>
      </td>
      <td align="center">
        <img src="https://via.placeholder.com/400x250?text=Shop+Page" alt="Shop Page" width="400">
        <br/>
        <em>Shop Page</em>
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2">
        <img src="https://via.placeholder.com/400x250?text=Mobile+Cart" alt="Mobile Cart" width="400">
        <br/>
        <em>Responsive Mobile Cart</em>
      </td>
    </tr>
  </table>
</div>

---

## 📌 Key Features

- 🛍️ **Full E-Commerce Flow:** Browse products, add to cart, adjust quantities, and place orders securely.
- 📱 **Mobile-First Responsiveness:** Features a custom CSS design system that transforms complex data tables into beautiful, stacked mobile cards.
- 🎨 **Pastel & Kawaii Aesthetic:** A soft, cozy UI utilizing custom Google Fonts (\WindSong\, \Carter One\, \Nunito\) and beautiful SweetAlert2 popups.
- 💜 **User Profiles & Wishlists:** Create accounts to track order history, save favorite items, and write product reviews.
- ✍️ **Built-in Blog:** Share your thoughts, read community stories, and manage your own posts.
- ⚙️ **Admin Dashboard:** A complete backend interface for managing users, categories, and inventory.

---

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap 4, jQuery, SweetAlert2
- **Backend:** PHP 8.2
- **Database:** MariaDB (MySQL) 10.11
- **Environment:** Docker & Docker Compose

---

## 🚀 Installation and Usage

This project is completely Dockerized, making it incredibly easy to spin up the entire application and database locally in seconds!

### **1. Clone the Repository**
```sh
git clone https://github.com/Dibyaranjan27/syaahi-php-store.git
cd syaahi-php-store
```

### **2. Set up Environment**
```sh
cp .env.example .env
```
*(You can edit the `.env` file if you wish to change the default database credentials).*

### **3. Start the Application**
```sh
docker-compose up -d --build
```

### **4. Access the Site**
- **Syaahi Website:** [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin:** [http://localhost:8081](http://localhost:8081)
- **Admin Panel:** [http://localhost:8080/admin/](http://localhost:8080/admin/)

*(See `CREDENTIALS.md` for default demo accounts!)*

---

## 📂 File Structure

```text
/syaahi-php-store
│
├── docker-compose.yml      # Docker services configuration
├── Dockerfile              # Custom PHP+Apache image
├── db/                     # Database initialization scripts (init.sql)
├── src/                    # The main PHP source code
│   ├── index.php           # Home page
│   ├── includes/           # Shared components (config, db, navbar, footer)
│   ├── pages/              # Page views (shop, cart, login, etc.)
│   ├── api/                # Form handlers & AJAX endpoints
│   ├── admin/              # Admin dashboard panel
│   └── assets/             # CSS, JS, images, webfonts
├── CREDENTIALS.md          # Demo login details
└── README.md               # This file
```

---

## 🤝 Contribution

Feel free to contribute to this project! Fork the repository, make your improvements, and submit a pull request. All contributions are welcome.

If you have any questions or suggestions, feel free to contact me. I'd be happy to help! 😊

---

## 📜 License

This project is open-source and available under the MIT License.

---

## 💡 Author

<p align="center">
<em>Crafted with pixels & passion by</em>
<br>
<strong>Dibyaranjan Maharana</strong>
<br>
<a href="https://github.com/Dibyaranjan27">GitHub</a> | <a href="https://www.linkedin.com/in/dibyaranjan-maharana-1228012b2/">LinkedIn</a>
</p>
