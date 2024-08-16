CREATE TABLE Student_Payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    amount DECIMAL(10,2),
    payment_date DATE,
    payment_method ENUM('Cash', 'Card', 'Bank Transfer', 'Online Payment'),
    payment_status ENUM('Pending', 'Completed', 'Failed', 'Refunded'),
    reference_number VARCHAR(50),
    description TEXT,
    FOREIGN KEY (student_id) REFERENCES Students(student_id)
);
