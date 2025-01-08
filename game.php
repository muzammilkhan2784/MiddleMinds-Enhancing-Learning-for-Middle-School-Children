<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "game";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];

    // Reset rounds and scores for a new game
    $_SESSION['rounds'] = 0;
    $_SESSION['scores'] = ['Science' => 0, 'Math' => 0, 'General Knowledge' => 0];

    $sql = "SELECT user_id, score FROM UserScores WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $name;
        $_SESSION['old_score'] = $row['score'];
        $_SESSION['score'] = 0; // Retrieve the existing total score
    } else {
        $sql = "INSERT INTO UserScores (name, score) VALUES (?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['name'] = $name;
        $_SESSION['score'] = 0;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Game Board</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e3f2fd;
            color: #424242;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #0d47a1;
        }

        .category {
            margin-bottom: 20px;
        }

        button {
            background-color: #90caf9;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 16px;
            color: #ffffff;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #64b5f6;
        }

        #question-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #bbdefb;
            border-radius: 8px;
        }

        #answer {
            width: calc(100% - 40px);
            padding: 10px;
            margin: 20px auto;
            display: block;
            border-radius: 8px;
            border: 2px solid #90caf9;
        }

        #submit-button, #end-game {
            width: calc(50% - 20px);
            margin-top: 10px;
            display: inline-block;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function submitAnswer(level, category) {
            let answerInput = document.getElementById('answer');
            let answer = answerInput.value.trim();
            if (answer === '') {
                alert('Please enter an answer before submitting.');
                return;
            }

            let submitButton = document.getElementById('submit-button');
            submitButton.disabled = true; // Disable the button to prevent multiple submissions

            $.post('submit.php', {
                answer: answer
            }, function(data) {
                console.log(data);
                let response = JSON.parse(data);
                answerInput.value = ''; // Clear the input after submission
                document.getElementById('question-box').textContent = '';
                document.getElementById(category + level).disabled = true; // Disable the button for the question
                alert(response.result + " New score: " + response.new_score);
                updateScoreAndRounds(response.new_score, response.rounds);
                answerInput.style.display = 'none'; // Hide the answer input
                submitButton.style.display = 'none'; // Hide the submit button
            }).fail(function() {
                alert("Error: Request failed. Try again.");
                submitButton.disabled = false; // Re-enable the button in case of failure
            });
        }

        function getQuestion(category, level) {
            $.get('question.php', {
                category: category,
                level: level
            }, function(data) {
                let response = JSON.parse(data);
                let questionBox = document.getElementById('question-box');
                let submitButton = document.getElementById('submit-button');
                let answerInput = document.getElementById('answer');

                if (response.question) {
                    questionBox.textContent = response.question;
                    sessionStorage.setItem('answer', response.answer); // Store answer in session storage
                    answerInput.style.display = 'block'; // Show the answer input
                    submitButton.style.display = 'block'; // Show the submit button
                    submitButton.disabled = false; // Enable the submit button

                    // Correctly bind the submit button's onclick event
                    submitButton.onclick = function() {
                        submitAnswer(level, category);
                    };
                } else {
                    questionBox.textContent = 'Error loading question.';
                    answerInput.style.display = 'none'; // Hide the answer input
                    submitButton.style.display = 'none'; // Hide the submit button
                }
            });
        }

        function updateScoreAndRounds(score, rounds) {
            document.getElementById('score').textContent = 'Score: ' + score;
            document.getElementById('rounds').textContent = 'Rounds: ' + rounds;
            if (rounds >= 3) {
                document.getElementById('end-game').style.display = 'block';
            }
        }


        function updateScoreAndRounds(score, rounds) {
            document.getElementById('score').textContent = 'Score: ' + score;
            document.getElementById('rounds').textContent = 'Rounds: ' + rounds;
            if (rounds >= 3) {
                document.getElementById('end-game').style.display = 'block';
            }
        }

        function endGame() {
            window.location.href = '/iste240project/iste240project/game/end-game.php';
        }
    </script>

</head>

<body>
    <div class="container">
        <h1>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>! Let's play Learning Jeopardy!</h1>
        <div id="question-box"></div>
        <div id="score">Score: <?php echo $_SESSION['score']; ?></div>
        <div id="rounds">Rounds: <?php echo $_SESSION['rounds']; ?></div>
        <div class="categories-container">
            <?php
            $categories = ['Science', 'Math', 'General Knowledge'];
            foreach ($categories as $category) {
                echo "<div class='category'>";
                echo "<h2>$category</h2>";
                for ($level = 1; $level <= 3; $level++) {
                    echo "<button id='$category$level' onclick='getQuestion(\"$category\", $level)'>Level $level</button><br>";
                }
                echo "</div>";
            }
            ?>
        </div>
        <input type="text" id="answer" placeholder="Your answer" style="display:none;">
        <button id="submit-button" style="display:none;" disabled>Submit Answer</button>
        <button id="end-game" onclick="endGame()" style="display:none;">End Game</button>
    </div>
</body>

</html>