<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Directory - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css">
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
      padding: 0.6rem;
      border-radius: 9999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%,100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    .btn-pink {
      background: linear-gradient(to right, #f472b6, #f9a8d4);
      color: white;
    }
    .btn-pink:hover {
      background: linear-gradient(to right, #f9a8d4, #f472b6);
    }
    .input-pink {
      background-color: rgba(255, 240, 245, 0.8);
    }
    .input-pink:hover {
      background-color: rgba(249, 168, 212, 0.3);
    }
  </style>
</head>
<body class="min-h-screen relative text-pink-900">

  <!-- Background Overlay -->
  <div class="absolute inset-0 overlay z-0"></div>

  <!-- Container -->
  <div class="relative z-10 max-w-6xl mx-auto py-12 px-4">
    <div class="bg-white/40 backdrop-blur-2xl rounded-3xl p-8 border border-pink-200 shadow-2xl">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
          <div class="magic-icon">
            <i class="fa-solid fa-heart text-white text-xl"></i>
          </div>
          <h1 class="text-2xl font-bold text-pink-900">Student Directory</h1>
        </div>

        <!-- Logout -->
        <a href="<?=site_url('auth/logout');?>"
           class="btn-pink px-4 py-2 rounded-full shadow hover:scale-105 transition duration-300 flex items-center gap-2 text-sm">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
      </div>

      <!-- Search Bar -->
      <form method="get" action="<?=site_url('/auth/dashboard')?>" class="flex justify-end mb-6">
        <input 
          type="text" 
          name="q" 
          value="<?=html_escape($_GET['q'] ?? '')?>" 
          placeholder="Search student..." 
          class="px-4 py-2 w-64 rounded-l-full border border-pink-300 input-pink text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500">
        <button type="submit"
                class="px-4 py-2 rounded-r-full btn-pink shadow transition hover:scale-105">
          <i class="fa fa-search"></i>
        </button>
      </form>

      <!-- Table -->
      <div class="overflow-x-auto border border-pink-300 rounded-2xl shadow-lg">
        <table class="min-w-full text-center border-collapse text-pink-900 bg-white/50">
          <thead class="bg-pink-200/70 text-pink-800 text-sm uppercase">
            <tr>
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Last Name</th>
              <th class="py-3 px-4">First Name</th>
              <th class="py-3 px-4">Email</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($users)): ?>
              <?php foreach(html_escape($users) as $user): ?>
                <tr class="hover:bg-pink-100 transition">
                  <td class="py-3 px-4"><?=($user['id']);?></td>
                  <td class="py-3 px-4"><?=($user['last_name']);?></td>
                  <td class="py-3 px-4"><?=($user['first_name']);?></td>
                  <td class="py-3 px-4"><?=($user['email']);?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="py-4 italic text-pink-700">No students found 💔</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination + Back -->
      <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
        <div class="pagination flex flex-wrap gap-2">
          <?php
            if (!empty($page)) {
              echo str_replace(
                ['<a ', '<strong>', '</strong>'],
                [
                  '<a class="px-3 py-1 rounded-full border border-pink-300 text-pink-700 hover:bg-pink-200 transition"',
                  '<span class="bg-pink-500 text-white px-3 py-1 rounded-full">',
                  '</span>'
                ],
                $page
              );
            }
          ?>
        </div>



    </div>
  </div>

</body>
</html>
