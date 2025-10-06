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
    <title>Student Directory - Kuromi Pink Coquette</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?=base_url();?>/public/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            font-family: 'Nunito', 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffe4ec 0%, #ffd6e8 50%, #ffcce0 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            max-width: 1200px;
            width: 100%;
            padding: 2.5rem 3rem;
            box-shadow: 0 20px 60px rgba(255, 182, 193, 0.3);
            color: #d63384;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #ffd6e8;
        }

        .title {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .title-icon {
            background: linear-gradient(135deg, #ffcce0, #ffb6c1);
            padding: 1rem;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(255, 182, 193, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .title-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .title-text h1 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #d63384, #ffb6c1);
            
   
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffb6c1, #ffcce0);
            padding: 0.85rem 2rem;
            border-radius: 1rem;
            color: white;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(255, 182, 193, 0.4);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ffa6c1, #ffb6c1);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(255, 182, 193, 0.5);
        }

        .search {
            margin-bottom: 2rem;
        }

        .search form {
            display: flex;
            gap: 1rem;
        }

        .search input {
            padding: 0.85rem 1.5rem;
            border-radius: 1rem;
            border: 2px solid #ffcce0;
            flex: 1;
            background-color: rgba(255, 240, 246, 0.6);
            color: #9d174d;
            font-weight: 600;
            outline: none;
            transition: all 0.3s ease;
        }

        .search input:focus {
            border-color: #ff99b6;
            background-color: white;
        }

        .search button {
            padding: 0.85rem 1.5rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #ffb6c1, #ffcce0);
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(255, 182, 193, 0.35);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search button:hover {
            background: linear-gradient(135deg, #ffcce0, #ffb6c1);
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(255, 182, 193, 0.15);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 1.5rem;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(135deg, #ffcce0, #ffb6c1);
            color: white;
        }

        thead th {
            padding: 1rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            text-align: left;
            text-transform: uppercase;
        }

        tbody td {
            padding: 1rem 1.5rem;
            font-size: 0.95rem;
            color: #9d174d;
            border-bottom: 1px solid #ffd6e8;
            background: white;
        }

        tbody tr:nth-child(even) td {
            background-color: #fff0f6;
        }

        tbody tr:hover td {
            background: linear-gradient(90deg, #ffe4ec, #fff0f6);
        }

        .bottom {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid #ffd6e8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            color: #d63384;
            font-weight: 600;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ffd6e8, #ffcce0);
            color: white;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 6px 18px rgba(255, 182, 193, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #ffcce0, #ffb6c1);
        }

        .empty-text {
            text-align: center;
            padding: 3rem 0;
            color: #ff99b6;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="card">
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
</div>

</body>
</html>
