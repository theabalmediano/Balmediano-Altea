<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Directory - Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=IM+Fell+English&family=Playfair+Display&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css">

  <style>
    body { 
      font-family: 'Playfair Display', serif; 
      background-color: #fff0f6; /* light pink */
    }
    .font-title { 
      font-family: 'Cinzel Decorative', cursive; 
      letter-spacing: 2px; 
    }
    .btn-hover:hover { 
      box-shadow: 0 0 12px #f78da7, 0 0 24px #ffb6c1; 
      transform: scale(1.05); 
    }
    .logout-btn {
      background: linear-gradient(to right, #ff9eb5, #ffb6c1);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.75rem;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    .logout-btn:hover {
      background: linear-gradient(to right, #ff7d9d, #ff99b9);
      box-shadow: 0 0 10px #ff99b9;
    }
    .hp-page {
      padding: 6px 12px;
      border-radius: 6px;
      background: #ffe4ec;
      color: #c71585;
      transition: 0.3s;
    }
    .hp-page:hover {
      background: #ffbad4;
      color: white;
    }
    .hp-current {
      padding: 6px 12px;
      border-radius: 6px;
      background: #ff99c8;
      color: white;
      font-weight: bold;
    }
  </style>
</head>
<body class="min-h-screen">

  <!-- Header -->
  <nav class="bg-gradient-to-r from-pink-500 via-pink-400 to-pink-600 shadow-lg border-b-4 border-pink-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-white font-title text-2xl flex items-center gap-2">
        <i class="fa-solid fa-heart"></i> Student Directory
      </h1>
    </div>
  </nav>

  <!-- Content -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-pink-50 shadow-xl rounded-xl p-6 border-4 border-pink-200">

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
           class="btn-hover inline-flex items-center gap-2 bg-gradient-to-r from-pink-600 to-pink-400 text-white font-bold px-5 py-2 rounded-lg shadow-md transition-all duration-300">
          <i class="fa-solid fa-user-plus"></i> Add New 
        </a>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-xl border-4 border-pink-200">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-pink-500 to-pink-400 text-white uppercase tracking-wider hp-title text-lg">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Lastname</th>
              <th class="py-3 px-4">Firstname</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="text-gray-800 text-sm" style="font-family:'Playfair Display', serif;">
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
                       class="btn-hover bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow flex items-center gap-1">
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
                [
                  '<a class="hp-page"',          
                  '<span class="hp-current">',   
                  '</span>'
                ],
                $page
              );
            }
          ?>
        </div>
      </div>

      <!-- Logout Button -->
      <div class="mt-6 flex justify-center">
        <a href="<?=site_url('auth/logout');?>"
           class="logout-btn flex items-center gap-2">
           <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
      </div>
    
    </div>
  </div>

</body>
</html>
