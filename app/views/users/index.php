<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?=base_url();?>public/style.css">
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
<body class="min-h-screen font-sans text-gray-800 relative">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Navbar -->
  <nav class="relative z-10 bg-gradient-to-r from-pink-400 via-purple-500 to-black shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-center">
      <h1 class="text-white font-bold text-lg tracking-widest uppercase drop-shadow-md">
        🎀 User Directory 🎀
      </h1>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="relative z-10 max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-white/50 backdrop-blur-xl shadow-2xl rounded-3xl p-6 border border-pink-200">

      <!-- Add New User -->
      <div class="flex justify-start mb-6">
        <a href="<?=site_url('users/create')?>"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-400 via-purple-500 to-black hover:from-pink-500 hover:to-purple-700 text-white font-semibold px-5 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105">
          <i class="fa-solid fa-heart"></i> Add New User
        </a>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-2xl border border-pink-300 shadow">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-pink-400 via-pink-500 to-black text-white text-sm uppercase tracking-wide">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Lastname</th>
              <th class="py-3 px-4">Firstname</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="text-pink-900 text-sm font-medium">
            <?php foreach(html_escape($users) as $user): ?>
              <tr class="hover:bg-pink-100/60 transition duration-200">
                <td class="py-3 px-4 font-semibold"><?=($user['id']);?></td>
                <td class="py-3 px-4"><?=($user['last_name']);?></td>
                <td class="py-3 px-4"><?=($user['first_name']);?></td>
                <td class="py-3 px-4">
                  <span class="bg-pink-200 text-pink-900 text-sm font-semibold px-3 py-1 rounded-full shadow-sm">
                    <?=($user['email']);?>
                  </span>
                </td>
                <td class="py-3 px-4 flex justify-center gap-3">
                  <!-- Update Button -->
                  <a href="<?=site_url('users/update/'.$user['id']);?>"
                     class="bg-gradient-to-r from-yellow-300 to-amber-400 hover:from-yellow-400 hover:to-amber-500 text-black font-semibold px-3 py-1 rounded-lg shadow flex items-center gap-1 transition duration-200">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Update
                  </a>
                  <!-- Delete Button -->
                  <a href="<?=site_url('users/delete/'.$user['id']);?>"
                     class="inline-flex items-center gap-2 bg-gradient-to-r from-red-400 to-rose-500 hover:from-red-500 hover:to-rose-600 text-white px-3 py-1 rounded-lg shadow transition-all duration-300">
                     <i class="fa-solid fa-star"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</body>
</html>
