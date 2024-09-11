<?php
require 'config/database.php';

session_start();

// Create an instance of the Database class
$db = new Database();


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Get user ID
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $address = $_POST['address'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $phone_number = $_POST['phone_number'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $emergency_contact_phone = $_POST['emergency_contact_phone'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    // Validate form data (e.g., check for empty fields, valid email, date format)

    // Update user details
    try
     {

    $stmt = $db->prepare("UPDATE user_details SET address = ?, nationality = ?, religion = ?, phone_number = ?, emergency_contact_name = ?, emergency_contact_phone = ?, date_of_birth = ?, gender = ?, bio = ? WHERE user_id = ?");
    $stmt->bind_param("sssssssssi", $address, $nationality, $religion, $phone_number, $emergency_contact_name, $emergency_contact_phone, $date_of_birth, $gender, $bio, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Profile updated successfully
        header('Location: dashboard.php?success=profile_updated');
        exit;
    } else {
        // Error updating profile
        header('Location: dashboard.php?error=profile_update_failed');
        exit;
    }
} 
catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Duplicate entry error
        echo "Error: User details already exist.";
    } else {
        echo "Database error: " . $e->getMessage();
    }
} catch (Exception $e) {
    echo "General error: " . $e->getMessage();
}

// Retrieve user details from both tables in a single query
$stmt = $db->prepare("SELECT u.*, ud.* FROM users u INNER JOIN user_details ud ON u.id = ud.user_id WHERE u.id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Combine user details from both users and user_details tables
//$user = array_merge($user, $user_details);

//List of countries
$countries = array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombia",
    "Comoros",
    "Congo",
    "Congo, Democratic Republic of the",
    "Costa Rica",
    "Cote d'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czechia",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "North Korea",
    "North Macedonia",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Sweden",
    "Switzerland",
    "Syria",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Timor-Leste",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <form action="update_profile.php" method="post">
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="2" required><?php echo $user['address']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality:</label>
                <select class="form-select" id="nationality" name="nationality" required>
                    <option value="">Select  
 Country</option>
    <?php foreach ($countries as $country) { ?>
        <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
    <?php } ?>
</select>
            </div>
            <div class="mb-3">
                <label for="religion" class="form-label">Religion:</label>
                <input type="text" class="form-control" id="religion" name="religion" value="<?php echo $user['religion']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="emergency_contact_name" class="form-label">Emergency Contact Name:</label>
                <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo $user['emergency_contact_name']; ?>">
            </div>
            <div class="mb-3">
                <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone:</label>
                <input type="text" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo $user['emergency_contact_phone']; ?>">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth:</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $user['date_of_birth']; ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>