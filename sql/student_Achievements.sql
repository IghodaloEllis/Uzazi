CREATE TABLE Student_Achievements (
    achievement_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    achievement_name VARCHAR(255),
    description TEXT,
    date_achieved DATE,
    proof_link VARCHAR(255), -- Link to proof of achievement
    FOREIGN KEY (student_id) REFERENCES Students(student_id)
);
