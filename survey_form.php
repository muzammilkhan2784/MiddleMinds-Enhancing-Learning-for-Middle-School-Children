<?php
// Saves a parent survey response and answers with JSON.
require __DIR__ . '/includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['ok' => false, 'error' => 'POST only']));
}

$name        = trim($_POST['parentName'] ?? '');
$email       = trim($_POST['parentEmail'] ?? '');
$count       = (int) ($_POST['childrenCount'] ?? 0);
$c1          = trim($_POST['biggestChallenge1'] ?? '');
$c2          = trim($_POST['biggestChallenge2'] ?? '') ?: null;
$c3          = trim($_POST['biggestChallenge3'] ?? '') ?: null;
$involvement = trim($_POST['involvementLevel'] ?? '');
$suggestions = trim($_POST['suggestions'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $count < 1 || $c1 === '' || $involvement === '') {
    http_response_code(422);
    exit(json_encode(['ok' => false, 'error' => 'Please fill in all required fields.']));
}

$stmt = db()->prepare(
    'INSERT INTO ParentSurvey (ParentName, ParentEmail, MiddleSchoolChildrenCount, BiggestChallenges1,
     BiggestChallenges2, BiggestChallenges3, InvolvementLevel, Suggestions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);
$stmt->bind_param('ssisssss', $name, $email, $count, $c1, $c2, $c3, $involvement, $suggestions);
$ok = $stmt->execute();
$stmt->close();

echo json_encode($ok ? ['ok' => true] : ['ok' => false, 'error' => 'Could not save response.']);
