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
- [Key Features](#-key-features)
- [Tech Stack](#-tech-stack)
- [Installation and Usage](#-installation-and-usage)
- [File Structure](#-file-structure)
- [Contribution](#-contribution)
- [Screenshots](#-screenshots)
- [License](#-license)
- [Author](#-author)

---

## 📜 The Story Behind This Project

**Syaahi** (which means *ink* in Hindi) started as a college live project during my college time and has evolved into a beautifully designed, modern e-commerce web application. The goal was to build a fully functional online bookstore featuring a custom pastel/kawaii design system.

The project features a complete shopping experience from browsing manga and stationery to a fully functional shopping cart, secure checkout, order tracking, and even a built-in blogging platform for the community. The UI was heavily customized to be incredibly responsive, providing a native app-like experience on mobile devices with CSS-transformed card tables and elegant typography.

If you think it turned out cool, feel free to drop a **star ⭐** or **fork it 🍴**!

---

## 📌 Key Features

- 🛍️ **Full E-Commerce Flow:** Browse products, add to cart, adjust quantities, and place orders securely.
- 📱 **Mobile-First Responsiveness:** Features a custom CSS design system that transforms complex data tables into beautiful, stacked mobile cards.
- 🎨 **Pastel & Kawaii Aesthetic:** A soft, cozy UI utilizing custom Google Fonts ("WindSong", "Carter One", "Nunito") and beautiful SweetAlert2 popups.
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

### **2. Set up Environment Variables**
Copy the example environment file and configure your API keys:
```sh
cp .env.example .env
```
Open `.env` in your code editor and update the following:
- **Database:** Edit the database passwords if desired.
- **Stripe:** Add your Stripe Test Secret Key and Publishable Key for payments to work.
- **PHPMailer:** Add your Gmail address and an App Password for email verification/password resets to work.

### **3. Start the Application via Docker**
Run the following command to build the image and start the containers in the background:
```sh
docker-compose up -d --build
```

### **4. Access the Site**
Wait 10-15 seconds for the database to fully initialize on the first run, then visit:
- **Syaahi Website:** [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin (DB Manager):** [http://localhost:8081](http://localhost:8081)
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

## 🖥️ Screenshots

<details>
<summary><b>Click to view all 30 Screenshots! 📸</b></summary>

<div align="center">
  <table>
    <tr>
      <td align="center" rowspan="2">
        <img src="src/assets/img/screenshots/homepage.png" alt="HOMEPAGE" width="400">
        <br/>
        <em>HOMEPAGE</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/shop.png" alt="SHOP" width="400">
        <br/>
        <em>SHOP</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/about.png" alt="ABOUT" width="400">
        <br/>
        <em>ABOUT</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/product-detail.png" alt="PRODUCT DETAIL" width="400">
        <br/>
        <em>PRODUCT DETAIL</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/contact.png" alt="CONTACT" width="400">
        <br/>
        <em>CONTACT</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/blog-listing.png" alt="BLOG LISTING" width="400">
        <br/>
        <em>BLOG LISTING</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/blog-manage.png" alt="BLOG MANAGE" width="400">
        <br/>
        <em>BLOG MANAGE</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/blog-post.png" alt="BLOG POST" width="400">
        <br/>
        <em>BLOG POST</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/profile.png" alt="PROFILE" width="400">
        <br/>
        <em>PROFILE</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/wishlist.png" alt="WISHLIST" width="400">
        <br/>
        <em>WISHLIST</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/orders.png" alt="ORDERS" width="400">
        <br/>
        <em>ORDERS</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/cart.png" alt="CART" width="400">
        <br/>
        <em>CART</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/checkout.png" alt="CHECKOUT" width="400">
        <br/>
        <em>CHECKOUT</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-dashboard.png" alt="ADMIN DASHBOARD" width="400">
        <br/>
        <em>ADMIN DASHBOARD</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-admin.png" alt="ADMIN ADMIN" width="400">
        <br/>
        <em>ADMIN ADMIN</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-profile.png" alt="ADMIN PROFILE" width="400">
        <br/>
        <em>ADMIN PROFILE</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-editprofile.png" alt="ADMIN EDITPROFILE" width="400">
        <br/>
        <em>ADMIN EDITPROFILE</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-categories.png" alt="ADMIN CATEGORIES" width="400">
        <br/>
        <em>ADMIN CATEGORIES</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-add-categories.png" alt="ADMIN ADD CATEGORIES" width="400">
        <br/>
        <em>ADMIN ADD CATEGORIES</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-product.png" alt="ADMIN PRODUCT" width="400">
        <br/>
        <em>ADMIN PRODUCT</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-addproduct.png" alt="ADMIN ADDPRODUCT" width="400">
        <br/>
        <em>ADMIN ADDPRODUCT</em>
      </td>
    </tr>
    <tr>
    <td align="center">
        <img src="src/assets/img/screenshots/admin-comment.png" alt="ADMIN COMMENT" width="400">
        <br/>
        <em>ADMIN COMMENT</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-feedback.png" alt="ADMIN FEEDBACK" width="400">
        <br/>
        <em>ADMIN FEEDBACK</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/login.png" alt="LOGIN" width="400">
        <br/>
        <em>LOGIN</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/forgot-password.png" alt="FORGOT PASSWORD" width="400">
        <br/>
        <em>FORGOT PASSWORD</em>
      </td>
    </tr>
    <tr>
      <td align="center">
        <img src="src/assets/img/screenshots/register.png" alt="REGISTER" width="400">
        <br/>
        <em>REGISTER</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-login.png" alt="ADMIN LOGIN" width="400">
        <br/>
        <em>ADMIN LOGIN</em>
      </td>
    </tr>
    <tr>
      <td align="center" rowspan="2">
        <img src="src/assets/img/screenshots/change-password.png" alt="CHANGE PASSWORD" width="400">
        <br/>
        <em>CHANGE PASSWORD</em>
      </td>
      <td align="center">
        <img src="src/assets/img/screenshots/admin-categories-deltre-popup.png" alt="ADMIN CATEGORIES DELTRE POPUP" width="400">
        <br/>
        <em>ADMIN CATEGORIES DELTRE POPUP</em>
      </td>
    </tr>
    <tr>
      <td align="center" rowspan="2">
        <img src="src/assets/img/screenshots/delete-blog.png" alt="DELETE BLOG POPUP" width="300">
        <br/>
        <em>DELETE BLOG POPUP</em>
      </td>
    </tr>
  </table>
</div>

</details>

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
