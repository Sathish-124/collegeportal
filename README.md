🎓 College Portal Management System

A web-based College Portal Management System developed using PHP, MySQL, HTML, CSS, and JavaScript.
This system helps manage student records, attendance, marks, and parent/faculty access efficiently.

🚀 Features
👨‍🎓 Student Features

View attendance records

View marks/academic performance

Secure login system

👨‍🏫 Faculty Features

Mark attendance using Roll Number

Enter student marks

Manage academic records

👨‍👩‍👧 Parent Features

Login to view student attendance

View student marks and performance

🔐 Admin Features

Manage students

Manage faculty

Database control

🛠️ Tech Stack
Technology	Purpose
PHP	Backend Development
MySQL	Database
HTML	Structure
CSS	Styling
JavaScript	Frontend Interactions
XAMPP	Local Development Environment
🗄️ Database Structure

Main Tables:

students

faculty

parents

attendance

marks

users

Attendance and marks are recorded using Roll Number instead of Student ID for easier academic handling.

📂 Project Structure
college-portal/
│
├── admin/
├── faculty/
├── parent/
├── student/
├── includes/
│   ├── db.php
│   ├── header.php
│   └── footer.php
├── assets/
├── database/
│   └── college_portal.sql
├── index.php
└── README.md
⚙️ Installation Guide (Local Setup)

1️⃣ Install XAMPP
2️⃣ Move project folder to:

C:\xampp\htdocs\

3️⃣ Start:

Apache

MySQL

4️⃣ Create database in phpMyAdmin
5️⃣ Import college_portal.sql file
6️⃣ Configure database connection in:

includes/db.php

7️⃣ Run project in browser:

http://localhost/college-portal/
🔑 Default Login Credentials (Example)

You can modify based on your actual data.

Admin:

Username: admin
Password: admin123

Faculty:

Username: faculty1
Password: faculty123

Parent:

Username: parent1
Password: parent123
🔒 Security Features

Session-based authentication

Role-based access control

Secure login validation

Organized folder structure

Database normalization

📸 Screenshots

(Add screenshots here after uploading images to GitHub repo)

Example:

![Login Page](screenshots/login.png)
![Dashboard](screenshots/dashboard.png)
![Marks Entry](screenshots/marks.png)
📌 Future Improvements

Password hashing

Email notifications

Result analytics dashboard

Responsive UI improvements

Deployment to live server

