// Get references to elements
const dashboardMessage = document.getElementById('dashboard-message');
const courseList = document.getElementById('course-list');

// Fetch data from the server (replace with your API endpoint)
fetch('/api/dashboard-data')
    .then(response => response.json())
    .then(data => {
        // Update the dashboard message
        dashboardMessage.textContent = data.message;

        // Populate the course list
        data.courses.forEach(course => {
            const listItem = document.createElement('li');
            listItem.textContent = course.name;
            courseList.appendChild(listItem);
        });
    })
    .catch(error => {
        console.error('Error fetching dashboard data:', error);
    });