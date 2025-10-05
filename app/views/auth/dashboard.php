<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - Kuromi Pink Coquette</title>
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
    }
    .overlay {
      background: rgba(255, 240, 245, 0.6);
    }
    .btn-pink {
      background: linear-gradient(to right, #f472b6, #f9a8d4);
      color: white;
      transition: background 0.3s ease;
    }
    .btn-pink:hover {
      background: linear-gradient(to right, #f9a8d4, #f472b6);
    }
    .input-pink {
      background-color: rgba(255, 240, 245, 0.8);
      transition: background-color 0.3s ease;
    }
    .input-pink:hover,
    .input-pink:focus {
      background-color: rgba(249, 168, 212, 0.3);
      outline: none;
      box-shadow: 0 0 0 2px #f472b6;
    }
  </style>
</head>
<body class="min-h-screen relative text-pink-900">

  <div class="absolute inset-0 overlay"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 z-10">

    <!-- Header -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-4">
      <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-2 sm:gap-3">
        <!-- Minimalist creative icon -->
        <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-200 text-pink-700 rounded-full shadow-sm">
          <i class="fa-solid fa-user-graduate text-sm sm:text-base"></i>
        </span>
        <span>Student Directory</span>
        <!-- Optional tag/label -->
        <span class="ml-2 text-xs sm:text-sm bg-pink-100 text-pink-700 font-semibold px-2 py-0.5 rounded-full">Beta</span>
      </h1>

      <a href="<?=site_url('auth/logout')?>" class="btn-pink px-4 sm:px-5 py-2 rounded-full shadow-md hover:scale-105 transition text-sm sm:text-base">
        <i class="fa-solid fa-right-from-bracket mr-1 sm:mr-2"></i> Logout
      </a>
    </header>

    <!-- Search -->
    <form method="get" action="<?=site_url('/auth/dashboard')?>" class="mb-6 sm:mb-8">
      <input
        type="text"
        name="q"
        value="<?=html_escape($_GET['q'] ?? '')?>"
        placeholder="Search student..."
        class="w-full sm:max-w-md px-4 py-2 sm:px-5 sm:py-3 rounded-full border border-pink-300 input-pink text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500"
      />
    </form>

    <!-- Table -->
    <div class="overflow-x-auto bg-white/40 backdrop-blur-xl rounded-3xl border border-pink-300 shadow-2xl">
      <table class="w-full min-w-[480px] text-center text-pink-900 rounded-3xl">
        <thead class="bg-pink-400 text-pink-50 rounded-t-3xl">
          <tr>
            <th class="py-2 sm:py-3 rounded-tl-3xl text-xs sm:text-base">ID</th>
            <th class="py-2 sm:py-3 text-xs sm:text-base">Last Name</th>
            <th class="py-2 sm:py-3 text-xs sm:text-base">First Name</th>
            <th class="py-2 sm:py-3 rounded-tr-3xl text-xs sm:text-base">Email</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($users)): ?>
            <?php foreach(html_escape($users) as $user): ?>
              <tr class="hover:bg-pink-100/60 transition text-xs sm:text-sm">
                <td class="py-2 sm:py-3 border-t border-pink-300"><?= $user['id'] ?></td>
                <td class="py-2 sm:py-3 border-t border-pink-300"><?= $user['last_name'] ?></td>
                <td class="py-2 sm:py-3 border-t border-pink-300"><?= $user['first_name'] ?></td>
                <td class="py-2 sm:py-3 border-t border-pink-300 break-words"><?= $user['email'] ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" class="py-6 text-pink-600 text-sm sm:text-base">No students found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 sm:mt-8 text-center text-pink-700 font-semibold text-sm sm:text-base">
      <?php if (!empty($page)) {
        echo str_replace(
          ['<a ', '<strong>', '</strong>'],
          [
            '<a class="text-pink-600 font-semibold underline mx-1 text-sm sm:text-base"',
            '<span class="font-bold text-pink-700 underline">',
            '</span>'
          ],
          $page
        );
      } ?>
    </div>

  </div>

</body>
</html>
