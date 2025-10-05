<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Update Student - Kuromi Pink Coquette</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Quicksand:wght@500;700&display=swap"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <style>
    body {
      font-family: 'Nunito', 'Quicksand', sans-serif;
      background: #fff0f6;
      color: #b91c1c; /* rich pink-red */
      min-height: 100vh;
    }
    .overlay {
      background: rgba(255, 230, 240, 0.85);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }
    .card {
      background: white;
      border-radius: 2rem;
      box-shadow: 0 10px 30px rgba(219, 39, 119, 0.15);
      max-width: 420px;
      width: 100%;
      padding: 2.5rem 3rem;
      text-align: center;
      border: 2px solid #f9a8d4;
    }
    .magic-icon {
      background: linear-gradient(135deg, #f472b6, #f9a8d4, #fbcfe8);
      padding: 0.8rem;
      border-radius: 9999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 25px rgba(244, 114, 182, 0.25);
      animation: float 3s ease-in-out infinite;
      margin-bottom: 1rem;
    }
    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-8px);
      }
    }
    h2 {
      font-weight: 700;
      font-size: 1.8rem;
      color: #be185d; /* darker pink */
      margin-bottom: 0.25rem;
    }
    p {
      color: #db2777;
      margin-bottom: 1.5rem;
      font-weight: 600;
    }
    input {
      border: 2px solid #f9a8d4;
      border-radius: 9999px;
      padding: 0.65rem 1.25rem;
      width: 100%;
      margin-bottom: 1.25rem;
      font-weight: 600;
      font-size: 1rem;
      outline-offset: 3px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    input:focus {
      border-color: #db2777;
      box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.3);
    }
    .btn-pink {
      background: linear-gradient(90deg, #ec4899, #f9a8d4);
      color: white;
      padding: 0.65rem 1.75rem;
      border-radius: 9999px;
      font-weight: 700;
      font-size: 1.1rem;
      box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
      transition: background 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      justify-content: center;
      border: none;
      cursor: pointer;
    }
    .btn-pink:hover {
      background: linear-gradient(90deg, #f9a8d4, #ec4899);
    }
    .btn-back {
      padding: 0.65rem 1.75rem;
      border-radius: 9999px;
      font-weight: 700;
      font-size: 1.1rem;
      border: 2px solid #f9a8d4;
      color: #db2777;
      background: white;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      justify-content: center;
      transition: background 0.3s ease, color 0.3s ease;
      text-decoration: none;
      margin-left: 1rem;
    }
    .btn-back:hover {
      background: #f9a8d4;
      color: white;
    }
    .actions {
      display: flex;
      justify-content: center;
      margin-top: 1.75rem;
    }
  </style>
</head>
<body>

  <div class="overlay">
    <div class="card">
      <div class="magic-icon">
        <i class="fa-solid fa-wand-magic-sparkles text-white text-2xl"></i>
      </div>
      <h2>Update Student Info ✨</h2>
      <p>Make your profile magical & fresh!</p>

      <form action="<?= site_url('users/update/'.$user['id']) ?>" method="post" autocomplete="off">
        <input
          type="text"
          name="first_name"
          placeholder="First Name"
          value="<?= htmlspecialchars($user['first_name'], ENT_QUOTES) ?>"
          required
          autofocus
        />
        <input
          type="text"
          name="last_name"
          placeholder="Last Name"
          value="<?= htmlspecialchars($user['last_name'], ENT_QUOTES) ?>"
          required
        />
        <input
          type="email"
          name="email"
          placeholder="Email Address"
          value="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>"
          required
        />

        <div class="actions">
          <button type="submit" class="btn-pink">
            <i class="fa-solid fa-heart"></i> Update
          </button>
          <a href="<?= site_url('users') ?>" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
