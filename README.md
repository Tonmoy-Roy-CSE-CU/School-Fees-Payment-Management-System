# 🎓 School Fees Payment Management System (SFPMS)

## 📌 Overview
**School Fees Payment Management System (SFPMS)** is a web-based application designed to streamline the process of managing student fee payments and teacher salaries in educational institutions. This system allows administrators to **track fees, generate invoices, manage student records, process payments, and handle teacher salaries efficiently**.

## ✨ Features
- 💡 **Dashboard** - Quick access to insights and statistics  
- 👨‍🎓 **Student Management** - Add, update, and track student records  
- 🎓 **Course & Fees Management** - Assign fees to courses  
- 💳 **Enrollment & Payment Tracking** - Secure and seamless payment management  
- 👩‍🏫 **Teacher Management** - Assign courses & track salaries  
- 💵 **Teacher Payroll System** - Automated salary processing  
- 📊 **Reports Generation** - Student fee reports and teacher salary statements  
- 🔑 **User Role Management** - Admin and user authentication  

---

## 🛠️ Installation Guide
### 🔹 Prerequisites
Ensure you have the following installed:
- **XAMPP / WAMP** (For local development)
- **PHP 7.4+**
- **MySQL Database**
- **Apache Server**

### 🔹 Setup Instructions
1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-repo/sfpms.git
   ```
2. **Move the Project Folder**
   Place the folder inside your `htdocs` (XAMPP) or `www` (WAMP) directory.

3. **Import the Database**
   - Open **phpMyAdmin**
   - Create a database named `sfpms_db`
   - Import the `sfpms_db.sql` file from the project

4. **Update Configuration**
   Open `config.php` and update the database credentials:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'sfpms_db');
   ```

5. **Start the Server**
   - Run XAMPP/WAMP
   - Start **Apache** and **MySQL**
   - Visit: `http://localhost/sfpms`

---

## 🚀 Usage Guide
1. **Login as Admin**
   - Default Admin:  
     **Username:** `admin`  
     **Password:** `admin123`

2. **Manage Students**
   - Add/edit student records  
   - Assign courses & track fees  

3. **Manage Teachers**
   - Assign courses  
   - Process teacher payments  

4. **Generate Reports**
   - View fee & salary transactions  

---

## 🎨 UI Highlights
- **Modern sidebar design** with **smooth scrolling**  
- **Hover effects & animations** for enhanced user experience  
- **Mobile-responsive layout**  

---

## 🛠️ Technologies Used
- **Frontend:** HTML, CSS, JavaScript (jQuery, Bootstrap)  
- **Backend:** PHP (Core PHP)  
- **Database:** MySQL  
- **Icons & UI:** FontAwesome  

---

## 🔐 Admin Credentials (Demo)
**Username:** `admin`  
**Password:** `admin123`

---

## 🤝 Contribution
Want to improve this project? Follow these steps:  
1. **Fork the repository**  
2. **Create a new branch** (`feature-new`)  
3. **Commit your changes**  
4. **Push to GitHub**  
5. **Create a Pull Request**  

---

## 🌟 License
This project is **open-source** 

---

## 📩 Contact
📧 Email: [tonmoy.cu.cse@gmail.com](mailto:tonmoy.cu.cse@gmail.com)  


