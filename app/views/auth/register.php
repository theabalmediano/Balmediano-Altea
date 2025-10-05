<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-pink-50">
  <div class="relative w-full max-w-sm p-6">
    <div class="bg-white/70 backdrop-blur-lg rounded-2xl p-8 border border-pink-200 shadow-xl">
      <h2 class="text-2xl font-bold text-center text-pink-900 mb-6 flex items-center justify-center gap-2">
        <i class="fa-solid fa-user-plus text-pink-500"></i> Register
      </h2>

      <!-- Display errors -->
      <?php if(!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-sm">
          <ul class="list-disc list-inside">
            <?php foreach($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" class="space-y-4">
        <!-- Username -->
        <input type="text" name="username" placeholder="Username" required 
               class="w-full px-4 py-3 rounded-full border border-pink-300 text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400"/>

        <!-- Password -->
        <div class="relative">
          <input id="password" name="password" type="password" placeholder="Password" required
                 class="w-full px-4 py-3 rounded-full border border-pink-300 text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400"/>
          <button type="button" id="togglePw" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500">
            <i class="fa-solid fa-eye" id="eyeOpen"></i>
            <i class="fa-solid fa-eye-slash hidden" id="eyeClosed"></i>
          </button>
        </div>
        <p id="pwHelp" class="text-xs mt-1 text-red-500">At least 8 letters with uppercase, lowercase, number & symbol.</p>

        <!-- Confirm Password -->
        <div class="relative mt-3">
          <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" required
                 class="w-full px-4 py-3 rounded-full border border-pink-300 text-pink-900 placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400"/>
          <button type="button" id="toggleConfirm" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500">
            <i class="fa-solid fa-eye" id="eyeOpenC"></i>
            <i class="fa-solid fa-eye-slash hidden" id="eyeClosedC"></i>
          </button>
        </div>
  
        <!-- Role -->
        <select name="role" required class="w-full px-4 py-3 rounded-full border border-pink-300 text-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-400">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>

        <!-- Submit -->
        <button type="submit" class="w-full py-3 rounded-full font-semibold bg-gradient-to-r from-pink-400 to-pink-300 text-white hover:scale-105 transition-all">
          <i class="fa-solid fa-scroll mr-2"></i> Register
        </button>
      </form>

      <p class="text-center text-pink-700 mt-4 text-sm">
        Already have an account? 
        <a href="<?= site_url('auth/login') ?>" class="font-semibold underline hover:text-pink-900">Login</a>
      </p>
    </div>
  </div>

  <!-- JS for eye toggle & validation -->
  <script>
    const pwInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm_password');
    const pwHelp = document.getElementById('pwHelp');
    const confirmHelp = document.getElementById('confirmHelp');

    const pwRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/;

    // Password eye toggle
    document.getElementById('togglePw').addEventListener('click', () => {
      const type = pwInput.type === 'password' ? 'text' : 'password';
      pwInput.type = type;
      document.getElementById('eyeOpen').classList.toggle('hidden');
      document.getElementById('eyeClosed').classList.toggle('hidden');
    });

    document.getElementById('toggleConfirm').addEventListener('click', () => {
      const type = confirmInput.type === 'password' ? 'text' : 'password';
      confirmInput.type = type;
      document.getElementById('eyeOpenC').classList.toggle('hidden');
      document.getElementById('eyeClosedC').classList.toggle('hidden');
    });

    // Validate password and confirm in real-time
    function validatePassword() {
      if (pwRegex.test(pwInput.value)) {
        pwHelp.textContent = 'Password meets requirements.';
        pwHelp.classList.remove('text-red-500');
        pwHelp.classList.add('text-green-500');
      } else {
        pwHelp.textContent = 'At least 8 letters with uppercase, lowercase, number & symbol.';
        pwHelp.classList.remove('text-green-500');
        pwHelp.classList.add('text-red-500');
      }
      validateConfirm();
    }

    function validateConfirm() {
      if (!confirmInput.value) {
        confirmHelp.textContent = 'At least 8 letters with uppercase, lowercase, number & symbol.';
        confirmHelp.classList.remove('text-green-500');
        confirmHelp.classList.add('text-red-500');
        return;
      }
      if (pwInput.value === confirmInput.value && pwRegex.test(confirmInput.value)) {
        confirmHelp.textContent = 'Passwords match.';
        confirmHelp.classList.remove('text-red-500');
        confirmHelp.classList.add('text-green-500');
      } else {
        confirmHelp.textContent = 'Passwords do not match or are invalid.';
        confirmHelp.classList.remove('text-green-500');
        confirmHelp.classList.add('text-red-500');
      }
    }

    pwInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validateConfirm);
  </script>
</body>
</html>
