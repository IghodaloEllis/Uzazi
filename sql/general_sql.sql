/*We won't be storing student IDs', Passports and Other personal informations & documents
In the database, every important document should be communicated though a very secure approach.
*/


CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
 --   student_id INT UNIQUE,  -- Unique identifier for students
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'instructor', 'student') DEFAULT 'student',
    status ENUM('active', 'inactive', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP   
);

CREATE TABLE user_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
--    user_id INT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE Student_Profiles (
    student_id INT PRIMARY KEY,
    user_id INT;
    address VARCHAR(255),
    nationality VARCHAR(100),
    religion VARCHAR(50),
    phone_number VARCHAR(20),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    profile_picture VARCHAR(255),
    bio TEXT,
    FOREIGN KEY (student_id) REFERENCES Students(student_id),
    FOREIGN KEY (user_id) REFERENCES users(id);
);

CREATE TABLE Student_Achievements (
    achievement_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    achievement_name VARCHAR(255),
    type VARCHAR(50) NULL,
    description TEXT,
    date_achieved DATE,
    proof_link VARCHAR(255),
    FOREIGN KEY (student_id) REFERENCES Students(student_id)
);

CREATE TABLE Student_Payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    amount DECIMAL(10,2),
    transaction_id INT,
    fee_type VARCHAR(50),
    payment_date DATE,
    due_date DATE,
    payment_method ENUM('Cash', 'Card', 'Bank Transfer', 'Online Payment'),
    payment_status ENUM('Pending', 'Completed', 'Failed', 'Refunded'),
    reference_number VARCHAR(50),
    description TEXT,
    FOREIGN KEY (student_id) REFERENCES Students(student_id)
);
CREATE TABLE transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    fee_type ENUM('Tuition', 'Exam', 'Materials') DEFAULT 'Tuition',

    
CREATE TABLE Courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR (100),
    duration INT,
    level ENUM('Beginner', 'Intermediate', 'Advanced'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Course_Modules (
    module_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    module_name VARCHAR(255),
    description TEXT,
    order_number INT,
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

CREATE TABLE Course_Lessons (
    lesson_id INT PRIMARY KEY AUTO_INCREMENT,
    module_id INT,
    lesson_name VARCHAR(255),
    content TEXT,
    order_number INT,
    FOREIGN KEY (module_id) REFERENCES Course_Modules(module_id)
);

CREATE TABLE Course_Materials (
    material_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    material_type ENUM('document', 'video', 'audio', 'link'),
    title VARCHAR(255),
    description TEXT,
    file_id VARCHAR(50); -- to mprove security and scalability. instead of in the database
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

CREATE TABLE Course_Pricing (
    pricing_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    price DECIMAL(10,2),
    currency VARCHAR(3),
    start_date DATE,
    end_date DATE,
    discount DECIMAL(5,2),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

CREATE TABLE Student_Courses (
    student_id INT,
    course_id INT,
    enrollment_date DATE,
    category VARCHAR(50),
    language VARCHAR(50),
    status ENUM('Enrolled', 'Completed', 'Dropped'),
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES Students(student_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

CREATE TABLE Instructor (
    instructor_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    bio TEXT,
    qualification VARCHAR(255),
    experience INT
);

CREATE TABLE Course_Instructor (
    course_id INT,
    instructor_id INT,
    PRIMARY KEY (course_id, teacher_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id),
    FOREIGN KEY (teacher_id) REFERENCES Teachers(teacher_id)
);

CREATE TABLE Admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Course_Schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    section_number INT,
    start_time TIME,
    end_time TIME,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
    room_id INT, -- Reference to a Rooms table if applicable
    instructor_id INT, -- Reference to a Teachers table if applicable
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);
