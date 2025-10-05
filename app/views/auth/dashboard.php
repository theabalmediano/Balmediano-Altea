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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
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
      background: linear-gradient(135deg, rgba(251, 207, 232, 0.7) 0%, rgba(253, 242, 248, 0.65) 50%, rgba(249, 168, 212, 0.6) 100%);
      backdrop-filter: blur(2px);
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(244, 114, 182, 0.2);
    }
    .btn-pink {
      background: linear-gradient(135deg, #ec4899 0%, #f472b6 50%, #f9a8d4 100%);
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
    }
    .btn-pink:hover {
      background: linear-gradient(135deg, #db2777 0%, #ec4899 50%, #f472b6 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(236, 72, 153, 0.4);
    }
    .input-pink {
      background-color: rgba(255, 255, 255, 0.85);
      border: 2px solid rgba(244, 114, 182, 0.3);
      transition: all 0.3s ease;
    }
    .input-pink:hover {
      background-color: rgba(255, 255, 255, 0.95);
      border-color: rgba(244, 114, 182, 0.5);
    }
    .input-pink:focus {
      background-color: rgba(255, 255, 255, 1);
      outline: none;
      border-color: #f472b6;
      box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.1);
    }
    .table-header {
      background: linear-gradient(135deg, #f472b6 0%, #ec4899 100%);
    }
    tbody tr {
      transition: all 0.2s ease;
    }
    tbody tr:hover {
      background-color: rgba(251, 207, 232, 0.4);
      transform: scale(1.005);
    }
    .icon-badge {
      background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
      box-shadow: 0 2px 8px rgba(236, 72, 153, 0.2);
    }
    .beta-badge {
      background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
      box-shadow: 0 2px 6px rgba(236, 72, 153, 0.15);
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }
    .search-icon {
      color: #f472b6;
    }
    .pagination-link {
      transition: all 0.2s ease;
      display: inline-block;
      padding: 0.25rem 0.5rem;
      border-radius: 0.5rem;
    }
    .pagination-link:hover {
      background-color: rgba(251, 207, 232, 0.5);
      transform: translateY(-1px);
    }
    .no-data-icon {
      font-size: 3rem;
      color: #f9a8d4;
      opacity: 0.6;
    }
  </style>
</head>
<body class="min-h-screen relative text-pink-900">

  <div class="absolute inset-0 overlay"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 z-10">

    <!-- Header -->
    <header class="glass-card rounded-3xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-xl">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
          <span class="icon-badge inline-flex items-center justify-center w-12 h-12 text-pink-600 rounded-2xl">
            <i class="fa-solid fa-user-graduate text-xl"></i>
          </span>
          <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-pink-400 flex items-center gap-2">
              Student Directory
              <span class="beta-badge text-xs sm:text-sm text-pink-700 font-semibold px-3 py-1 rounded-full">Beta</span>
            </h1>
            <p class="text-xs sm:text-sm text-pink-600 mt-1 font-medium">Manage your students with style ✨</p>
          </div>
        </div>

        <a href="<?=site_url('auth/logout')?>" class="btn-pink px-5 sm:px-6 py-2.5 rounded-full font-semibold flex items-center gap-2 text-sm sm:text-base">
          <i class="fa-solid fa-right-from-bracket"></i> 
          <span>Logout</span>
        </a>
      </div>
    </header>

    <!-- Search -->
    <div class="glass-card rounded-3xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-xl">
      <form method="get" action="<?=site_url('/auth/dashboard')?>" class="relative">
        <div class="relative">
          <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 transform -translate-y-1/2 search-icon text-lg"></i>
          <input
            type="text"
            name="q"
            value="<?=html_escape($_GET['q'] ?? '')?>"
            placeholder="Search by name, email, or ID..."
            class="w-full pl-14 pr-4 py-3 sm:py-3.5 rounded-2xl input-pink text-pink-900 placeholder-pink-400 font-medium text-sm sm:text-base"
          />
        </div>
      </form>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-3xl shadow-2xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full min-w-[480px] text-pink-900">
          <thead class="table-header text-white">
            <tr>
              <th class="py-4 px-4 text-left font-semibold text-xs sm:text-sm uppercase tracking-wider">
                <i class="fa-solid fa-hashtag mr-2"></i>ID
              </th>
              <th class="py-4 px-4 text-left font-semibold text-xs sm:text-sm uppercase tracking-wider">
                <i class="fa-solid fa-user mr-2"></i>Last Name
              </th>
              <th class="py-4 px-4 text-left font-semibold text-xs sm:text-sm uppercase tracking-wider">
                <i class="fa-solid fa-user mr-2"></i>First Name
              </th>
              <th class="py-4 px-4 text-left font-semibold text-xs sm:text-sm uppercase tracking-wider">
                <i class="fa-solid fa-envelope mr-2"></i>Email
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-pink-200">
            <?php if(!empty($users)): ?>
              <?php foreach(html_escape($users) as $user): ?>
                <tr class="text-xs sm:text-sm">
                  <td class="py-4 px-4 font-semibold text-pink-700"><?= $user['id'] ?></td>
                  <td class="py-4 px-4 font-medium"><?= $user['last_name'] ?></td>
                  <td class="py-4 px-4 font-medium"><?= $user['first_name'] ?></td>
                  <td class="py-4 px-4 text-pink-600 break-words"><?= $user['email'] ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="py-12 text-center">
                  <i class="fa-solid fa-inbox no-data-icon block mb-3"></i>
                  <p class="text-pink-600 font-semibold text-base sm:text-lg">No students found</p>
                  <p class="text-pink-500 text-xs sm:text-sm mt-1">Try adjusting your search criteria</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <?php if (!empty($page)): ?>
    <div class="mt-6 sm:mt-8 glass-card rounded-2xl p-4 shadow-lg">
      <div class="text-center text-pink-700 font-semibold text-sm sm:text-base">
        <?php 
          echo str_replace(
            ['<a ', '<strong>', '</strong>'],
            [
              '<a class="pagination-link text-pink-600 font-semibold underline decoration-2 hover:text-pink-700 mx-1"',
              '<span class="pagination-link font-bold text-pink-700 bg-pink-200 px-3 py-1 rounded-lg">',
              '</span>'
            ],
            $page
          );
        ?>
      </div>
    </div>
    <?php endif; ?>

  </div>

</body>
</html>