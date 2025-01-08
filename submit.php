<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userAnswer = trim($_POST['answer']);
    $correctAnswer = $_SESSION['answer'];
    $category = $_SESSION['current_category'];

    if (strcasecmp($userAnswer, $correctAnswer) == 0) {
        $score_update = 100;
        $result = "Correct!";
        $_SESSION['scores'][$category] += $score_update;
    } else {
        $score_update = 0;
        $result = "Incorrect!";
    }

    $_SESSION['score'] += $score_update;
    $_SESSION['rounds'] += 1;

    if ($_SESSION['score'] > $_SESSION['old_score']){
        $sql = "UPDATE UserScores SET score = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_SESSION['score'], $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
    }
    echo json_encode(["result" => $result, "new_score" => $_SESSION['score'], "rounds" => $_SESSION['rounds']]);

    $conn->close();
}
