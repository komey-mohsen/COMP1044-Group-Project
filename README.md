# COMP1044 - Internship Result Management System

## Group Members
- Mohamed Hany Abdelaziz
- Nageh Mohamed Sameh
- Ali Elkoumy

## Requirements
- MAMP - https://www.mamp.info
- Web browser (Chrome or Firefox recommended)

## Setup Instructions

### Step 1 - Install and Start MAMP
1. Download and install MAMP from https://www.mamp.info
2. Open MAMP and click **Start Servers**
3. Wait for both Apache and MySQL to turn GREEN

### Step 2 - Copy Project Files
Copy the entire project folder into your MAMP htdocs:
- **Windows:** `C:\MAMP\htdocs\COMP1044-Group-Project-main\`
- **Mac:** `/Applications/MAMP/htdocs/COMP1044-Group-Project-main/`

### Step 3 - Setup the Database
1. Go to `http://localhost/phpmyadmin`
2. Click **New** and create database named: `internship_system`
3. Click on `internship_system`
4. Click **Import** tab
5. Select `database/COMP1044_Database.sql`
6. Click **Go**

### Step 4 - Configure Database Connection
Open `backend/config/db.php` and make sure it contains:
```php
<?php
$conn = mysqli_connect("localhost", "root", "root", "internship_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### Step 5 - Open the Website
http://localhost/COMP1044-Group-Project-main/frontend/index.html

## Login Credentials

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Assessor | assessor1 | pass123 |

## Features

### Admin
- Add, update and delete students
- Assign internships to students
- Manage internship records
- Manage assessor accounts
- View all students results

### Assessor
- Submit assessment marks for assigned students
- View results of assessed students

## Assessment Weightages

| Criteria | Weight |
|----------|--------|
| Undertaking Tasks/Projects | 10% |
| Health and Safety Requirements | 10% |
| Connectivity and Theoretical Knowledge | 10% |
| Presentation of Report | 15% |
| Clarity of Language | 10% |
| Lifelong Learning Activities | 15% |
| Project Management | 15% |
| Time Management | 15% |

## Troubleshooting

**Website shows "This page isn't working"**
→ Make sure MAMP servers are running (both green)

**"Connection failed" error**
→ Check db.php password matches your MAMP MySQL password (default: root)

**Page shows plain text**
→ Make sure you access via http://localhost/ NOT via file:///