<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-100 min-h-screen">

  <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-xl">
    <div class="flex justify-between items-center mb-4">
      <!-- Search -->
      <form method="get" action="<?=site_url('users')?>" class="flex">
        <input type="text" name="q" value="<?=html_escape($_GET['q'] ?? '')?>" 
               placeholder="Search..." class="px-4 py-2 border rounded-l-lg">
        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-r-lg">Search</button>
      </form>
      <!-- Logout -->
      <a href="<?=site_url('auth/logout')?>" class="px-4 py-2 bg-red-500 text-white rounded-lg">Logout</a>
    </div>

    <table class="w-full text-center border">
      <thead class="bg-pink-400 text-white">
        <tr>
          <th class="py-2 px-4">ID</th>
          <th class="py-2 px-4">Username</th>
          <th class="py-2 px-4">Email</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): ?>
          <?php foreach ($users as $user): ?>
            <tr class="border-t hover:bg-pink-100">
              <td class="py-2 px-4"><?=$u['id']?></td>
              <td class="py-2 px-4"><?=$u['username']?></td>
              <td class="py-2 px-4"><?=$u['email']?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="3" class="py-4">No users found</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 flex justify-center">
      <?=$page ?? ''?>
    </div>
  </div>

</body>
</html>
