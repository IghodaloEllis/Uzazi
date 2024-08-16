// courses.js
const courseList = document.getElementById('course-list');

// Example: Sort courses by title
function sortCoursesByTitle() {
  const courses = Array.from(courseList.children);
  courses.sort((a, b) => a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent));
  courseList.innerHTML = '';
  courseList.append(...courses);
}
