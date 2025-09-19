<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kuromi User List</title>
<script src="https://cdn.tailwindcss.com"></script>
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
        background: rgba(255, 240, 245, 0.7);
    }
</style>
</head>
<body class="min-h-screen relative flex flex-col items-center justify-start text-gray-800 py-8">

<!-- Overlay -->
<div class="absolute inset-0 overlay"></div>

<!-- Header -->
<div class="relative z-10 w-full max-w-4xl text-center mb-6">
    <h1 class="text-3xl font-bold text-pink-900 mb-2">💖 Kuromi User List 💖</h1>
    <p class="text-pink-700 italic">🌸 Cute Tailwind Style Table 🌸</p>
</div>

<!-- Search & Add -->
<div class="relative z-10 w-full max-w-4xl mb-6 flex justify-between items-center">
    <form action="<?= site_url('/'); ?>" method="get" class="flex gap-2 flex-1">
        <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
        <input type="text" name="q" class="flex-1 px-3 py-2 rounded-xl border border-pink-300 focus:ring-2 focus:ring-pink-500" placeholder="Search users..." value="<?= htmlspecialchars($q); ?>">
        <button type="submit" class="px-4 py-2 bg-pink-400 rounded-xl text-white font-semibold hover:bg-pink-500"><i class="fa-solid fa-magnifying-glass mr-1"></i>Search</button>
    </form>
    <a href="<?= site_url('users/create'); ?>" class="ml-4 px-4 py-2 bg-purple-500 text-white rounded-xl font-semibold hover:bg-purple-600"><i class="fa-solid fa-plus mr-1"></i> Add User</a>
</div>

<!-- Table -->
<div class="relative z-10 w-full max-w-4xl bg-white/40 backdrop-blur-2xl rounded-3xl shadow-2xl p-6 border border-pink-200">
    <table class="w-full text-center border-collapse">
        <thead>
            <tr class="bg-pink-200 text-pink-900 font-semibold uppercase">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">First Name</th>
                <th class="px-4 py-2">Last Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($all)): ?>
                <?php foreach($all as $user): ?>
                <tr class="odd:bg-white/20 even:bg-white/10 hover:bg-pink-50/20 transition-colors">
                    <td class="px-4 py-2"><?= htmlspecialchars($user['id']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['first_name']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['last_name']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="px-4 py-2 flex justify-center gap-2">
                        <a href="<?= site_url('users/update/'.$user['id']); ?>" class="px-2 py-1 bg-yellow-400 rounded-lg text-white hover:bg-yellow-500"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="<?= site_url('users/delete/'.$user['id']); ?>" class="px-2 py-1 bg-red-500 rounded-lg text-white hover:bg-red-600" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 text-pink-900 italic">No users found 💔</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
  <!-- Vertical Pagination -->
<div class="mt-6 flex justify-center">
    <ul class="flex flex-col items-center gap-2">
        <?php if(!empty($page)): ?>
            <?php
                // Split the pagination links into individual links
                $links = preg_split('/(?=<a )/', $page);
                foreach($links as $link):
                    if(trim($link) != ''):
                        // Add Tailwind styles to each link
                        $link = preg_replace(
                            '/<a href="([^"]+)">([^<]+)<\/a>/',
                            '<a href="$1" class="px-4 py-2 w-32 text-center bg-pink-300 text-pink-900 rounded-xl hover:bg-pink-400 transition">$2</a>',
                            $link
                        );
                        echo "<li>$link</li>";
                    endif;
                endforeach;
            ?>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>
