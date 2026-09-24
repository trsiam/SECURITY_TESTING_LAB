<?php
// index.php - Complete Vulnerable Security Lab
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Vulnerable Security Lab</title>
    <!-- Google Font for clean modern look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet"/>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f5f7fb;
            color: #1e293b;
            padding: 32px 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            max-width: 1280px;
            width: 100%;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .header-left h1 {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
        }

        .header-left h1 span {
            color: #ef4444;
        }

        .header-left .sub {
            color: #64748b;
            font-size: 1rem;
            font-weight: 400;
            margin-top: 4px;
        }

        .badge-version {
            background: #eef2ff;
            color: #4f46e5;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 100px;
            letter-spacing: 0.3px;
            border: 1px solid #e0e7ff;
        }

        /* Warning */
        .warning {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 20px;
            border-radius: 16px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 32px 0;
        }

        .warning i {
            font-size: 1.2rem;
            color: #dc2626;
        }

        /* Section */
        .section {
            margin-bottom: 32px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .section-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #0f172a;
        }

        .section-header .count {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 100px;
        }

        .section-desc {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 16px;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
        }

        /* Cards */
        .card {
            background: #f8fafc;
            border: 1px solid #e9edf2;
            border-radius: 16px;
            padding: 16px 14px;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .card:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            transform: translateY(-3px);
        }

        .card .icon {
            font-size: 1.4rem;
            margin-bottom: 2px;
        }

        .card .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #0f172a;
        }

        .card .tag {
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Tag colors */
        .tag-sqli { background: #fee2e2; color: #991b1b; }
        .tag-xss { background: #fef3c7; color: #92400e; }
        .tag-lfi { background: #dbeafe; color: #1e40af; }
        .tag-rfi { background: #d1fae5; color: #065f46; }
        .tag-csrf { background: #ede9fe; color: #5b21b6; }
        .tag-redirect { background: #fce7f3; color: #9d174d; }
        .tag-cors { background: #cffafe; color: #0e7490; }
        .tag-cookie { background: #fce7f3; color: #9d174d; }
        .tag-file { background: #e0e7ff; color: #3730a3; }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #e9edf2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .reset-btn {
            background: #0f172a;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .reset-btn:hover {
            background: #1e293b;
            transform: scale(1.02);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .container { padding: 24px 16px; }
            .header-left h1 { font-size: 1.6rem; }
            .grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
            .footer { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>🔓 <span>Vulnerable</span> Security Lab</h1>
            <div class="sub">A complete web application security testing lab for educational purposes</div>
        </div>
        <div class="badge-version">🧪 v2.0 · 18 tests</div>
    </div>

    <!-- Warning -->
    <div class="warning">
        <i class="fas fa-triangle-exclamation"></i>
        <span><strong>WARNING:</strong> This site is <strong>INTENTIONALLY VULNERABLE</strong> for educational purposes only. Do not deploy on public servers.</span>
    </div>

    <!-- ===== SQL INJECTION ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔹 SQL Injection</h2>
            <span class="count">6 tests</span>
        </div>
        <div class="section-desc">Exploit database vulnerabilities through unsanitized input.</div>
        <div class="grid">
            <a href="sql-injection/login.php" class="card"><span class="icon">🔐</span><span class="name">Auth Bypass</span><span class="tag tag-sqli">SQLi</span></a>
            <a href="sql-injection/search.php" class="card"><span class="icon">🔍</span><span class="name">UNION-Based</span><span class="tag tag-sqli">SQLi</span></a>
            <a href="sql-injection/product.php" class="card"><span class="icon">📦</span><span class="name">Error-Based</span><span class="tag tag-sqli">SQLi</span></a>
            <a href="sql-injection/user.php" class="card"><span class="icon">👤</span><span class="name">Boolean Blind</span><span class="tag tag-sqli">SQLi</span></a>
            <a href="sql-injection/reset.php" class="card"><span class="icon">⏱️</span><span class="name">Time-Based Blind</span><span class="tag tag-sqli">SQLi</span></a>
            <a href="sql-injection/export.php" class="card"><span class="icon">📄</span><span class="name">Stacked Queries</span><span class="tag tag-sqli">SQLi</span></a>
        </div>
    </div>

    <!-- ===== XSS ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔸 Cross-Site Scripting (XSS)</h2>
            <span class="count">3 tests</span>
        </div>
        <div class="section-desc">Inject malicious scripts into web pages viewed by users.</div>
        <div class="grid">
            <a href="xss/reflected.php" class="card"><span class="icon">🔄</span><span class="name">Reflected XSS</span><span class="tag tag-xss">XSS</span></a>
        <a href="xss/stored.php" class="card"><span class="icon">💾</span><span class="name">Stored XSS</span><span class="tag tag-xss">XSS</span></a>
        <a href="xss/dom.php" class="card"><span class="icon">🌐</span><span class="name">DOM-based XSS</span><span class="tag tag-xss">XSS</span></a>
        <a href="xss/attacks.php" class="card"><span class="icon">🎯</span><span class="name">XSS Attack Lab</span><span class="tag tag-xss">XSS</span></a>
        </div>
    </div>

    <!-- ===== LFI ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔹 Local File Inclusion (LFI)</h2>
            <span class="count">2 tests</span>
        </div>
        <div class="section-desc">Read local files on the server through directory traversal.</div>
        <div class="grid">
            <a href="lfi/basic.php" class="card"><span class="icon">📂</span><span class="name">Basic LFI</span><span class="tag tag-lfi">LFI</span></a>
            <a href="lfi/traversal.php" class="card"><span class="icon">🔀</span><span class="name">LFI + Traversal</span><span class="tag tag-lfi">LFI</span></a>
        </div>
    </div>

    <!-- ===== RFI ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔸 Remote File Inclusion (RFI)</h2>
            <span class="count">1 test</span>
        </div>
        <div class="section-desc">Include remote files from external servers.</div>
        <div class="grid">
            <a href="rfi/remote.php" class="card"><span class="icon">🌍</span><span class="name">Remote File Inclusion</span><span class="tag tag-rfi">RFI</span></a>
        </div>
    </div>

    <!-- ===== CSRF ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔹 CSRF</h2>
            <span class="count">1 test</span>
        </div>
        <div class="section-desc">Forge requests to perform unauthorized actions.</div>
        <div class="grid">
            <a href="csrf/transfer.php" class="card"><span class="icon">🏦</span><span class="name">CSRF Token Missing</span><span class="tag tag-csrf">CSRF</span></a>
        </div>
    </div>

    <!-- ===== Open Redirect ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔸 Open Redirect</h2>
            <span class="count">1 test</span>
        </div>
        <div class="section-desc">Redirect users to malicious sites.</div>
        <div class="grid">
            <a href="redirect/open.php" class="card"><span class="icon">🔀</span><span class="name">Open Redirect</span><span class="tag tag-redirect">Redirect</span></a>
        </div>
    </div>

    <!-- ===== CORS ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔹 CORS Misconfiguration</h2>
            <span class="count">1 test</span>
        </div>
        <div class="section-desc">Bypass cross-origin resource sharing policies.</div>
        <div class="grid">
            <a href="cors/api.php" class="card"><span class="icon">🌐</span><span class="name">CORS Misconfiguration</span><span class="tag tag-cors">CORS</span></a>
        </div>
    </div>

    <!-- ===== Cookie Security ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔸 Cookie Security</h2>
            <span class="count">2 tests</span>
        </div>
        <div class="section-desc">Identify missing security flags in cookies.</div>
        <div class="grid">
            <a href="cookie/flags.php" class="card"><span class="icon">🍪</span><span class="name">Missing HttpOnly/Secure</span><span class="tag tag-cookie">Cookie</span></a>
            <a href="cookie/fixation.php" class="card"><span class="icon">🔑</span><span class="name">Session Fixation</span><span class="tag tag-cookie">Cookie</span></a>
        </div>
    </div>

    <!-- ===== File Exposure ===== -->
    <div class="section">
        <div class="section-header">
            <h2>🔹 Sensitive File Exposure</h2>
            <span class="count">1 test</span>
        </div>
        <div class="section-desc">Access sensitive files on the server.</div>
        <div class="grid">
            <a href="files/exposure.php" class="card"><span class="icon">📁</span><span class="name">Sensitive File Exposure</span><span class="tag tag-file">File</span></a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <span>🔐 Built for educational purposes only • All vulnerabilities are intentional</span>
        <form action="reset_db.php" method="POST" style="display:inline;">
            <button type="submit" class="reset-btn" onclick="return confirm('Reset database? All changes will be lost!')">
                <i class="fas fa-rotate"></i> Reset Database
            </button>
        </form>
    </div>

</div>
</body>
</html>