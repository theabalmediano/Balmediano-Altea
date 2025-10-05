<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Kuromi Pink Coquette</title>
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
      color: #9d174d;
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
    .card {
      background: rgba(255,255,255,0.8);
      border-radius: 2rem;
      border: 1px solid #fbcfe8;
      padding: 2rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .card:hover { transform: translateY(-5px); }
    .btn-pink {
      background: linear-gradient(to right, #f472b6, #f9a8d4);
      color: white;
    }
    .btn-pink:hover {
      background: linear-gradient(to right, #f9a8d4, #f472b6);
    }
  </style>
</head>
<body class="min-h-screen relative flex flex-col">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Header -->
  <header class="relative z-10 p-6 flex justify-between items-center">
    <div class="flex items-center gap-3">
      <div class="magic-icon">
        <i class="fa-solid fa-wand-magic-sparkles text-white text-2xl"></i>
      </div>
      <h1 class="text-2xl font-bold">Kuromi Pink Dashboard</h1>
    </div>
    <a href="<?= site_url('auth/logout') ?>" class="btn-pink px-4 py-2 rounded-full font-semibold shadow-lg flex items-center gap-2 hover:scale-105 transition-all">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
  </header>

  <!-- Main Content -->
  <main class="relative z-10 flex-1 p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card Example -->
    <div class="card flex flex-col items-center justify-center text-center p-6">
      <i class="fa-solid fa-user text-4xl mb-4"></i>
      <h2 class="text-xl font-bold mb-2">Students</h2>
      <p class="text-pink-700 mb-4">Manage student accounts and info.</p>
      <a href="<?= site_url('students') ?>" class="btn-pink px-4 py-2 rounded-full font-semibold flex items-center gap-2 hover:scale-105 transition-all">
        <i class="fa-solid fa-arrow-right"></i> View
      </a>
    </div>

    <div class="card flex flex-col items-center justify-center text-center p-6">
      <i class="fa-solid fa-chalkboard-user text-4xl mb-4"></i>
      <h2 class="text-xl font-bold mb-2">Classes</h2>
      <p class="text-pink-700 mb-4">Create and manage classes.</p>
      <a href="<?= site_url('classes') ?>" class="btn-pink px-4 py-2 rounded-full font-semibold flex items-center gap-2 hover:scale-105 transition-all">
        <i class="fa-solid fa-arrow-right"></i> View
      </a>
    </div>

    <div class="card flex flex-col items-center justify-center text-center p-6">
      <i class="fa-solid fa-gear text-4xl mb-4"></i>
      <h2 class="text-xl font-bold mb-2">Settings</h2>
      <p class="text-pink-700 mb-4">Update your account and preferences.</p>
      <a href="<?= site_url('settings') ?>" class="btn-pink px-4 py-2 rounded-full font-semibold flex items-center gap-2 hover:scale-105 transition-all">
        <i class="fa-solid fa-arrow-right"></i> View
      </a>
    </div>
  </main>

</body>
</html>
