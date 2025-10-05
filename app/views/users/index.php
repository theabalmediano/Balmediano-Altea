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
    <title>Kuromi Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://i.pinimg.com/originals/e1/f8/6f/e1f86f4b300a8d50c0ff089c2fc1d38a.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 3rem 1rem;
        }

        .card {
            background: #ffe4f1;
            border-radius: 2rem;
            padding: 2.5rem;
            max-width: 1100px;
            width: 100%;
            box-shadow: 0 15px 40px rgba(236, 72, 153, 0.25);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .title-icon {
            background: linear-gradient(135deg, #f472b6, #f9a8d4, #fbcfe8);
            padding: 0.75rem;
            border-radius: 9999px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .title-text h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #be185d;
        }

        .title-text p {
            color: #9d174d;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg,#be185d,#ec4899);
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(190,24,93,0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg,#9f1239,#be185d);
            transform: translateY(-2px);
        }

        .search {
            margin-bottom: 2rem;
        }

        .search input {
            padding: 0.75rem 1.25rem;
            border-radius: 9999px;
            border: 1px solid #fbcfe8;
            width: 100%;
            max-width: 350px;
            background-color: rgba(255, 240, 245, 0.6);
            color: #831843;
        }

        .search button {
            margin-left: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            border: none;
            background: linear-gradient(135deg,#be185d 0%,#ec4899 100%);
            color: white;
            font-weight: 700;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 1rem;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(135deg,#f472b6 0%,#ec4899 100%);
            color: white;
        }

        th, td {
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            text-align: left;
        }

        tbody tr {
            border-bottom: 1px solid #fbcfe8;
        }

        tbody tr:nth-child(even) {
            background-color: #fff0f5;
        }

        .action-cell {
            display: flex;
            gap: 0.5rem;
        }

        .btn-update {
            background: linear-gradient(135deg,#a855f7,#c084fc);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-update:hover {
            background: linear-gradient(135deg,#9333ea,#a855f7);
        }

        .btn-delete {
            background: linear-gradient(135deg,#fb7185,#f43f5e);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg,#f43f5e,#e11d48);
        }

        .bottom {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            background: #fce7f3;
            color: #9d174d;
            text-decoration: none;
        }

        .pagination strong {
            background: #ec4899;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
        }

        .btn-logout {
            background: linear-gradient(135deg,#be185d,#ec4899);
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 9999px;
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Header -->
    <div class="header">
        <div class="title">
            <div class="title-icon">
                <i class="fa-solid fa-wand-magic-sparkles text-white text-lg"></i>
            </div>
            <div class="title-text">
                <h1>User Management</h1>
                <p>Manage your magical users with sparkle ✨</p>
            </div>
        </div>
        <?php if ($role === 'admin'): ?>
            <a class="btn-primary" href="<?= site_url('users/create') ?>">Add User</a>
        <?php endif; ?>
    </div>

    <!-- Search -->
    <div class="search flex items-center">
        <form method="get" action="<?= site_url('/users') ?>" class="flex">
            <input type="text" name="q" value="<?= html_escape($_GET['q'] ?? '') ?>" placeholder="Search users..." />
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- User Table -->
    <div class="table-wrapper mt-6">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First</th>
                    <th>Last</th>
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
                            <td><?= $user['id']; ?></td>
                            <td><?= $user['first_name']; ?></td>
                            <td><?= $user['last_name']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <?php if ($role === 'admin'): ?>
                                <td>
                                    <div class="action-cell">
                                        <a class="btn-update" href="<?= site_url('users/update/' . $user['id']); ?>">Update</a>
                                        <a class="btn-delete" href="<?= site_url('users/delete/' . $user['id']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $role === 'admin' ? '5' : '4' ?>" class="text-center py-10 text-pink-700 font-semibold">
                            No users found. Try different keywords.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="bottom mt-6">
        <div class="pagination">
            <?= $page ?? '' ?>
        </div>
        <a href="<?= site_url('auth/logout'); ?>" class="btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
