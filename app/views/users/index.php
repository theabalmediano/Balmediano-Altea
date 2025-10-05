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
    <meta charset="UTF-8" />
    <title>Kuromi User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url();?>/public/style.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 25%, #f9a8d4 50%, #f472b6 75%, #ec4899 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1100px;
            width: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(254, 242, 242, 0.9) 100%);
            backdrop-filter: blur(30px);
            border-radius: 2rem;
            border: 2px solid rgba(236, 72, 153, 0.3);
            box-shadow: 0 20px 60px rgba(236, 72, 153, 0.25);
            padding: 2.5rem;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        h1 {
            font-weight: 700;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #be185d 0%, #ec4899 50%, #f9a8d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: #be185d;
            font-weight: 500;
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        .search-section {
            background: white;
            border: 2px solid rgba(236, 72, 153, 0.3);
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.1);
        }

        .search-label {
            font-weight: 600;
            color: #be185d;
            margin-bottom: 0.75rem;
            display: block;
            font-size: 0.95rem;
        }

        .search-bar {
            display: flex;
            gap: 0.5rem;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 0.875rem 1.25rem;
            border-radius: 9999px;
            border: 2px solid rgba(236, 72, 153, 0.3);
            background-color: white;
            color: #831843;
            font-weight: 500;
            outline: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .search-bar input[type="text"]:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
        }

        .search-bar button {
            padding: 0.875rem 2rem;
            border-radius: 9999px;
            border: none;
            background: linear-gradient(135deg, #be185d 0%, #ec4899 100%);
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(190, 24, 93, 0.4);
        }

        .search-bar button:hover {
            background: linear-gradient(135deg, #9f1239 0%, #be185d 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.5);
        }

        .btn-create {
            background: linear-gradient(135deg, #be185d 0%, #ec4899 100%);
            color: white;
            font-weight: 700;
            padding: 0.875rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(190, 24, 93, 0.4);
            transition: all 0.3s;
            display: inline-block;
            font-size: 0.95rem;
        }

        .btn-create:hover {
            background: linear-gradient(135deg, #9f1239 0%, #be185d 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.5);
        }

        .table-wrapper {
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.1);
            border: 2px solid rgba(236, 72, 153, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #831843;
        }

        thead {
            background: linear-gradient(135deg, #f472b6 0%, #ec4899 100%);
        }

        th {
            padding: 1.25rem 1.5rem;
            color: white;
            font-weight: 700;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tbody tr {
            transition: all 0.2s ease;
            background: white;
        }

        tbody tr:nth-child(even) {
            background: rgba(252, 231, 243, 0.4);
        }

        tbody tr:hover {
            background: rgba(249, 168, 212, 0.3);
            transform: scale(1.002);
        }

        td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(236, 72, 153, 0.1);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .action-cell {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-update {
            background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            font-size: 0.85rem;
            box-shadow: 0 2px 8px rgba(168, 85, 247, 0.3);
        }

        .btn-update:hover {
            background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(168, 85, 247, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #fb7185 0%, #f43f5e 100%);
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            font-size: 0.85rem;
            box-shadow: 0 2px 8px rgba(251, 113, 133, 0.3);
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(251, 113, 133, 0.4);
        }

        .bottom-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .pagination {
            color: #831843;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            border: 2px solid rgba(236, 72, 153, 0.3);
            margin: 0 0.25rem;
            border-radius: 9999px;
            color: #831843;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .pagination a:hover {
            background: rgba(249, 168, 212, 0.4);
            border-color: #ec4899;
            transform: translateY(-2px);
        }

        .pagination strong {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #be185d 0%, #ec4899 100%);
            color: white;
            border-radius: 9999px;
            margin: 0 0.25rem;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(190, 24, 93, 0.3);
        }

        .btn-logout {
            background: linear-gradient(135deg, #be185d 0%, #ec4899 100%);
            color: white;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(190, 24, 93, 0.4);
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #9f1239 0%, #be185d 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(190, 24, 93, 0.5);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }

            .bottom-section {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header-section">
        <div>
            <h1>User Management</h1>
            <p class="subtitle">Manage your users with ease ♡</p>
        </div>
        <?php if ($role === 'admin'): ?>
            <a class="btn-create" href="<?=site_url('users/create');?>">
                Add New User
            </a>
        <?php endif; ?>
    </div>

    <div class="search-section">
        <label class="search-label">Search Users</label>
        <form method="get" action="<?=site_url('/users')?>" class="search-bar">
            <input type="text" name="q" value="<?=html_escape($_GET['q'] ?? '')?>" placeholder="Type name, email, or ID..." />
            <button type="submit">Search</button>
        </form>
    </div>

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
                <?php if(!empty($users)): ?>
                    <?php foreach(html_escape($users) as $user): ?>
                        <tr>
                            <td style="font-weight: 700; color: #be185d;"><?= $user['id']; ?></td>
                            <td><?= $user['first_name']; ?></td>
                            <td><?= $user['last_name']; ?></td>
                            <td style="color: #be185d;"><?= $user['email']; ?></td>
                            <?php if ($role === 'admin'): ?>
                                <td>
                                    <div class="action-cell">
                                        <a class="btn-update" href="<?= site_url('users/update/'.$user['id']); ?>">Update</a>
                                        <a class="btn-delete" href="<?= site_url('users/delete/'.$user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $role === 'admin' ? '5' : '4' ?>" style="text-align: center; padding: 3rem; color: #be185d;">
                            <p style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem;">No users found</p>
                            <p style="font-weight: 500; font-size: 0.9rem; color: #ec4899;">Try searching with different keywords</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="bottom-section">
        <div class="pagination">
            <?= $page ?? '' ?>
        </div>
        <a href="<?=site_url('auth/logout');?>" class="btn-logout">
            Logout
        </a>
    </div>

</div>

</body>
</html>