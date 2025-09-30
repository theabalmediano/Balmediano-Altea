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
    <title>Kuromi User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(to right, #2c003e, #4c0070);
            color: #fff;
            padding: 20px;
        }

        .kuromi-container {
            max-width: 1000px;
            margin: auto;
            background: #1c1c1e;
            border: 4px solid #ffb6faff;
            border-radius: 15px;
            box-shadow: 0 0 20px #ffb6faff;
            padding: 30px;
        }

        h1 {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
            color: #ffb6fa;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #2a2a2e;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ffb6fa;
            text-align: center;
        }

        th {
            background-color: #ffb6fa;
            color: #2c003e;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #3a3a3f;
        }

        tr:hover {
            background-color: #4a0044;
        }

        .create-btn {
            background-color: #ff6ec7;
            padding: 10px 20px;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .create-btn:hover {
            background-color: #e94ec1;
        }

        .update-btn {
            color: #82eefd;
            font-weight: bold;
            text-decoration: none;
        }

        .update-btn:hover {
            text-decoration: underline;
            color: #a0ffff;
        }

        .delete-btn {
            color: #ff4d6d;
            font-weight: bold;
            text-decoration: none;
        }

        .delete-btn:hover {
            text-decoration: underline;
            color: #ff8099;
        }

        .search-bar input {
            border: 2px solid #ffb6fa;
            border-radius: 10px 0 0 10px;
            padding: 10px;
            outline: none;
            width: 250px;
        }

        .search-bar button {
            background-color: #ffb6fa;
            color: #2c003e;
            border-radius: 0 10px 10px 0;
            padding: 10px 15px;
            font-weight: bold;
        }

        .search-bar button:hover {
            background-color: #ffc8fd;
        }

        .logout-btn {
            background-color: #f87171;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        .pagination {
            color: #ffb6fa;
        }

        .pagination a {
            padding: 5px 10px;
            border: 2px solid #ffb6fa;
            margin: 0 3px;
            border-radius: 5px;
            text-decoration: none;
            color: #ffb6fa;
        }

        .pagination a:hover {
            background-color: #ffb6fa;
            color: #2c003e;
        }
    </style>
</head>
<body>

<!-- Search Bar -->
<form method="get" action="<?=site_url('/users')?>" class="search-bar mb-6 flex justify-end">
    <input type="text" name="q" value="<?=html_escape($_GET['q'] ?? '')?>" placeholder="🔍 Search user...">
    <button type="submit">Go</button>
</form>

<div class="kuromi-container">
    <div class="flex justify-between items-center mb-6">
        <h1> Kuromi User List </h1>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a class="create-btn" href="<?=site_url('users/create');?>">➕ Add User</a>
        <?php endif; ?>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <th>Action</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach(html_escape($users) as $user): ?>
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= $user['first_name']; ?></td>
                <td><?= $user['last_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <td>
                        <a class="update-btn" href="<?= site_url('users/update/'.$user['id']); ?>">✏️ Update</a> |
                        <a class="delete-btn" href="<?= site_url('users/delete/'.$user['id']); ?>">🗑️ Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination + Logout -->
    <div class="flex justify-between items-center mt-6">
        <div class="pagination">
            <?= $page ?? '' ?>
        </div>
        <a href="<?=site_url('auth/logout');?>" class="logout-btn">🚪 Logout</a>
    </div>
</div>

</body>
</html>
