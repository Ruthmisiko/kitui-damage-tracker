<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "misiko99";
$dbname = "kituitracker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complainant_name = $_POST['complainant_name'];
    $phone_number = $_POST['phone_number'];
    $subcounty = $_POST['subcounty'];
    $ward = $_POST['ward'];
    $new_area = $_POST['new_area'] ?: '';
    $infrastructure_type = $_POST['infrastructure_type'];
    $damage_description = $_POST['damage_description'];
    $severity_level = $_POST['severity_level'];
    $location_details = $_POST['location_details'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO issues (complainant_name, phone_number, subcounty, ward, new_area, infrastructure_type, damage_description, severity_level, location_details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $complainant_name, $phone_number, $subcounty, $ward, $new_area, $infrastructure_type, $damage_description, $severity_level, $location_details);

    if ($stmt->execute()) {
        $issue_id = $conn->insert_id;
        header("Location: /kitui-damage-tracker/issue.html?success=true&issue_id=" . $issue_id);
        exit();
    } else {
        header("Location: /kitui-damage-tracker/issue.html?error=" . urlencode("Error: " . $stmt->error));
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>