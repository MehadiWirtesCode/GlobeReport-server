# 🚀 PHP + Supabase Project

![Stars](https://img.shields.io/github/stars/MehadiWirtesCode/GlobeReport-server?style=social)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![Version](https://img.shields.io/github/v/release/MehadiWirtesCode/GlobeReport-server?style=flat-square)

A simple and lightweight **PHP-based web application** integrated with **Supabase (PostgreSQL)** for database management.  
This project demonstrates how to connect a PHP backend with Supabase using environment-based configuration.

---

## 📖 Table of Contents
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Getting Started](#-getting-started)
- [API Endpoints](#-api-endpoints)
- [License](#-license)
- [Author](#-author)
---

## ✨ Features

- PHP backend with Supabase PostgreSQL
- Environment variable–based configuration
- Simple frontend using HTML, CSS, and JavaScript
- Easy local development setup
- Clean project separation (client & server)

---

## 🛠 Tech Stack

- Frontend: HTML, CSS, JavaScript  
- Backend: PHP  
- Database: Supabase (PostgreSQL)  
- Server: PHP Built-in Development Server  

---------------------------------------------------------
Follow the steps below to run the project locally.
--------------------------------------------------------
## 📁 Project Structure

project_folder/
├── GlobeReport-client/
└── GlobeReport-server/


## 🚀 Getting Started

### 1️⃣ Clone the Repositories

1️⃣ Clone the Repositories

➜ Clone the client repository: `git clone https://github.com/MehadiWirtesCode/GlobeReport-client.git`  
➜ Clone the server repository: `git clone https://github.com/MehadiWirtesCode/GlobeReport-server.git`




2️⃣ Set Up Supabase

Create an account at https://supabase.com

Create a new project

Create the required database tables as shown below:

Database Tables
<img width="1188" height="582" src="https://github.com/user-attachments/assets/dd00427f-ebef-41f0-8afa-f527646fd17f" /> <img width="1172" height="424" src="https://github.com/user-attachments/assets/059d43cf-7a36-42e8-8205-3660bbd18b88" /> <img width="1184" height="462" src="https://github.com/user-attachments/assets/148e10c6-84be-4c0c-81ac-1db472c45e38" /> <img width="1162" height="369" src="https://github.com/user-attachments/assets/c2425ab6-cdc9-451e-9365-75e8d3960510" />

3️⃣ Environment Configuration
➜  From your Supabase dashboard, copy the following database credentials:
SUPA_HOST=
SUPA_PORT=
SUPA_DB=
SUPA_USER=
SUPA_POOL_MODE=
SUPA_PASS=

➜ Create a .env file inside the server directory and paste the values:
SUPA_HOST=your_host
SUPA_PORT=your_port
SUPA_DB=your_database
SUPA_USER=your_user
SUPA_POOL_MODE=transaction
SUPA_PASS=your_password

4️⃣ Run the Server
➜ Navigate to the root project folder and run: php -S localhost:8000 -t server server/index.php

✅ Notes
Make sure PHP is installed (php -v)
Keep Supabase credentials private
Use the PHP built-in server for local development only

## 📡 API Endpoints

### Authentication

| Method | Endpoint         | Description                  |
|--------|-----------------|------------------------------|
| POST   | /api/signup      | Register a new user          |
| POST   | /api/login       | Authenticate an existing user|

### Posts

| Method | Endpoint             | Description                          |
|--------|--------------------|--------------------------------------|
| GET    | /api/getAllPosts     | Retrieve all posts (Admin view)     |
| POST   | /api/posts           | Create a new post (Admin only)      |
| POST   | /api/addToWatchLater | Add a post to the "Watch Later" list|
| POST   | /api/deletePost      | Delete a post (Admin only)          |

### News

| Method | Endpoint                  | Description                                |
|--------|---------------------------|--------------------------------------------|
| GET    | /api/getAllNews            | Retrieve all news articles                 |
| GET    | /api/getBusinessNews       | Retrieve business-related news             |
| GET    | /api/getNationalNews       | Retrieve national news                      |
| GET    | /api/getInternationalNews | Retrieve international news                |
| GET    | /api/getLifestyleNews      | Retrieve lifestyle-related news            |
| GET    | /api/getSportsNews         | Retrieve sports news                        |
| GET    | /api/getPoliticsNews       | Retrieve politics-related news             |

### Users (Admin)

| Method | Endpoint | Description                     |
|--------|---------|---------------------------------|
| GET    | /api/users | Retrieve all registered users (Admin) |

 
 
👤 Author
Mehadi Wirtes Code
GitHub: https://github.com/MehadiWirtesCode

## 📄 License
This project is open-source and available under the **MIT License**.  
See the [LICENSE](LICENSE) file for details.
