/*We won't be storing student IDs', Passports and Other personal informations & documents
In the database, every important document should be communicated though a very secure approach.
All queries run now but this is not the final database.
*/

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'instructor', 'student') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    address VARCHAR(255),
    nationality VARCHAR(100),
    religion VARCHAR(50),
    phone_number VARCHAR(20),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    bio TEXT,
    status ENUM('active', 'inactive', 'deleted', 'new') DEFAULT 'new',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE user_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    image_path VARCHAR(255), -- Reference to external image storage
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE student_achievements (
    achievement_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    achievement_name VARCHAR(255),
    achievement_type VARCHAR(50),
    description TEXT,
    date_achieved DATE,
    proof_link VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE student_payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    amount DECIMAL(10,2),
    transaction_id INT,
    fee_type VARCHAR(50),
    payment_date DATE,
    due_date DATE,
    payment_method ENUM('Cash', 'Card', 'Bank Transfer', 'Online Payment'),
    payment_status ENUM('Pending', 'Completed', 'Failed', 'Refunded'),
    reference_number VARCHAR(50),
    description TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
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

CREATE TABLE courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    duration INT,
    level ENUM('Beginner', 'Intermediate', 'Advanced'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE course_modules (
    module_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    module_name VARCHAR(255),
    description TEXT,
    order_number INT,
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

CREATE TABLE course_lessons (
    lesson_id INT PRIMARY KEY AUTO_INCREMENT,
    module_id INT,
    lesson_name VARCHAR(255),
    content TEXT,
    order_number INT,
    FOREIGN KEY (module_id) REFERENCES course_modules(module_id)
);

CREATE TABLE course_materials (
    material_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    material_type ENUM('document', 'video', 'audio', 'link'),
    title VARCHAR(255),
    description TEXT,
    file_id VARCHAR(50), -- to mprove security and scalability. instead of in the database
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

CREATE TABLE course_pricing (
    pricing_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    price DECIMAL(10,2),
    currency VARCHAR(3),
    start_date DATE,
    end_date DATE,
    discount DECIMAL(5,2),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

/**While the courses, course_modules, course_lessons, and course_materials tables 
don't directly reference the users table, they can indirectly be linked through the student_courses table. 
For example, you can query for a user's enrolled courses, 
and then use the course_id from student_courses to retrieve related modules, lessons, and materials.**/

CREATE TABLE student_courses (
    student_id INT,
    course_id INT,
    enrollment_date DATE,
    category VARCHAR(50),
    language VARCHAR(50),
    status ENUM('Enrolled', 'Completed', 'Dropped'),
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES users(id), -- Corrected reference to users
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

CREATE TABLE instructors (
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

CREATE TABLE course_instructor (
    course_id INT,
    instructor_id INT,
    PRIMARY KEY (course_id, instructor_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    FOREIGN KEY (instructor_id) REFERENCES instructors(instructor_id)
);

CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE course_schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    section_number INT,
    start_time TIME,
    end_time TIME,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
    room_id INT, -- Reference to a Rooms table if applicable
    instructor_id INT, -- Reference to a instructors table if applicable
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

-- INDEXES
CREATE INDEX idx_users_email ON users (email);
CREATE INDEX idx_users_role ON users (role);

CREATE INDEX idx_user_details_user_id ON user_details (user_id);
CREATE INDEX idx_user_details_phone_number ON user_details (phone_number);

CREATE INDEX idx_student_achievements_user_id ON student_achievements (user_id);

CREATE INDEX idx_student_payments_user_id ON student_payments (user_id);
CREATE INDEX idx_student_payments_payment_date ON student_payments (payment_date);
CREATE INDEX idx_student_payments_payment_status ON student_payments (payment_status);

CREATE INDEX idx_courses_course_name ON courses (course_name);
CREATE INDEX idx_courses_category ON courses (category);
CREATE INDEX idx_courses_level ON courses (level);

CREATE INDEX idx_course_modules_course_id ON course_modules (course_id);

CREATE INDEX idx_course_lessons_module_id ON course_lessons (module_id);

CREATE INDEX idx_course_materials_course_id ON course_materials (course_id);

CREATE INDEX idx_course_pricing_course_id ON course_pricing (course_id);
CREATE INDEX idx_course_pricing_start_date ON course_pricing (start_date);
CREATE INDEX idx_course_pricing_end_date ON course_pricing (end_date);

CREATE INDEX idx_student_courses_student_id ON student_courses (student_id);
CREATE INDEX idx_student_courses_course_id ON student_courses (course_id);

CREATE INDEX idx_instructors_email ON instructors (email);

CREATE INDEX idx_course_instructor_course_id ON course_instructor (course_id);
CREATE INDEX idx_course_instructor_instructor_id ON course_instructor (instructor_id);

CREATE INDEX idx_course_schedules_course_id ON course_schedules (course_id);