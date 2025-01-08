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

    $sql = "SELECT name, score FROM UserScores ORDER BY score DESC";
    $result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
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
            overflow: auto; /* Allows scrolling if the content is larger than the screen */
        }

        .container {
            width: 90%;
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow: hidden; /* Ensures no internal content overflows */
        }

        h1, h2 {
            color: #0d47a1;
        }

        .stats-title, .score {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #90caf9;
            color: white;
        }

        .button {
            background-color: #90caf9;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            margin: 20px 10px;
            transition: background-color 0.2s;
        }

        .button:hover {
            background-color: #64b5f6;
        }

        #piechart {
            width: 100%; 
            height: 400px; /* Adjusted height to fit within the container */
        }
    </style>
    <title>Game Summary</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Score'],
                ['Science', <?php echo $_SESSION['scores']['Science'] ?? 0; ?>],
                ['Math', <?php echo $_SESSION['scores']['Math'] ?? 0; ?>],
                ['General Knowledge', <?php echo $_SESSION['scores']['General Knowledge'] ?? 0; ?>]
            ]);

            var options = {
                title: 'Score Distribution by Category',
                chartArea: { width: '100%', height: '70%' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Game Over</h1>
        <div id="piechart"></div>
        <p class="score">Total Score: <?php echo $_SESSION['score']; ?></p>
        <p class="score">Total Rounds Played: <?php echo $_SESSION['rounds']; ?></p>

        <!-- Leaderboard Table -->
        <h2>Leaderboard</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Score</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['score']; ?></td>
            </tr>
            <?php } ?>
        </table>

        <button class="button" onclick="window.location.href='/iste240project/iste240project/game/index.php'">Play Again</button>
        <button class="button" onclick="window.location.href='/iste240project/iste240project/index.html'">Go to Homepage</button>
    </div>
</body>

</html>
