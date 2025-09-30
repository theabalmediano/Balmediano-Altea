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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url();?>/public/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://i.pinimg.com/736x/bf/01/f9/bf01f9444340ecdb37af06d201c6f1cf.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #7f1d64; /* deep pink-purple text */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(255, 240, 245, 0.6);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 10;
            max-width: 900px;
            width: 100%;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid #f9a8d4;
            box-shadow: 0 15px 30px rgba(249, 168, 212, 0.3);
            padding: 2rem 2.5rem;
        }

        h1 {
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            color: #a72e6e;
            margin-bottom: 1rem;
        }

        /* Search bar */
        .search-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
        }
        .search-bar input[type="text"] {
            width: 280px;
            padding: 0.75rem 1rem;
            border-radius: 9999px 0 0 9999px;
            border: 2px solid #f9a8d4;
            background-color: rgba(255, 240, 245, 0.8);
            color: #7f1d64;
            font-weight: 600;
            outline: none;
            transition: background-color 0.3s;
        }
        .search-bar input[type="text"]:focus {
            background-color: rgba(249, 168, 212, 0.4);
        }
        .search-bar button {
            padding: 0.75rem 1.2rem;
            border-radius: 0 9999px 9999px 0;
            border: 2px solid #f9a8d4;
            background: linear-gradient(to right, #f472b6, #f9a8d4);
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-bar button:hover {
            background: linear-gradient(to right, #f9a8d4, #f472b6);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.8rem;
            font-weight: 600;
            color: #7f1d64;
        }

        th {
            padding: 1rem 1.5rem;
            background-color: #f9a8d4;
            color: #601e45;
            font-weight: 700;
            text-align: center;
            border-radius: 1rem 1rem 0 0;
        }

        td {
            padding: 1rem 1.5rem;
            background-color: rgba(249, 168, 212, 0.3);
            text-align: center;
            border-bottom: 0.3rem solid transparent;
            border-radius: 0 0 1rem 1rem;
            transition: background-color 0.3s;
        }

        tbody tr:hover td {
            background-color: rgba(249, 168, 212, 0.6);
        }

        /* Action buttons */
        a.update-btn,
        a.delete-btn,
        a.create-btn {
            font-weight: 700;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 6px 12px rgba(249, 168, 212, 0.4);
            transition: transform 0.3s;
        }

        a.create-btn {
            background: linear-gradient(to right, #f472b6, #f9a8d4);
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            box-shadow: 0 10px 25px rgba(249, 168, 212, 0.7);
        }
        a.create-btn:hover {
            background: linear-gradient(to right, #f9a8d4, #f472b6);
            transform: scale(1.05);
        }

        a.update-btn {
            color: #7f1d64;
            background-color: rgba(249, 168, 212, 0.5);
        }
        a.update-btn:hover {
            background-color: rgba(249, 168, 212, 0.8);
            color: #601e45;
            transform: scale(1.05);
        }

        a.delete-btn {
            color: #e11d48;
            background-color: rgba(255, 105, 180, 0.3);
        }
        a.delete-btn:hover {
            background-color: rgba(255, 105, 180, 0.6);
            color: #b91c1c;
            transform: scale(1.05);
        }

        /* Pagination + Logout */
        .bottom-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }

        .pagination {
            color: #7f1d64;
            font-weight: 700;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            border: 2px solid #f9a8d4;
            margin: 0 0.3rem;
            border-radius: 9999px;
            color: #7f1d64;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #f9a8d4;
            color: #601e45;
        }

        .logout-btn {
            background: linear-gradient(to right, #f472b6, #f9a8d4);
            color: white;
            font-weight: 700;
            padding: 0.6rem 1.5rem;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(249, 168, 212, 0.7);
            transition: transform 0.3s;
        }

        .logout-btn:hover {
            background: linear-gradient(to right, #f9a8d4, #f472b6);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="container">

    <!-- Search Bar -->
    <form method="get" action="<?=site_url('/users')?>" class="search-bar" role="search" aria-label="Search users">
        <input type="text" name="q" value="<?=html_escape($_GET['q'] ?? '')?>" placeholder="🔍 Search user..." />
        <button type="submit" aria-label="Search">Go</button>
    </form>

    <div class="flex justify-between items-center mb-6">
        <h1>Kuromi User List</h1>
        <?php if ($role === 'admin'): ?>
            <a class="create-btn" href="<?=site_url('users/create');?>">
                <i class="fa-solid fa-plus"></i> Add User
            </a>
        <?php endif; ?>
    </div>

    <table role="table" aria-label="User List">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Email</th>
                <?php if ($role === 'admin'): ?>
                    <th scope="col">Action</th>
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
                    <?php if ($role === 'admin'): ?>
                        <td>
                            <a class="update-btn" href="<?= site_url('users/update/'.$user['id']); ?>">✏️ Update</a> |
                            <a class="delete-btn" href="<?= site_url('users/delete/'.$user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">🗑️ Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="bottom-bar">
        <div class="pagination" aria-label="Pagination Links">
            <?= $page ?? '' ?>
        </div>
        <a href="<?=site_url('auth/logout');?>" class="logout-btn" role="button" aria-label="Logout">
            🚪 Logout
        </a>
    </div>
</div>

</body>
</html>
