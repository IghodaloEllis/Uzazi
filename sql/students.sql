CREATE TABLE Student_Profiles (
    student_id INT PRIMARY KEY,
    address VARCHAR(255),
    phone_number VARCHAR(20),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    profile_picture VARCHAR(255), -- Store path to profile picture
    bio TEXT,
    FOREIGN KEY (student_id) REFERENCES Students(student_id)
);
