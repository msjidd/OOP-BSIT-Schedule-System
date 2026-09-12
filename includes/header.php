<?php
$activePage = isset($activePage) ? $activePage : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle) . ' - BSIT Schedule System'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <nav class="nav">
        <div class="brand">
        <img src="assets/images/bsitlogo.jpg" alt="BSIT Logo" class="logo">
    <span>Academic Schedule Management System</span>
</div>
            <div class="nav-links">
                <a href="index.php" class="<?php echo $activePage === 'home' ? 'active' : ''; ?>">Dashboard</a>
                <a href="create_schedule.php" class="<?php echo $activePage === 'create' ? 'active' : ''; ?>">Create Schedule</a>
                <a href="view_schedule.php" class="<?php echo $activePage === 'view' ? 'active' : ''; ?>">View Schedules</a>
                
            </div>
        </nav>
    </header>
    <main class="container">
