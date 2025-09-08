<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update</title>
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
      background: rgba(255, 240, 245, 0.75); /* pastel pink overlay */
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center text-gray-800 relative">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Card -->
  <div class="relative z-10 bg-white/60 backdrop-blur-xl p-8 rounded-3xl shadow-2xl w-full max-w-md border border-pink-200 animate-fadeIn">
    <h2 class="text-2xl font-bold text-center text-pink-900 mb-6">Update Your Info ✨</h2>

    <form action="<?=site_url('users/update/'.$user['id'])?>" method="POST" class="space-y-5">
      
      <!-- First Name -->
      <div>
        <label class="block text-pink-900 mb-1 font-medium">First Name</label>
        <input type="text" name="first_name" value="<?= html_escape($user['first_name'])?>" required
               class="w-full px-4 py-3 bg-white/80 text-pink-900 placeholder-pink-400 border border-pink-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-md">
      </div>

      <!-- Last Name -->
      <div>
        <label class="block text-pink-900 mb-1 font-medium">Last Name</label>
        <input type="text" name="last_name" value="<?= html_escape($user['last_name'])?>" required
               class="w-full px-4 py-3 bg-white/80 text-pink-900 placeholder-pink-400 border border-pink-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-md">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-pink-900 mb-1 font-medium">Email Address</label>
        <input type="email" name="email" value="<?= html_escape($user['email'])?>" required
               class="w-full px-4 py-3 bg-white/80 text-pink-900 placeholder-pink-400 border border-pink-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-md">
      </div>

      <!-- Button -->
      <button type="submit"
              class="w-full bg-gradient-to-r from-pink-500 via-purple-500 to-black hover:from-pink-600 hover:to-purple-700 text-white font-semibold py-3 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
        <i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Update
      </button>
    </form>
  </div>
</body>
</html>
