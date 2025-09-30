<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center relative">
  <div class="absolute inset-0 bg-pink-100/40"></div>
  <div class="relative w-full max-w-sm p-6 z-10">
    <div class="bg-white/40 backdrop-blur-2xl rounded-3xl p-8 border border-pink-200 shadow-2xl">
      <h2 class="text-2xl font-bold text-center text-pink-900 mb-6">
        <i class="fa-solid fa-user-plus text-pink-500 mr-2"></i> Register
      </h2>

      <!-- Display errors -->
      <?php if(!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
          <ul class="list-disc list-inside">
            <?php foreach($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" class="space-y-5">
        <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-3 rounded-full border border-pink-300 input-pink text-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500"/>
        <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 rounded-full border border-pink-300 input-pink text-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500"/>
        <select name="role" required class="w-full px-4 py-3 rounded-full border border-pink-300 input-pink text-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <button type="submit" class="w-full py-3 rounded-full font-semibold bg-gradient-to-r from-pink-400 to-pink-300 text-white hover:scale-105 transition-all">
          <i class="fa-solid fa-scroll mr-2"></i> Register
        </button>
      </form>

      <p class="text-center text-pink-700 mt-5 text-sm">
        Already have an account? 
        <a href="<?= site_url('auth/login') ?>" class="font-semibold underline hover:text-pink-900">Login</a>
      </p>
    </div>
  </div>
</body>
</html>
