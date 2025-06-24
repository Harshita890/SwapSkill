# SkillSwap 

SkillSwap is a PHP-based web application that allows users to exchange skills with each other in a structured way. It includes a user authentication system, skill management, messaging, and a premium upgrade option using Stripe integration.

---

## 🚀 Features

- ✅ User Registration and Login
- 🧠 Add and Edit Skills
- 💬 Real-Time Messaging Between Users
- 👤 User Profiles
- 🧾 Skill Listings and Dashboard
- 🌟 Premium Upgrade (Stripe Integration)
- 🎨 Modern UI with consistent color theme

---

## 🗂️ File Overview

| File | Purpose |
|------|---------|
| `index.php` | Landing page of the site |
| `register.php` | Handles user registration |
| `login.php` | Login form with session setup |
| `logout.php` | Ends session and logs out the user |
| `dashboard.php` | Main dashboard showing user's skills and stats |
| `add_skill.php` | Page to add new skills |
| `edit_skill.php` | Page to edit existing skills |
| `skills.php` | Displays all skills |
| `profile.php` | Shows user profile details |
| `inbox.php` | Main messaging interface |
| `messages.php` | Shows message chat UI |
| `send_message.php` | Handles sending messages |
| `get_messages.php` | Fetches messages with AJAX |
| `upgrade.php` | Stripe payment page for upgrading to premium |
| `css.css` | Custom stylesheet for all pages (yellow, green, black theme) |

---

## 🛠️ Technology Used

- **PHP** (Server-side scripting)
- **MySQL** (Database via XAMPP)
- **HTML + CSS** (Frontend UI)
- **JavaScript + AJAX** (Live messaging)
- **Stripe API** (Premium payments)
- **XAMPP** (Local server environment)

---

## 🧪 Setup Instructions (with XAMPP)

1. ✅ Install XAMPP from: [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. ✅ Place the project folder (`skillswap`) in `C:/xampp/htdocs/`
3. ✅ Start **Apache** and **MySQL** from XAMPP Control Panel
4. ✅ Open `http://localhost/phpmyadmin/` and create a database named `skillswap`
5. ✅ Import the SQL dump (`skillswap.sql`) if available
6. ✅ Make sure database connection in all PHP files looks like:
   ```php
   $mysqli = new mysqli("localhost", "root", "", "skillswap");
