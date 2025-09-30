<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
// ✅ Start session kung hindi pa naka-start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Redirect kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . site_url('auth/login'));
    exit;
}

// Para maiwasan notice error kung walang role
$role = $_SESSION['role'] ?? null;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <link rel="stylesheet" href="<?=base_url();?>/public/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: left; 
            color: #333;
            font-size: 2.5em; 
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f1f1f1;
        }

        a.update-btn {
            color: #3498db; 
            text-decoration: none;
            font-weight: bold;
        }

        a.update-btn:hover {
            text-decoration: underline;
        }

        a.delete-btn {
            color: #e74c3c; 
            text-decoration: none;
            font-weight: bold;
        }

        a.delete-btn:hover {
            text-decoration: underline;
        }

        .create-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #c26dadff; 
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .create-btn:hover {
            background: #cfacbdff;
        }
    </style>
</head>
<body>
    
<!-- Search Bar -->
<form method="get" action="<?=site_url('/users')?>" class="mb-4 flex justify-end" style="margin-right: 0.9in;">

    <input 
      type="text" 
      name="q" 
      value="<?=html_escape($_GET['q'] ?? '')?>" 
      placeholder="Search user..." 
      class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r-lg shadow transition-all duration-300">
      🔍
    </button>
</form>


    <div class="container">
        <div class="header">
            <h1 class="text-4xl font-bold text-left">User List</h1>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <a class="create-btn" href="<?=site_url('users/create');?>">Create Record</a>
            <?php endif; ?>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <?php if ($_SESSION['role'] === 'admin'): ?>
        <th>Action</th>
      <?php endif; ?>

            </tr>
            <?php foreach(html_escape($users) as $user): ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['first_name']; ?></td>
                    <td><?= $user['last_name']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

                    <td>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

                        <a class="update-btn" href="<?= site_url('users/update/'.$user['id']); ?>">Update</a> | 
                        <a class="delete-btn" href="<?= site_url('users/delete/'.$user['id']); ?>">Delete</a>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
         <!-- Pagination and Logout at bottom of container -->
<div class="mt-4 flex justify-between items-center">
    <!-- Pagination left -->
    <div class="pagination flex space-x-2">
        <?=$page ?? ''?>
    </div>

    <!-- Logout button right -->
    <a class="create-btn bg-red-500 hover:bg-red-600" href="<?=site_url('auth/logout');?>">Logout</a>
</div>


</div>
<style>
   

</style>

</body>
</html>
