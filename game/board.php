<?php
session_start();
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/_layout.php';

const CATEGORIES = ['Science', 'Math', 'General Knowledge'];
const ROUNDS = 3;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST['name'] ?? '') !== '') {
    $name = mb_substr(trim($_POST['name']), 0, 60);

    $_SESSION['rounds'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['scores'] = array_fill_keys(CATEGORIES, 0);
    $_SESSION['name'] = $name;

    $stmt = db()->prepare('SELECT user_id, score FROM UserScores WHERE name = ?');
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($row) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['best_score'] = (int) $row['score'];
    } else {
        $stmt = db()->prepare('INSERT INTO UserScores (name, score) VALUES (?, 0)');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['best_score'] = 0;
        $stmt->close();
    }
    header('Location: board.php');
    exit;
}

if (empty($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}

page_start('Game board');
?>
<section class="game">
  <div class="game__top">
    <div>
      <p class="kicker">$ player = "<?= htmlspecialchars($_SESSION['name']) ?>"</p>
      <h1>Hello, <?= htmlspecialchars($_SESSION['name']) ?>! Pick a question.</h1>
    </div>
    <div class="hud">
      <div><b id="score"><?= (int) $_SESSION['score'] ?></b><span>Score</span></div>
      <div><b id="rounds"><?= (int) $_SESSION['rounds'] ?>/<?= ROUNDS ?></b><span>Rounds</span></div>
    </div>
  </div>

  <div class="board">
    <?php foreach (CATEGORIES as $category): ?>
      <div class="board__col">
        <h2><?= htmlspecialchars($category) ?></h2>
        <?php for ($level = 1; $level <= 3; $level++): ?>
          <button class="tile" data-category="<?= htmlspecialchars($category) ?>" data-level="<?= $level ?>">
            <?= $level * 100 ?><small>LEVEL <?= $level ?></small>
          </button>
        <?php endfor; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="qbox" id="qbox" aria-live="polite">
    <p class="qbox__meta" id="qmeta"></p>
    <p class="qbox__q" id="qtext"></p>
    <form id="answerForm">
      <input class="input" id="answer" type="text" placeholder="Type your answer" autocomplete="off" required>
      <button class="btn btn--primary" type="submit">Submit answer</button>
    </form>
    <p class="feedback" id="feedback"></p>
  </div>

  <div style="margin-top:26px;display:none" id="endWrap">
    <a class="btn btn--primary" href="end.php">See results &amp; leaderboard →</a>
  </div>
</section>
<?php
$js = <<<'JS'
<script>
  const ROUNDS = 3;
  const qbox = document.getElementById('qbox');
  const qmeta = document.getElementById('qmeta');
  const qtext = document.getElementById('qtext');
  const form = document.getElementById('answerForm');
  const input = document.getElementById('answer');
  const feedback = document.getElementById('feedback');
  const tiles = document.querySelectorAll('.tile');
  let active = null;

  tiles.forEach((tile) => tile.addEventListener('click', async () => {
    if (active) return;
    const params = new URLSearchParams({ category: tile.dataset.category, level: tile.dataset.level });
    const res = await fetch('question.php?' + params);
    const data = await res.json();
    active = tile;
    tiles.forEach((t) => (t.disabled = true));
    qmeta.textContent = `${tile.dataset.category} · Level ${tile.dataset.level}`;
    qtext.textContent = data.question;
    feedback.textContent = '';
    form.style.display = '';
    qbox.classList.add('is-open');
    input.value = '';
    input.focus();
  }));

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch('submit.php', { method: 'POST', body: new URLSearchParams({ answer: input.value }) });
    const data = await res.json();
    feedback.textContent = data.correct ? '✓ Correct! +100' : `✗ Not quite. The answer was "${data.answer}".`;
    feedback.className = 'feedback ' + (data.correct ? 'ok' : 'no');
    active.classList.add(data.correct ? 'is-right' : 'is-wrong');
    document.getElementById('score').textContent = data.score;
    document.getElementById('rounds').textContent = `${data.rounds}/${ROUNDS}`;
    form.style.display = 'none';
    if (data.rounds >= ROUNDS) {
      document.getElementById('endWrap').style.display = 'block';
    } else {
      tiles.forEach((t) => { if (!t.classList.contains('is-right') && !t.classList.contains('is-wrong')) t.disabled = false; });
    }
    active = null;
  });
</script>
JS;
page_end($js);
