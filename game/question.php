<?php
// Returns a question for a category and level. The answer stays on the server.
session_start();
require __DIR__ . '/questions.php';
header('Content-Type: application/json');

function mathQuestion(int $level): array
{
    $max = 10 ** $level - 1;
    $min = $level === 1 ? 1 : 10 ** ($level - 1);
    $op = ['+', '-', '×', '÷'][array_rand([0, 1, 2, 3])];

    switch ($op) {
        case '+':
            $a = rand($min, $max); $b = rand($min, $max); $ans = $a + $b; break;
        case '-':
            $a = rand($min, $max); $b = rand($min, $a); $ans = $a - $b; break;
        case '×':
            $a = rand($min, $max); $b = rand(2, $level === 1 ? 9 : 12); $ans = $a * $b; break;
        default: // ÷ — build it backwards so the answer is always a whole number
            $b = rand(2, $level === 1 ? 9 : 12); $ans = rand($min, $max); $a = $ans * $b;
    }
    return ["$a $op $b = ?", (string) $ans];
}

$category = $_GET['category'] ?? 'Math';
$level = max(1, min(3, (int) ($_GET['level'] ?? 1)));

if ($category === 'Science') {
    [$question, $answer] = $scienceQuestions[$level][array_rand($scienceQuestions[$level])];
} elseif ($category === 'General Knowledge') {
    [$question, $answer] = $generalKnowledgeQuestions[$level][array_rand($generalKnowledgeQuestions[$level])];
} else {
    $category = 'Math';
    [$question, $answer] = mathQuestion($level);
}

$_SESSION['answer'] = $answer;
$_SESSION['current_category'] = $category;

echo json_encode(['question' => $question, 'category' => $category, 'level' => $level]);
