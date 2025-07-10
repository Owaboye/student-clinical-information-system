# Secure Clinical Database Information System (CDIS)

A secure, role-based clinical information system designed to manage student health services at Crawford University. It allows doctors, nurses, and administrators to manage appointments, consultations, lab tests, and student health profiles in a safe, efficient, and responsive environment.

---
## Key Features

- 🔒 Secure Login and Role-Based Access (Admin, Doctor, Nurse, Student)
- 📅 Appointment Scheduling with Conflict and Time Restrictions
- 💊 Clinical Consultations with Diagnosis, Prescription, and Follow-up Tracking
- 🧪 Lab Test Requests and PDF Result Uploads
- 🗃️ Medical Records & Health Profile Management
- 📊 Dashboard Analytics with Chart.js
- 📄 Export to PDF/Excel (Consultations, Appointments, Lab Tests)
- 📨 Email Notifications for Lab Results
- 📂 File Uploads with Validation
- 📌 Admin Dashboard for Full Record Oversight
- 🛡️ Audit Logs for Security Tracking

---

## 🛠️ Technologies Used

| Stack | Tools |
|-------|-------|
| Frontend | HTML5, CSS3, JavaScript, Bootstrap 5 |
| Backend  | PHP 8 (Plain PHP) |
| Database | MySQL 5.7+ |
| Reporting | Dompdf (PDF generation) |
| Server    | Apache (via XAMPP/LAMP) |

---

![Background image](https://github.com/Owaboye/student-clinical-information-system/blob/main/student%20clinical-bg.PNG)

## System Requirements

**Hardware**:
- Intel i3 or higher
- 4GB RAM minimum
- 50GB storage

**Software**:
- Windows/Linux with Apache, PHP, and MySQL
- XAMPP or LAMP Stack
- Chrome/Firefox

---

## Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/cdis-clinic-system.git
   cd cdis-clinic-system

2. Import the database 
- Open phpMyAdmin
- Create a database named cdis_db
- Import the sql file cdis.sql from the repo

3. Configure Database Connection
- Edit config/database.php:

4. Start Server
- Run Apache and MySQL using XAMPP/LAMP
- Navigate to: http://localhost/cdis

## User Roles and Credentials (for testing)
### Admin:
- matric Number: 234233
- Password: crawford
- Role: Admin

### Doctor:
- matric Number: 922
- Password: crawford
- Role: Doctor

### Student:
- matric Number: 299
- Password: crawford
- Role: Doctor

# Author
Ezekiel Oluwasanjo
LinkedIn | GitHub

