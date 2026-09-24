<!DOCTYPE html>
<html>
<head>
    <title>DOM-based XSS</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #1a1a2e; color: #fff; }
        .container { max-width: 800px; margin: auto; background: #16213e; padding: 30px; border-radius: 10px; }
        h1 { color: #e94560; }
        .vuln-badge { background: #e94560; color: #fff; padding: 5px 10px; border-radius: 5px; display: inline-block; font-size: 12px; }
        input { width: 60%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #e94560; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .back { display: block; margin-top: 20px; color: #4fc3f7; }
        #output { background: #0f3460; padding: 15px; border-radius: 5px; margin-top: 20px; }
        .payload { background: #1a1a2e; padding: 10px; border-left: 3px solid #e94560; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔸 DOM-based XSS</h1>
        <span class="vuln-badge">VULNERABLE</span>
        <p style="color: #aaa;">Try: <strong>&lt;img src=x onerror=alert('XSS')&gt;</strong></p>

        <input type="text" id="name" placeholder="Enter your name..." onkeyup="updateGreeting()">
        <br><br>

        <div id="output">
            <h3>👋 Greeting:</h3>
            <!-- 🔥 VULNERABLE - DOM manipulation with user input -->
            <div id="greeting" class="payload">Hello, guest!</div>
        </div>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>

    <script>
        // 🔥 VULNERABLE - Directly inserting user input into DOM
        function updateGreeting() {
            var name = document.getElementById('name').value;
            // Using innerHTML - VULNERABLE to XSS!
            document.getElementById('greeting').innerHTML = 'Hello, ' + name + '!';
        }
    </script>
</body>
</html>