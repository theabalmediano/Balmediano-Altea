<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Student Directory</title>

  <!-- Tailwind & Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=IM+Fell+English&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/public/style.css">

  <!-- Custom Styles -->
  <style>
    body {
      font-family: 'IM Fell English', serif;
      background-color: #fae5b3;
    }
    .font-title {
      font-family: 'Cinzel Decorative', cursive;
      letter-spacing: 2px;
    }
    .btn-hover:hover {
      box-shadow: 0 0 12px gold, 0 0 24px crimson;
      transform: scale(1.05);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

  <!-- Login Box -->
  <div class="bg-yellow-50 border-4 border-yellow-700 p-8 rounded-xl shadow-2xl w-full max-w-md">

    <!-- Title -->
    <h1 class="text-3xl font-title text-center text-red-900 mb-6 flex items-center justify-center gap-2">
      <i class="fa-solid fa-hat-wizard text-yellow-600"></i> Login
    </h1>

    <!-- Form -->
    <form method="post" class="space-y-5">
      <input 
        type="text" 
        name="username" 
        placeholder="Username" 
        required
        class="w-full px-4 py-3 border-2 border-yellow-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-white text-gray-800"
      >

      <input 
        type="password" 
        name="password" 
        placeholder="Password" 
        required
        class="w-full px-4 py-3 border-2 border-yellow-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-white text-gray-800"
      >

      <button 
        type="submit"
        class="btn-hover w-full py-3 bg-red-700 hover:bg-red-900 text-yellow-100 font-semibold rounded-lg transition duration-300"
      >
        <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
      </button>
    </form>

    <!-- Register Link -->
    <p class="text-center text-gray-700 mt-5 text-sm">
      Don't have an account? 
      <a href="<?= site_url('/') ?>" class="text-green-700 font-semibold hover:underline">Register</a>
    </p>

  </div>

</body>
</html>
