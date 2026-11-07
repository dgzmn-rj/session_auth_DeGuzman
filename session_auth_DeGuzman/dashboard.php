<?php
session_start();

// SECURITY: ANTI-BACK BUTTON & ANTI-CACHE
// Pinagbabawalan nito ang browser na i-save (cache) ang page na ito.
// Kaya kapag nag-logout at pinindot ang Back button, walang mababalikan.
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");


// PROTEKSYON: Kung walang session (nag-logout na), balik sa login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Kunin ang session ID para ipakita sa dashboard (gaya sa picture)
$current_session_id = session_id();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - AuthSystem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grid {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .box {
            flex: 1;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .btn-logout {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>SessionAuthSystem</h2>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <h1 style="color:#0056b3;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>This page is protected and only visible to logged-in users.</p>

        <div class="grid">
            <div class="box">
                <h3 style="color:green;">✔ Account Status</h3>
                <p>Your session is active and protected against Session Fixation using <code>session_regenerate_id(true)</code>.</p>
            </div>
            <div class="box">
                <h3 style="color:#007bff;">👤 User Details</h3>
                <p><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
            <div class="box">
                <h3 style="color:gray;">🛡 Active Session ID</h3>
                <p><strong>Current Session ID:</strong><br> <small><?php echo $current_session_id; ?></small></p>
                <p style="font-size: 12px; color: gray;">Generated after login via session_regenerate_id(true).</p>
            </div>
        </div>
        <p style="font-size:12px; margin-top:30px; color:gray;">You can log out and log back in to see session regeneration in action.</p>
    </div>
</body>

</html>