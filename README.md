# 📝 Blog Web Application

> **A full-stack PHP blogging platform featuring dual-layered dashboards, secure authentication, and Role-Based Access Control (RBAC).**

This project demonstrates a complete implementation of the **MVC (Model-View-Controller)** logic using native PHP. It provides a structured environment for users to share content and for administrators to maintain platform integrity through a dedicated management suite.

---

## 📌 System Architecture & Logic

The application utilizes a centralized MySQL database to manage three core entities: **Users, Admins, and Posts**.



```text
       [ Web Browser (Client) ]
                 |
        /--------+--------\
        |                 |
 [ User Portal ]   [ Admin Portal ]
 (Login/Register)   (Secure Login)
        |                 |
        v                 v
 [ Dashboard ]     [ User Management ]
 (CRUD Posts)      (Audit/Delete)
        |                 |
        \--------+--------/
                 |
        [ PHP Backend Engine ]
                 |
        [ MySQL Database (wapp) ]
```

---

## 🚀 Key Features

### 🔐 Authentication & Roles
* **Dual-Entry System:** Separate authentication logic for standard users and administrative staff.
* **RBAC (Role-Based Access Control):** Session-based security ensuring users cannot access admin tools and vice-versa.

### 👤 User Capabilities
* **Content Creation:** Full CRUD (Create, Read, Update, Delete) functionality for personal blog posts.
* **Global Feed:** A comprehensive view of all community posts.
* **Profile Customization:** Dynamic username updates and account settings.

### 🛠 Administrative Tools
* **User Auditing:** A high-level overview of the entire user base.
* **Account Moderation:** Ability to remove user accounts to maintain community standards.

---

## 🧰 Technical Stack

| Category | Technology |
| :--- | :--- |
| **Frontend** | HTML5, CSS3 |
| **Backend** | PHP 7.4+ |
| **Database** | MySQL 5.7+ |
| **Web Server** | Apache (mod_rewrite enabled) |

---

## 🛠 Installation & Setup

### 1️⃣ Environment Prep
Ensure you have a local server environment installed (XAMPP, WAMP, or MAMP).

### 2️⃣ Clone & Navigate
```bash
git clone [https://github.com/AngelosFikias0/Web_Application.git](https://github.com/AngelosFikias0/Web_Application.git)
cd Web_Application
```

### 3️⃣ Database Configuration
1.  Open **phpMyAdmin** and create a database named `wapp`.
2.  Import the provided SQL schema file located in the `/database` folder.
3.  Open the database configuration file (e.g., `db_connect.php`) and update your credentials:
    ```php
    $host = "localhost";
    $user = "root";
    $pass = "your_password";
    $db   = "wapp";
    ```

### 4️⃣ Server Startup
If using Apache, ensure `mod_rewrite` is active and restart the service:
```bash
sudo service apache2 restart
```

---

## 📖 Usage Guide

1.  **Access:** Navigate to `http://localhost/Web_Application/Login.php`.
2.  **Register:** Create a new account to access the **User Dashboard**.
3.  **Post:** Write your first blog entry and view it on the public feed.
4.  **Admin:** Use designated admin credentials to log in and manage the user registry.

---

## 📈 Engineering Highlights

* **Security:** Implemented session validation to prevent unauthorized URL access.
* **Data Integrity:** Used relational database design to link posts to specific user IDs.
* **Scalability:** Modular PHP structure allows for easy addition of new features like "Comments" or "Categories."

---

## 📄 License
This project is licensed under the **MIT License**.

---
**Developed by Angelos Fikias** *Showcasing proficiency in Full-Stack Development and Secure System Design.*
