CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    role ENUM('admin', 'assessor')
);

CREATE TABLE students (
    student_id INT PRIMARY KEY,
    name VARCHAR(100),
    programme VARCHAR(100)
);

CREATE TABLE internships (
    internship_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    assessor_id INT,
    company_name VARCHAR(100),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (assessor_id) REFERENCES users(user_id)
);

CREATE TABLE assessments (
    assessment_id INT AUTO_INCREMENT PRIMARY KEY,
    internship_id INT,

    task FLOAT,
    safety FLOAT,
    theory FLOAT,
    report FLOAT,
    language FLOAT,
    lifelong FLOAT,
    project FLOAT,
    time FLOAT,

    total FLOAT,
    comments TEXT,

    FOREIGN KEY (internship_id) REFERENCES internships(internship_id)
);
