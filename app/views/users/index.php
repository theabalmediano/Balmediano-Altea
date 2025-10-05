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
    <meta charset="UTF-8" />
    <title>Kuromi Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            font-family: 'Nunito', 'Quicksand', sans-serif;
            background: #fff0f6;
            min-height: 100vh;
            padding: 2.5rem 1rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .card {
            background: white;
            border-radius: 2rem;
            max-width: 1100px;
            width: 100%;
            padding: 2.5rem 3rem;
            box-shadow: 0 15px 40px rgba(236, 72, 153, 0.25);
            color: #be185d;
        }
        .header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
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
            box-shadow: 0 10px 25px rgba(219, 39, 119, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .title-icon i {
            color: white;
            font-size: 1.25rem;
        }
        .title-text h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #be185d;
            margin: 0;
        }
        .title-text p {
            color: #db2777;
            font-size: 1rem;
            margin: 0;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(135deg,#be185d,#ec4899);
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            color: white;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 6px 18px rgba(236, 72, 153, 0.45);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg,#9f1239,#be185d);
            transform: translateY(-2px);
        }
        .search {
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .search input[type="text"] {
            padding: 0.7rem 1.25rem;
            border-radius: 9999px;
            border: 2px solid #f9a8d4;
            width: 280px;
            background-color: #fff0f6;
            color: #831843;
            font-weight: 600;
            font-size: 1rem;
            outline-offset: 3px;
        }
        .search input:focus {
            border-color: #db2777;
            box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.25);
        }
        .search button {
            padding: 0.7rem 1.5rem;
            border-radius: 9999px;
            border: none;
            background: linear-gradient(135deg,#be185d 0%,#ec4899 100%);
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(236, 72, 153, 0.45);
        }
        .search button:hover {
            background: linear-gradient(135deg,#ec4899 0%,#be185d 100%);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(219, 39, 119, 0.1);
        }
        thead {
            background: linear-gradient(135deg,#f472b6 0%,#ec4899 100%);
            color: white;
        }
        thead th {
            padding: 1rem 1.5rem;
            font-weight: 700;
            font-size: 1rem;
            text-align: left;
        }
        tbody td {
            padding: 1.25rem 1.5rem;
            font-size: 0.95rem;
            color: #831843;
            border-bottom: 1px solid #fbcfe8;
        }
        tbody tr:nth-child(even) {
            background-color: #fff0f5;
        }
        tbody tr:hover {
            background-color: #f9a8d4;
            color: #6b0218;
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
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        .btn-update:hover {
            background: linear-gradient(135deg,#9333ea,#a855f7);
        }
        .btn-delete {
            background: linear-gradient(135deg,#fb7185,#f43f5e);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(251, 113, 133, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        .btn-delete:hover {
            background: linear-gradient(135deg,#f43f5e,#e11d48);
        }
        .bottom {
            margin-top: 2.5rem;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            color: #be185d;
            font-weight: 600;
        }
        .pagination a {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            background: #fce7f3;
            color: #9d174d;
            text-decoration: none;
            font-weight: 700;
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
        .btn-logout {
            background: linear-gradient(135deg,#be185d,#ec4899);
            color: white;
            font-weight: 700;
            padding: 0.65rem 1.75rem;
            border-radius: 9999px;
            box-shadow: 0 6px 18px rgba(236, 72, 153, 0.45);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-logout:hover {
            background: linear-gradient(135deg,#ec4899,#be185d);
        }
        .empty-text {
            text-align: center;
            padding: 3rem 0;
            color: #be185d;
            font-weight: 700;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Header -->
    <div class="header">
        <div class="title">
            <div class="title-icon">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="title-text">
                <h1>User Management</h1>
                <p>Manage your magical users with sparkle ✨</p>
            </div>
        </div>
        <?php if ($role === 'admin'): ?>
            <a class="btn-primary" href="<?= site_url('users/create') ?>">
                <i class="fa-solid fa-plus"></i> Add User
            </a>
        <?php endif; ?>
    </div>

    <!-- Search -->
    <div class="search">
        <form method="get" action="<?= site_url('/users') ?>" class="flex flex-wrap gap-2">
            <input
              type="text"
              name="q"
              value="<?= html_escape($_GET['q'] ?? '') ?>"
              placeholder="Search users..."
              aria-label="Search users"
            />
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <!-- User Table -->
    <div class="table-wrapper overflow-x-auto">
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
                                        <a class="btn-update" href="<?= site_url('users/update/' . $user['id']); ?>">
                                            <i class="fa-solid fa-pen-to-square"></i> Update
                                        </a>
                                        <a class="btn-delete" href="<?= site_url('users/delete/' . $user['id']); ?>" onclick="return confirm('Are you sure?')">
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
                            No users found. Try different keywords.
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
</div>

</body>
</html>
