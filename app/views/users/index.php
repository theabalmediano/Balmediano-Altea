<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?=base_url();?>public/style.css">
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
      background: linear-gradient(135deg, #f472b6, #a78bfa, #000);
      padding: 0.5rem;
      border-radius: 9999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
  </style>
</head>
<body class="min-h-screen relative text-pink-900">

  <!-- Overlay -->
  <div class="absolute inset-0 overlay"></div>

  <!-- Container -->
  <div class="relative max-w-6xl mx-auto mt-10 px-4 z-10">

    <!-- Header / Search -->
    <div class="flex justify-between items-center mb-6">
      <div class="flex items-center gap-3">
        <div class="magic-icon">
          <i class="fa-solid fa-wand-magic-sparkles text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-pink-900 drop-shadow-lg">💖 Kuromi Pink Directory 💖</h1>
      </div>
      <form method="get" action="<?=site_url()?>" class="flex">
        <input 
          type="text" 
          name="q" 
          value="<?=html_escape($_GET['q'] ?? '')?>" 
          placeholder="Search student..."
          class="px-4 py-2 rounded-l-full bg-pink-50/80 text-pink-900 placeholder-pink-400 border border-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-500 w-64">
        <button type="submit" 
                class="bg-gradient-to-r from-pink-400 via-purple-500 to-black hover:from-pink-500 hover:to-purple-700 text-white px-4 py-2 rounded-r-full shadow-lg transition duration-300">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>

    <!-- Add New User Button -->
    <div class="flex justify-end mb-6">
      <a href="<?=site_url('users/create')?>"
         class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-400 via-purple-500 to-black hover:from-pink-500 hover:to-purple-700 text-white font-bold px-5 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105">
        <i class="fa-solid fa-user-plus"></i> Add New User
      </a>
    </div>

    <!-- User Table Card -->
    <div class="bg-white/40 backdrop-blur-2xl rounded-3xl p-6 border border-pink-200 shadow-2xl">
      <div class="overflow-x-auto rounded-2xl border border-pink-300 shadow-lg">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-pink-400 via-purple-500 to-black text-white text-sm uppercase tracking-wide rounded-t-3xl">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Lastname</th>
              <th class="py-3 px-4">Firstname</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="text-pink-900 text-sm">
            <?php foreach(html_escape($users) as $user): ?>
              <tr class="hover:bg-pink-100/50 transition duration-200 rounded-lg">
                <td class="py-3 px-4 font-medium"><?=($user['id']);?></td>
                <td class="py-3 px-4"><?=($user['last_name']);?></td>
                <td class="py-3 px-4"><?=($user['first_name']);?></td>
                <td class="py-3 px-4">
                  <span class="bg-pink-50/80 text-pink-900 text-sm font-semibold px-3 py-1 rounded-full">
                    <?=($user['email']);?>
                  </span>
                </td>
                <td class="py-3 px-4 flex justify-center gap-3">
                  <a href="<?=site_url('users/update/'.$user['id']);?>"
                     class="bg-gradient-to-r from-pink-400 via-purple-500 to-black text-white font-semibold px-3 py-1 rounded-full shadow flex items-center gap-1 transition duration-200 hover:scale-105">
                    <i class="fa-solid fa-pen-to-square"></i> Update
                  </a>
                  <a href="<?=site_url('users/delete/'.$user['id']);?>"
                     class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-500 text-white px-3 py-1 rounded-full shadow transition-all duration-300 hover:scale-105">
                     <i class="fa-solid fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if(isset($page) && !empty($page)): 
    echo str_replace(
      ['<ul>', '</ul>', '<li>', '</li>', '<a', '</a>'],
      ['<div class="flex space-x-2">', '</div>', '', '', '<a class="px-3 py-1 rounded-full bg-pink-50/80 text-pink-900 shadow hover:bg-pink-100 transition cursor-pointer"', '</a>'],
      $page
    );
    endif; ?>
      </div>

    </div>

  </div>

</body>
</html>
