<?php
session_start();
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/_layout.php';

if (empty($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}

$leaders = db()->query('SELECT name, score FROM UserScores ORDER BY score DESC, updated_at ASC LIMIT 10')->fetch_all(MYSQLI_ASSOC);
$scores = $_SESSION['scores'] ?? [];
$best = max(100, ...array_values($scores ?: [0]));

page_start('Results');
?>
<section class="game">
  <div class="game__top">
    <div>
      <p class="kicker">$ game over</p>
      <h1>Nice work, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
    </div>
    <div class="hud">
      <div><b><?= (int) $_SESSION['score'] ?></b><span>Score</span></div>
      <div><b><?= (int) $_SESSION['rounds'] ?></b><span>Rounds</span></div>
    </div>
  </div>

  <div class="split">
    <div class="card">
      <p class="card__tag">Points by category</p>
      <ul class="bars">
        <?php foreach ($scores as $cat => $pts): ?>
          <li>
            <div class="bar__label"><span><?= htmlspecialchars($cat) ?></span><b><?= (int) $pts ?></b></div>
            <div class="bar"><i style="width:<?= round($pts / $best * 100) ?>%"></i></div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="card">
      <p class="card__tag">Leaderboard · top 10 best scores</p>
      <table class="board-table">
        <tr><th>#</th><th>Player</th><th>Best</th></tr>
        <?php foreach ($leaders as $i => $row): ?>
          <tr class="<?= $row['name'] === $_SESSION['name'] ? 'me' : '' ?>">
            <td><?= $i + 1 ?></td><td><?= htmlspecialchars($row['name']) ?></td><td><?= (int) $row['score'] ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>

  <div class="actions" style="margin-top:26px">
    <a class="btn btn--primary" href="index.php">Play again</a>
    <a class="btn" href="../index.html">Back to home</a>
  </div>
</section>
<?php page_end(); ?>
