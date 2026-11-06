<?php
// Shared header and footer for the game pages.
function page_start(string $title): void
{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?> — MiddleMinds</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body data-page="game">
<div class="grid-bg" aria-hidden="true"></div>
<header class="nav">
  <a class="nav__brand" href="../index.html"><span>~/</span>middleminds</a>
  <nav class="nav__links" aria-label="Main">
    <a href="../index.html">Home</a>
    <a href="../resources.html">Learning Resources</a>
    <a href="../insights.html">Insights</a>
    <a href="../survey.html">Parent Survey</a>
    <a class="nav__cta" href="index.php">Let's Play</a>
  </nav>
  <button class="nav__toggle" aria-label="Toggle menu" aria-expanded="false"><span></span><span></span><span></span></button>
</header>
<main class="wrap">
<?php }

function page_end(string $extraJs = ''): void
{ ?>
</main>
<footer class="foot"><p>© MiddleMinds — Learning Hub for Middle Schoolers</p></footer>
<script src="../assets/js/main.js"></script>
<?= $extraJs ?>
</body>
</html>
<?php }
