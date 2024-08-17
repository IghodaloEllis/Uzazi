/*We won't be storing student IDs', Passports and Other personal informations & documents
In the database, every important document should be communicated though a very secure approach.
*/
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'instructor', 'student') DEFAULT 'student',
    status ENUM('active', 'inactive', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_details (
    user_id INT PRIMARY KEY,
    address VARCHAR(255),
    nationality VARCHAR(100),
    religion VARCHAR(50),
    phone_number VARCHAR(20),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    profile_picture VARCHAR(255), -- Reference to external image storage
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE user_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    image_path VARCHAR(255), -- Reference to external image storage
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
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
    FOREIGN KEY (student_id) REFERENCES users(id)
);

CREATE TABLE transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    amount DECIMAL(10,2),
    transaction_date DATETIME,
    status ENUM('pending', 'completed', 'failed', 'refunded'),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)  
);

    
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
    PRIMARY KEY (course_id, instructor_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id),  
    FOREIGN KEY (instructor_id) REFERENCES Instructor(instructor_id)
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


/** INDEXES**/
-- Users table
CREATE INDEX idx_users_email ON users (email);
CREATE INDEX idx_users_role ON users (role);

-- Student_Profiles table
CREATE INDEX idx_student_profiles_user_id ON Student_Profiles (user_id);
CREATE INDEX idx_student_profiles_phone_number ON Student_Profiles (phone_number);

-- Student_Achievements table
CREATE INDEX idx_student_achievements_student_id ON Student_Achievements (student_id);

-- Student_Payments table
CREATE INDEX idx_student_payments_student_id ON Student_Payments (student_id);
CREATE INDEX idx_student_payments_payment_date ON Student_Payments (payment_date);
CREATE INDEX idx_student_payments_payment_status ON Student_Payments (payment_status);

-- Courses table
CREATE INDEX idx_courses_course_name ON Courses (course_name);
CREATE INDEX idx_courses_category ON Courses (category);
CREATE INDEX idx_courses_level ON Courses (level);

-- Course_Modules table
CREATE INDEX idx_course_modules_course_id ON Course_Modules (course_id);

-- Course_Lessons table
CREATE INDEX idx_course_lessons_module_id ON Course_Lessons (module_id);

-- Course_Materials table
CREATE INDEX idx_course_materials_course_id ON Course_Materials (course_id);

-- Course_Pricing table
CREATE INDEX idx_course_pricing_course_id ON Course_Pricing (course_id);
CREATE INDEX idx_course_pricing_start_date ON Course_Pricing (start_date);
CREATE INDEX idx_course_pricing_end_date ON Course_Pricing (end_date);

-- Student_Courses table
CREATE INDEX idx_student_courses_student_id ON Student_Courses (student_id);
CREATE INDEX idx_student_courses_course_id ON Student_Courses (course_id);

-- Instructor table
CREATE INDEX idx_instructor_email ON Instructor (email);

-- Course_Instructor table
CREATE INDEX idx_course_instructor_course_id ON Course_Instructor (course_id);
CREATE INDEX idx_course_instructor_instructor_id ON Course_Instructor (instructor_id);

-- Course_Schedules table
CREATE INDEX idx_course_schedules_course_id ON Course_Schedules (course_id);
CREATE INDEX idx_course_schedules_instructor_id ON Course_Schedules (instructor_id);
CREATE INDEX idx_course_schedules_day_of_week_start_time ON Course_Schedules (day_of_week, start_time);
