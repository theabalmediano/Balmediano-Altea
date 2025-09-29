<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/* ✅ START SESSION kung hindi pa nakastart */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ✅ CHECK LOGIN – kung walang user_id, redirect sa login */
if (!isset($_SESSION['user_id'])) {
    header("Location: " . site_url('auth/login'));
    exit;
}

/* ✅ ROLE – para sa admin check */
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>/public/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('https://i.pinimg.com/736x/bf/01/f9/bf01f9444340ecdb37af06d201c6f1cf.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    .overlay {
      background: rgba(255, 240, 245, 0.6);
    }
    .magic-icon {
      background: linear-gradient(135deg, #f472b6, #f9a8d4, #fbcfe8);
      padding: 0.5rem;
      border-radius: 9999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    .btn-pink {
      background: linear-gradient(to right, #f472b6, #f9a8d4);
      color: white;
    }
    .btn-pink:hover {
      background: linear-gradient(to right, #f9a8d4, #f472b6);
    }
    .pagination a:hover {
      background-color: #f9a8d4;
      color: #9d174d;
    }
  </style>
</head>
<body class="min-h-screen relative text-pink-900">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Container -->
  <div class="relative max-w-6xl mx-auto mt-10 px-4 z-10">

    <!-- User Table Card -->
    <div class="bg-white/40 backdrop-blur-2xl rounded-3xl p-6 border border-pink-200 shadow-2xl">

      <!-- Search & Add Button Above Table -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
        <!-- Search -->
        <form method="get" action="<?= site_url('users') ?>" class="flex w-full md:w-auto">
          <input 
            type="text" 
            name="q" 
            value="<?= html_escape($_GET['q'] ?? '') ?>" 
            placeholder="Search user..."
            class="px-4 py-2 rounded-l-full bg-pink-50/80 text-pink-900 placeholder-pink-400 border border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-500 w-full md:w-64">
          <button type="submit" 
                  class="px-4 py-2 rounded-r-full shadow-lg btn-pink transition duration-300">
            <i class="fa fa-search"></i>
          </button>
        </form>

        <!-- Add New User (Admin only) -->
        <?php if ($role === 'admin'): ?>
        <a href="<?= site_url('users/create') ?>"
           class="inline-flex items-center gap-2 font-bold px-5 py-2 rounded-full shadow-lg btn-pink transition-all duration-300 hover:scale-105">
          <i class="fa-solid fa-user-plus"></i> Add New User
        </a>
        <?php endif; ?>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-2xl border border-pink-300 shadow-lg">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-pink-400 via-pink-300 to-pink-500 text-white text-sm uppercase tracking-wide rounded-t-3xl">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Lastname</th>
              <th class="py-3 px-4">Firstname</th>
              <th class="py-3 px-4">Email</th>
              <?php if ($role === 'admin'): ?>
              <th class="py-3 px-4">Action</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody class="text-pink-900 text-sm">
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr class="hover:bg-pink-100/50 transition duration-200 rounded-lg">
                  <td class="py-3 px-4 font-medium"><?= html_escape($user['id']); ?></td>
                  <td class="py-3 px-4"><?= html_escape($user['last_name']); ?></td>
                  <td class="py-3 px-4"><?= html_escape($user['first_name']); ?></td>
                  <td class="py-3 px-4">
                    <span class="bg-pink-50/80 text-pink-900 text-sm font-semibold px-3 py-1 rounded-full">
                      <?= html_escape($user['email']); ?>
                    </span>
                  </td>
                  <?php if ($role === 'admin'): ?>
                  <td class="py-3 px-4 flex justify-center gap-3">
                    <a href="<?= site_url('users/update/'.$user['id']); ?>"
                       class="px-3 py-1 rounded-full shadow btn-pink flex items-center gap-1 transition duration-200 hover:scale-105">
                      <i class="fa-solid fa-pen-to-square"></i> Update
                    </a>
                    <a href="<?= site_url('users/delete/'.$user['id']); ?>"
                       onclick="return confirm('Are you sure you want to delete this user?');"
                       class="inline-flex items-center gap-2 px-3 py-1 rounded-full shadow btn-pink transition-all duration-300 hover:scale-105">
                       <i class="fa-solid fa-trash"></i> Delete
                    </a>
                  </td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="<?= ($role === 'admin') ? '5' : '4' ?>" class="py-4 text-pink-700 font-semibold">
                  No users found.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination & Logout -->
      <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Pagination -->
        <div class="flex justify-center pagination">
          <?php 
          if (!empty($page)) {
            echo str_replace(
              ['<ul>', '</ul>', '<li>', '</li>', '<a', '</a>'],
              [
                '<div class="flex space-x-2">',
                '</div>',
                '',
                '',
                '<a class="px-3 py-1 rounded-full bg-pink-50/80 text-pink-900 shadow transition cursor-pointer"',
                '</a>'
              ],
              $page
            );
          }
          ?>
        </div>

        <!-- Logout -->
        <a class="px-5 py-2 rounded-full shadow-lg btn-pink transition duration-300 hover:scale-105" 
           href="<?= site_url('auth/logout'); ?>">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
      </div>

    </div>

  </div>

</body>
</html>