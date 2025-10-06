<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: " . site_url('auth/login'));
    exit;
}

$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Directory - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('https://i.pinimg.com/736x/bf/01/f9/bf01f9444340ecdb37af06d201c6f1cf.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      padding: 2rem;
    }
    /* ... (lahat ng styles mo unchanged) ... */
  </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="title">
            <div class="title-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="title-text">
                <h1>Student Directory</h1>
                <p>Manage your lovely students 💖</p>
            </div>
        </div>
        <a href="<?= site_url('users/create') ?>" class="btn-primary">
            <i class="fa-solid fa-user-plus"></i> Add Student
        </a>
    </div>

    <!-- Search -->
    <div class="search">
        <form method="get" action="<?= site_url('/auth/dashboard') ?>">
            <input type="text" name="q" value="<?= html_escape($_GET['q'] ?? '') ?>" placeholder="🔍 Search student..." />
            <button type="submit"><i class="fa fa-search"></i> Search</button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach (html_escape($users) as $user): ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= $user['last_name']; ?></td>
                            <td><?= $user['first_name']; ?></td>
                            <td><?= $user['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="empty-text">
                            <i class="fa-solid fa-heart-crack" style="font-size:1.5rem;margin-bottom:0.5rem;display:block;"></i>
                            No students found 💔
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="bottom">
        <div class="pagination">
            <?= $page ?? '' ?>
        </div>
        <a href="<?= site_url('auth/logout'); ?>" class="btn-logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>

</body>
</html>
