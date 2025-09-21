<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Student - Kuromi Pink Coquette</title>
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
<body class="min-h-screen flex items-center justify-center relative text-pink-900">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Container -->
  <div class="relative w-full max-w-md mx-auto p-6 z-10">
    <div class="bg-white/40 backdrop-blur-2xl rounded-3xl p-8 border border-pink-200 shadow-2xl">
      
      <!-- Header -->
      <div class="flex flex-col items-center mb-6">
        <div class="magic-icon mb-3">
          <i class="fa-solid fa-wand-magic-sparkles text-white text-3xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-pink-900">Create Student Account</h2>
        <p class="text-pink-700 text-sm italic mt-1">🌸 Join our Kuromi-inspired student community 🌸</p>
      </div>

      <!-- Form -->
      <form action="<?=site_url('/users/create')?>" method="POST" class="space-y-5">
        <!-- First Name -->
        <div>
          <label class="block mb-1 font-semibold text-pink-900">First Name</label>
          <input type="text" name="first_name" placeholder="Enter first name" required
                 class="w-full px-4 py-3 rounded-full border border-pink-300 input-pink text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition">
        </div>

        <!-- Last Name -->
        <div>
          <label class="block mb-1 font-semibold text-pink-900">Last Name</label>
          <input type="text" name="last_name" placeholder="Enter last name" required
                 class="w-full px-4 py-3 rounded-full border border-pink-300 input-pink text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition">
        </div>

        <!-- Email -->
        <div>
          <label class="block mb-1 font-semibold text-pink-900">Email Address</label>
          <input type="email" name="email" placeholder="Enter email" required
                 class="w-full px-4 py-3 rounded-full border border-pink-300 input-pink text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition">
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 mt-6">
          <button type="submit"
                  class="flex-1 px-5 py-3 rounded-full font-semibold shadow-lg btn-pink transition-all duration-300 hover:scale-105">
            <i class="fa-solid fa-heart mr-2"></i> Sign Up
          </button>
          <a href="<?=site_url()?>"
             class="flex-1 px-5 py-3 rounded-full font-semibold shadow-lg bg-pink-50/80 text-pink-900 border border-pink-300 hover:bg-pink-100 transition duration-300 text-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
