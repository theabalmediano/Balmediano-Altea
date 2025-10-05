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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Nunito', 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 50%, #f9a8d4 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            pointer-events: none;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            max-width: 1200px;
            width: 100%;
            padding: 2.5rem 3rem;
            box-shadow: 0 20px 60px rgba(236, 72, 153, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.5);
            color: #be185d;
            position: relative;
            z-index: 1;
        }
        
        .header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            gap: 1.5rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #fce7f3;
        }
        
        .title {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        
        .title-icon {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            padding: 1rem;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(219, 39, 119, 0.35);
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
            background: linear-gradient(135deg, #be185d, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .title-text p {
            color: #db2777;
            font-size: 1rem;
            margin: 0.25rem 0 0 0;
            font-weight: 600;
            opacity: 0.9;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #be185d, #ec4899);
            padding: 0.85rem 2rem;
            border-radius: 1rem;
            color: white;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(236, 72, 153, 0.4);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #9f1239, #be185d);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(236, 72, 153, 0.5);
        }
        
        .search {
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .search form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
        }
        
        .search input[type="text"] {
            padding: 0.85rem 1.5rem;
            border-radius: 1rem;
            border: 2px solid #f9a8d4;
            flex: 1;
            min-width: 280px;
            background-color: rgba(255, 240, 246, 0.6);
            color: #831843;
            font-weight: 600;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .search input:focus {
            border-color: #ec4899;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
        }
        
        .search button {
            padding: 0.85rem 2rem;
            border-radius: 1rem;
            border: none;
            background: linear-gradient(135deg, #be185d, #ec4899);
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(236, 72, 153, 0.35);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .search button:hover {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.45);
        }
        
        .table-wrapper {
            overflow-x: auto;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(219, 39, 119, 0.15);
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 1.5rem;
            overflow: hidden;
        }
        
        thead {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            color: white;
        }
        
        thead th {
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            font-size: 1rem;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
        
        tbody td {
            padding: 1.25rem 1.5rem;
            font-size: 0.95rem;
            color: #831843;
            border-bottom: 1px solid #fce7f3;
            background: white;
            transition: all 0.3s ease;
        }
        
        tbody tr {
            transition: all 0.3s ease;
        }
        
        tbody tr:nth-child(even) td {
            background-color: #fef3f7;
        }
        
        tbody tr:hover td {
            background: linear-gradient(90deg, #fce7f3, #fdf2f8);
            transform: scale(1.01);
        }
        
        .action-cell {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }
        
        .btn-update {
            background: linear-gradient(135deg, #a855f7, #c084fc);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(168, 85, 247, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-update:hover {
            background: linear-gradient(135deg, #9333ea, #a855f7);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(168, 85, 247, 0.45);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #fb7185, #f43f5e);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(251, 113, 133, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #f43f5e, #e11d48);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(251, 113, 133, 0.45);
        }
        
        .bottom {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid #fce7f3;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            color: #be185d;
            font-weight: 600;
        }
        
        .pagination {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .pagination a {
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            background: #fce7f3;
            color: #9d174d;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .pagination a:hover {
            background: #ec4899;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }
        
        .pagination strong {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #be185d, #ec4899);
            color: white;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 6px 18px rgba(236, 72, 153, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-logout:hover {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.5);
        }
        
        .empty-text {
            text-align: center;
            padding: 4rem 0;
            color: #be185d;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .card {
                padding: 2rem 1.5rem;
            }
            
            .title-text h1 {
                font-size: 1.5rem;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .action-cell {
                flex-direction: column;
            }
            
            .bottom {
                flex-direction: column;
                align-items: flex-start;
            }
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
        <form method="get" action="<?= site_url('/users') ?>">
            <input
              type="text"
              name="q"
              value="<?= html_escape($_GET['q'] ?? '') ?>"
              placeholder="🔍 Search users by name or email..."
              aria-label="Search users"
            />
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
        </form>
    </div>

    <!-- User Table -->
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
                                        <a class="btn-delete" href="<?= site_url('users/delete/' . $user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?')">
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
                            <i class="fa-solid fa-search" style="font-size: 2rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
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