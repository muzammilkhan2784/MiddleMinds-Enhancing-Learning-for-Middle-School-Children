<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Learning Jeopardy Game</title>
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
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: calc(100% - 20px);
            margin-bottom: 20px;
            border: 2px solid #90caf9;
            border-radius: 8px;
        }

        button {
            padding: 10px 20px;
            background-color: #90caf9;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #64b5f6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Math Jeopardy!</h1>
        <form action="game.php" method="post">
            <input type="text" name="name" placeholder="Enter your name" required>
            <button type="submit">Play</button>
        </form>
    </div>
</body>

</html>
