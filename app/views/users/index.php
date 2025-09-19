<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory - Kuromi Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?=base_url();?>public/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-purple-900 via-pink-900 to-black font-poppins text-gray-200">

  <!-- Header / Search -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <form method="get" action="<?=site_url()?>" class="mb-6 flex justify-end">
      <input 
        type="text" 
        name="q" 
        value="<?=html_escape($_GET['q'] ?? '')?>" 
        placeholder="Search student..." 
        class="px-4 py-2 rounded-l-full bg-purple-800 border border-pink-600 placeholder-pink-300 text-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
      <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-r-full shadow-lg transition duration-300">
        <i class="fa fa-search"></i>
      </button>
    </form>
  </div>

  <!-- Navbar -->
  <nav class="bg-gradient-to-r from-purple-800 to-pink-800 shadow-lg py-4">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center text-white font-semibold">
      <span class="text-xl">Kuromi Coquette Directory</span>
      <div class="space-x-4">
        <a href="#" class="hover:text-pink-300 transition">Home</a>
        <a href="#" class="hover:text-pink-300 transition">About</a>
        <a href="#" class="hover:text-pink-300 transition">Contacts</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-black/50 backdrop-blur-lg rounded-3xl p-6 border border-purple-700 shadow-2xl">

      <!-- Add New User -->
      <div class="flex justify-end mb-6">
        <a href="<?=site_url('users/create')?>"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-700 hover:from-purple-700 hover:to-pink-500 text-white font-bold px-5 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105">
          <i class="fa-solid fa-user-plus"></i> Add New User
        </a>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-3xl border border-purple-700 shadow-lg">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-gradient-to-r from-purple-700 to-pink-700 text-white text-sm uppercase tracking-wide">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Lastname</th>
              <th class="py-3 px-4">Firstname</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="text-pink-200 text-sm">
            <?php foreach($users as $user): ?>
              <tr id="row-<?= $user['id']; ?>" class="hover:bg-purple-900/40 transition duration-200 rounded-lg">
                <td class="py-3 px-4 font-medium"><?= $user['id']; ?></td>
                <td class="py-3 px-4"><?= $user['last_name']; ?></td>
                <td class="py-3 px-4"><?= $user['first_name']; ?></td>
                <td class="py-3 px-4">
                  <span class="bg-purple-800 text-pink-300 text-sm font-semibold px-3 py-1 rounded-full">
                    <?= $user['email']; ?>
                  </span>
                </td>
                <td class="py-3 px-4 flex justify-center gap-3">
                  <!-- Update Button -->
                  <a href="<?=site_url('users/update/'.$user['id']);?>"
                     class="bg-gradient-to-r from-yellow-400 to-amber-500 hover:from-amber-500 hover:to-yellow-400 text-black font-semibold px-3 py-1 rounded-full shadow flex items-center gap-1 transition duration-200">
                    <i class="fa-solid fa-pen-to-square"></i> Update
                  </a>
                  <!-- AJAX Delete Button -->
                  <button 
                    class="deleteBtn inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-pink-600 hover:to-red-500 text-white px-3 py-1 rounded-full shadow transition-all duration-300"
                    data-id="<?= $user['id']; ?>">
                    <i class="fa-solid fa-trash"></i> Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-4 flex justify-center">
        <div class="pagination flex space-x-2 text-pink-300">
          <?=$page ?? ''?>
        </div>
      </div>

    </div>
  </div>

  <!-- AJAX Delete Script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).on('click', '.deleteBtn', function(){
      if(!confirm('Delete this user permanently?')) return;
      const id = $(this).data('id');
      $.ajax({
          url: "<?= site_url('users/delete/') ?>" + id,
          type: "POST",
          dataType: "json",
          success: function(res){
              if(res.status === 'success'){
                  $("#row-" + id).fadeOut(300,function(){ $(this).remove(); });
              } else {
                  alert('Error deleting user.');
              }
          },
          error: function(){
              alert('Server error.');
          }
      });
  });
  </script>

</body>
</html>
