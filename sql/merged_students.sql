--For Future updates

CREATE TABLE merged_students (
  student_id INT PRIMARY KEY,
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  -- other columns from all tables
);

INSERT INTO merged_students (student_id, first_name, last_name, ...)
SELECT s.student_id, s.first_name, s.last_name, sp.address, ...
FROM Students s
LEFT JOIN Student_Profiles sp ON s.student_id = sp.student_id
LEFT JOIN Student_Achievements sa ON s.student_id = sa.student_id
LEFT JOIN Student_Payments spm ON s.student_id = spm.student_id;
