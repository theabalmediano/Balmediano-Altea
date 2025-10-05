<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Student - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      max-width: 400px;
      margin: 3rem auto;
      text-align: center;
    }
    .btn-pink {
      background: linear-gradient(to right, #f472b6, #f9a8d4);
      color: white;
    }
    .btn-pink:hover {
      background: linear-gradient(to right, #f9a8d4, #f472b6);
    }
    input {
      border: 1px solid #fbcfe8;
      border-radius: 9999px;
      padding: 0.5rem 1rem;
      width: 100%;
      margin-bottom: 1rem;
      outline: none;
    }
    input:focus {
      border-color: #f472b6;
      box-shadow: 0 0 0 2px rgba(244, 114, 182, 0.3);
    }
  </style>
</head>
<body>

  <div class="overlay min-h-screen flex items-center justify-center">
    <div class="card">
      <div class="magic-icon mb-4">
        <i class="fa-solid fa-wand-magic-sparkles text-white text-2xl"></i>
      </div>
      <h2 class="text-2xl font-bold mb-1">Update Student Info ✨</h2>
      <p class="text-pink-700 mb-6">Make your profile magical & fresh!</p>

      <form action="<?= site_url('users/update/'.$user['id']) ?>" method="post">
        <input type="text" name="first_name" placeholder="First Name" value="<?= $user['first_name'] ?>" required>
        <input type="text" name="last_name" placeholder="Last Name" value="<?= $user['last_name'] ?>" required>
        <input type="email" name="email" placeholder="Email Address" value="<?= $user['email'] ?>" required>
        <div class="flex gap-4 mt-4 justify-center">
          <button type="submit" class="btn-pink px-6 py-2 rounded-full font-semibold flex items-center gap-2">
            <i class="fa-solid fa-heart"></i> Update
          </button>
          <a href="<?= site_url('users') ?>" class="px-6 py-2 rounded-full border border-pink-300 font-semibold text-pink-700 hover:bg-pink-100 flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
