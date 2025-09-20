<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Cute Font -->
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
      background: rgba(255, 240, 245, 0.7); /* light pink overlay */
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center text-gray-800 relative">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Card -->
  <div class="relative bg-white/40 backdrop-blur-2xl p-8 rounded-3xl shadow-2xl w-full max-w-md border border-pink-200 animate-fadeIn z-10">
    
    <!-- Header -->
    <div class="flex flex-col items-center mb-6">
      <div class="bg-gradient-to-br from-pink-400 via-purple-500 to-black rounded-full p-3 shadow-md">
        <i class="fa-solid fa-wand-magic-sparkles text-white text-3xl drop-shadow-lg"></i>
      </div>
      <h2 class="text-2xl font-bold text-pink-900 mt-3">Create Your Student Account</h2>
      <p class="text-pink-700 text-sm italic">🌸 Join our Kuromi-inspired student community 🌸</p>
    </div>

    <!-- Form -->
    <form action="<?=site_url('/users/create')?>" method="POST" class="space-y-5">
      
      <!-- First Name -->
      <div>
        <label class="block text-pink-900 mb-1 font-semibold">First Name</label>
        <input type="text" name="first_name" placeholder="Enter your first name" required
               class="w-full px-4 py-3 bg-pink-50/80 text-pink-900 placeholder-pink-400 border border-pink-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm transition duration-200">
      </div>

      <!-- Last Name -->
      <div>
        <label class="block text-pink-900 mb-1 font-semibold">Last Name</label>
        <input type="text" name="last_name" placeholder="Enter your last name" required
               class="w-full px-4 py-3 bg-pink-50/80 text-pink-900 placeholder-pink-400 border border-pink-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm transition duration-200">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-pink-900 mb-1 font-semibold">Email Address</label>
        <input type="email" name="email" placeholder="Enter your email" required
               class="w-full px-4 py-3 bg-pink-50/80 text-pink-900 placeholder-pink-400 border border-pink-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm transition duration-200">
      </div>

      <!-- Sign Up Button -->
      <button type="submit"
              class="w-full bg-gradient-to-r from-pink-400 via-purple-500 to-black hover:from-pink-500 hover:to-purple-700 text-white font-semibold py-3 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
        <i class="fa-solid fa-heart mr-2"></i> Sign Up
      </button>
    </form>
  </div>
</body>
</html>
