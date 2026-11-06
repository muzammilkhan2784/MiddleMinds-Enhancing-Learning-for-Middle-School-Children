<?php
require __DIR__ . '/_layout.php';
page_start('Learning Jeopardy');
?>
<section class="center-card">
  <p class="kicker">$ ./play</p>
  <h1 style="margin:0 0 10px;font-size:clamp(30px,4.4vw,44px);letter-spacing:-1.2px">Learning Jeopardy</h1>
  <p style="color:var(--text-dim);margin:0 0 28px">Pick a category and a level, answer the question, and earn 100 points for every correct answer.
    Play 3 rounds to finish and see the leaderboard.</p>
  <form class="form" action="board.php" method="post">
    <div class="field">
      <label for="name">Player name</label>
      <input class="input" id="name" type="text" name="name" maxlength="60" placeholder="e.g. Alex" required autofocus>
    </div>
    <button class="btn btn--primary" type="submit">Start game →</button>
  </form>
</section>
<?php page_end(); ?>
