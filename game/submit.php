<?php
// Checks an answer, updates the session score, and saves a new personal best.
session_start();
require __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['answer'], $_SESSION['user_id'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'No active question.']));
}

$correctAnswer = $_SESSION['answer'];
$category = $_SESSION['current_category'];
unset($_SESSION['answer']); // one answer per question

$correct = strcasecmp(trim($_POST['answer'] ?? ''), $correctAnswer) === 0;
if ($correct) {
    $_SESSION['score'] += 100;
    $_SESSION['scores'][$category] += 100;
}
$_SESSION['rounds'] += 1;

if ($_SESSION['score'] > $_SESSION['best_score']) {
    $_SESSION['best_score'] = $_SESSION['score'];
    $stmt = db()->prepare('UPDATE UserScores SET score = ? WHERE user_id = ?');
    $stmt->bind_param('ii', $_SESSION['score'], $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

echo json_encode([
    'correct' => $correct,
    'answer'  => $correctAnswer,
    'score'   => $_SESSION['score'],
    'rounds'  => $_SESSION['rounds'],
]);
