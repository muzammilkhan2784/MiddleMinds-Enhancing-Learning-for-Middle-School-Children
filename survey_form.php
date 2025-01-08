<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iste240";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO ParentSurvey (ParentName, ParentEmail, MiddleSchoolChildrenCount, BiggestChallenges1, BiggestChallenges2, BiggestChallenges3, InvolvementLevel, Suggestions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisssss", $parentName, $parentEmail, $childrenCount, $challenge1, $challenge2, $challenge3, $involvementLevel, $suggestions);

// Set parameters and execute
$parentName = $_POST['parentName'];
$parentEmail = $_POST['parentEmail'];
$childrenCount = $_POST['childrenCount'];
$challenge1 = $_POST['biggestChallenge1'];
$challenge2 = $_POST['biggestChallenge2'];
$challenge3 = $_POST['biggestChallenge3'];
$involvementLevel = $_POST['involvementLevel'];
$suggestions = $_POST['suggestions'];

if ($stmt->execute()) {
    echo "New records created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
