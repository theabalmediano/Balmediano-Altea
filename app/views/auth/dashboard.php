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
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link 
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Quicksand:wght@500;700&display=swap" 
    rel="stylesheet"
  />
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <style>
    body {
      font-family: 'Nunito', 'Quicksand', sans-serif;
      background: #fff0f6;
      color: #831843;
      min-height: 100vh;
    }
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
    .header-title {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .header-title .icon {
      background: linear-gradient(135deg, #f472b6, #f9a8d4);
      padding: 0.75rem;
      border-radius: 9999px;
      color: white;
      box-shadow: 0 10px 25px rgba(236, 72, 153, 0.2);
    }
    .header-title h1 {
      font-size: 2rem;
      font-weight: 700;
      margin: 0;
      color: #be185d;
    }
    .header-title p {
      font-size: 1rem;
      margin: 0;
      color: #db2777;
    }
    .btn-logout {
      background: linear-gradient(135deg, #be185d, #ec4899);
      color: white;
      font-weight: 700;
      padding: 0.6rem 1.5rem;
      border-radius: 9999px;
      box-shadow: 0 6px 18px rgba(236, 72, 153, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: background 0.3s ease;
      text-decoration: none;
    }
    .btn-logout:hover {
      background: linear-gradient(135deg, #ec4899, #be185d);
    }

    .stats-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2.5rem;
    }
    .stat-card {
      background: white;
      border-radius: 1.5rem;
      padding: 1.75rem 1.5rem;
      box-shadow: 0 8px 30px rgba(219, 39, 119, 0.1);
    }
    .stat-card h3 {
      font-size: 1.25rem;
      font-weight: 700;
      color: #be185d;
      margin: 0;
    }
    .stat-card p {
      font-size: 0.85rem;
      margin-top: 0.5rem;
      color: #831843;
    }

    .table-wrapper {
      overflow-x: auto;
      background: white;
      border-radius: 1.5rem;
      box-shadow: 0 8px 30px rgba(219, 39, 119, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 600px;
    }
    thead {
      background: linear-gradient(135deg, #f472b6, #ec4899);
      color: white;
    }
    thead th {
      padding: 1rem 1.25rem;
      font-weight: 700;
      font-size: 0.95rem;
    }
    tbody tr {
      border-bottom: 1px solid #fbcfe8;
    }
    tbody tr:nth-child(even) {
      background: #fff0f5;
    }
    tbody tr:hover {
      background: #f9a8d4;
    }
    tbody td {
      padding: 1rem 1.25rem;
      font-size: 0.9rem;
      color: #831843;
    }
    .action-cell {
      display: flex;
      gap: 0.5rem;
    }
    .btn-update {
      background: linear-gradient(135deg, #a855f7, #c084fc);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      transition: background 0.3s ease;
    }
    .btn-update:hover {
      background: linear-gradient(135deg, #9333ea, #a855f7);
    }
    .btn-delete {
      background: linear-gradient(135deg, #fb7185, #f43f5e);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      transition: background 0.3s ease;
    }
    .btn-delete:hover {
      background: linear-gradient(135deg, #f43f5e, #e11d48);
    }

    .bottom {
      margin-top: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .pagination a {
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      background: #fce7f3;
      color: #9d174d;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    .pagination a:hover {
      background: #ec4899;
      color: white;
    }
    .pagination strong {
      background: #ec4899;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      font-weight: 700;
    }

    .empty-text {
      text-align: center;
      padding: 2.5rem 0;
      color: #be185d;
      font-weight: 700;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="header-title">
        <div class="icon">
          <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <div>
          <h1>Dashboard</h1>
          <p>Welcome to your magical space ✨</p>
        </div>
      </div>
      <a href="<?= site_url('auth/logout'); ?>" class="btn-logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>
    </div>

    <!-- Statistics / summary cards -->
    <div class="stats-cards">
      <div class="stat-card">
        <h3>Total Users</h3>
        <p><?= $total_users ?? '0' ?></p>
      </div>
      <div class="stat-card">
        <h3>Admins</h3>
        <p><?= $total_admins ?? '0' ?></p>
      </div>
      <div class="stat-card">
        <h3>Regular Users</h3>
        <p><?= $total_regulars ?? '0' ?></p>
      </div>
      <div class="stat-card">
        <h3>Other Metric</h3>
        <p><?= $other_metric ?? '–' ?></p>
      </div>
    </div>

    <!-- User list table -->
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <?php if ($role === 'admin'): ?>
              <th>Actions</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($users)): ?>
            <?php foreach (html_escape($users) as $user): ?>
              <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['first_name'] ?></td>
                <td><?= $user['last_name'] ?></td>
                <td><?= $user['email'] ?></td>
                <?php if ($role === 'admin'): ?>
                  <td>
                    <div class="action-cell">
                      <a class="btn-update" href="<?= site_url('users/update/' . $user['id']) ?>">
                        <i class="fa-solid fa-pen-to-square"></i> Update
                      </a>
                      <a class="btn-delete" href="<?= site_url('users/delete/' . $user['id']) ?>" onclick="return confirm('Are you sure?')">
                        <i class="fa-solid fa-trash"></i> Delete
                      </a>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="<?= $role === 'admin' ? '5' : '4' ?>" class="empty-text">
                No users found. Try a different keyword.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="bottom">
      <div class="pagination">
        <?= $page ?? '' ?>
      </div>
    </div>
  </div>
</body>
</html>
