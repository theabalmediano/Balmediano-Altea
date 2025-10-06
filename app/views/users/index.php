<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Directory</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body { 
      font-family: 'Quicksand', sans-serif; 
      background-color: #fff0f6; /* soft pink bg */
    }
    .font-title { 
      font-family: 'Cinzel Decorative', cursive; 
      letter-spacing: 2px; 
    }
    /* Buttons */
    .btn-hover {
      transition: all .3s ease;
    }
    .btn-hover:hover { 
      box-shadow: 0 0 12px #f9a8d4, 0 0 20px #ec4899; 
      transform: scale(1.05); 
    }
    /* Logout button */
    .logout-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: 1.5rem;
      padding: 0.6rem 1rem;
      background: linear-gradient(to right, #ec4899, #d946ef);
      color: #fff;
      border-radius: 0.75rem;
      font-weight: 600;
      transition: all .3s ease;
    }
    .logout-btn:hover {
      background: linear-gradient(to right, #db2777, #a21caf);
      box-shadow: 0 0 12px #fbcfe8;
    }
    /* Pagination */
    .hp-page {
      padding: 6px 12px;
      background: #fce7f3;
      border-radius: 6px;
      color: #be185d;
      font-weight: 500;
    }
    .hp-page:hover {
      background: #f9a8d4;
      color: white;
    }
    .hp-current {
      padding: 6px 12px;
      background: #ec4899;
      border-radius: 6px;
      color: white;
      font-weight: 700;
    }
  </style>
</head>
<body class="min-h-screen">

  <!-- Header -->
  <nav class="bg-gradient-to-r from-pink-600 via-pink-400 to-pink-600 shadow-lg border-b-4 border-pink-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-pink-100 font-title text-2xl flex items-center gap-2">
        <i class="fa-solid fa-heart"></i> Student Directory
      </h1>
    </div>
  </nav>

  <!-- Content -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-pink-50 shadow-xl rounded-xl p-6 border-4 border-pink-300">

      <!-- Top Actions -->
      <div class="flex justify-between items-center mb-6">

        <!-- Search Bar -->
        <form method="get" action="<?=site_url('/users')?>" class="mb-4 flex justify-end">
          <input 
            type="text" 
            name="q" 
            value="<?=html_escape($_GET['q'] ?? '')?>" 
            placeholder="Search student..." 
            class="px-4 py-2 border border-pink-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
          <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-r-lg shadow transition-all duration-300">
            <i class="fa fa-search"></i>
          </button>
        </form>

        <!-- Add Button -->
        <a href="<?=site_url('users/create')?>"
           class="btn-hover inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-fuchsia-400 text-white font-bold px-5 py-2 rounded-lg shadow-md transition-all duration-300">
          <i class="fa-solid fa-user-plus"></i> Add New 
        </a>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-xl border-4 border-pink-300">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-pink-500 to-fuchsia-400 text-white uppercase tracking-wider font-title text-lg">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Lastname</th>
              <th class="py-3 px-4">Firstname</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="text-gray-800 text-sm">
            <?php if(!empty($users)): ?>
              <?php foreach(html_escape($users) as $user): ?>
                <tr class="hover:bg-pink-100 transition duration-200">
                  <td class="py-3 px-4 font-medium"><?=($user['id']);?></td>
                  <td class="py-3 px-4"><?=($user['last_name']);?></td>
                  <td class="py-3 px-4"><?=($user['first_name']);?></td>
                  <td class="py-3 px-4"><?=($user['email']);?></td>
                  <td class="py-3 px-4 flex justify-center gap-3">
                    <a href="<?=site_url('users/update/'.$user['id']);?>"
                       class="btn-hover bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded-lg shadow flex items-center gap-1">
                      <i class="fa-solid fa-pen-to-square"></i> Update
                    </a>
                    <a href="<?=site_url('users/delete/'.$user['id']);?>"
                       class="btn-hover bg-fuchsia-500 hover:bg-fuchsia-600 text-white px-3 py-1 rounded-lg shadow flex items-center gap-1">
                      <i class="fa-solid fa-trash"></i> Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" class="py-4 text-gray-600">No students found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-4 flex justify-center">
        <div class="pagination flex space-x-2">
          <?php
            if (!empty($page)) {
              echo str_replace(
                ['<a ', '<strong>', '</strong>'],
                ['<a class="hp-page"', '<span class="hp-current">', '</span>'],
                $page
              );
            }
          ?>
        </div>
      </div>

      <!-- Logout Button -->
      <a href="<?=site_url('auth/logout');?>"
         class="logout-btn mt-6 inline-block">
         <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>

    </div>
  </div>

</body>
</html>
