<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: " . site_url('auth/login'));
    exit;
}

$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Kuromi User List</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="<?=base_url();?>/public/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Body & Overlay */
body {
    font-family: 'Poppins', sans-serif;
    background-image: url('https://i.pinimg.com/736x/bf/01/f9/bf01f9444340ecdb37af06d201c6f1cf.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #9d174d;
    min-height: 100vh;
    padding: 2rem 1rem;
    position: relative;
}

.overlay {
    background: rgba(255, 240, 245, 0.6);
    position: absolute;
    inset: 0;
    z-index: 0;
}

/* Container */
.container {
    position: relative;
    max-width: 1100px;
    margin: auto;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2rem;
    border: 1px solid #fbcfe8;
    padding: 2.5rem;
    box-shadow: 0 15px 40px rgba(236, 72, 153, 0.2);
    z-index: 10;
}

/* Magic icon */
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
    50% { transform: translateY(-8px); }
}

/* Header */
h1 {
    font-weight: 700;
    font-size: 2rem;
    color: #9d174d;
}

.subtitle {
    color: #be185d;
    font-weight: 500;
    font-size: 0.95rem;
}

/* Search section */
.search-section {
    background: rgba(255,240,245,0.8);
    border-radius: 1.5rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #fbcfe8;
}

.search-label {
    font-weight: 600;
    color: #be185d;
    margin-bottom: 0.75rem;
    display: block;
}

.search-bar {
    display: flex;
    gap: 0.5rem;
}

.search-bar input[type="text"] {
    flex: 1;
    padding: 0.75rem 1rem;
    border-radius: 9999px;
    border: 1px solid #fbcfe8;
    background-color: rgba(255,240,245,0.7);
    color: #831843;
    font-weight: 500;
    outline: none;
    transition: all 0.3s;
}

.search-bar input[type="text"]:focus {
    border-color: #ec4899;
    box-shadow: 0 0 0 4px rgba(236,72,153,0.1);
}

.search-bar button {
    padding: 0.75rem 1.5rem;
    border-radius: 9999px;
    border: none;
    background: linear-gradient(135deg,#be185d 0%,#ec4899 100%);
    color: white;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
}

.search-bar button:hover {
    background: linear-gradient(135deg,#9f1239 0%,#be185d 100%);
    transform: translateY(-2px);
}

/* Buttons */
.btn-create, .btn-logout {
    background: linear-gradient(135deg,#be185d 0%,#ec4899 100%);
    color: white;
    font-weight: 700;
    padding: 0.75rem 1.75rem;
    border-radius: 9999px;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(190,24,93,0.4);
    transition: all 0.3s;
    display: inline-block;
}

.btn-create:hover, .btn-logout:hover {
    background: linear-gradient(135deg,#9f1239 0%,#be185d 100%);
    transform: translateY(-2px);
}

/* Table */
.table-wrapper {
    background: rgba(255,240,245,0.8);
    border-radius: 1.5rem;
    overflow: hidden;
    border: 1px solid #fbcfe8;
}

table {
    width: 100%;
    border-collapse: collapse;
    color: #831843;
}

thead {
    background: linear-gradient(135deg,#f472b6 0%,#ec4899 100%);
}

th {
    padding: 1rem 1.5rem;
    color: white;
    font-weight: 700;
    text-align: left;
    font-size: 0.85rem;
    text-transform: uppercase;
}

tbody tr {
    transition: all 0.2s ease;
    background: rgba(255,255,255,0.9);
}

tbody tr:nth-child(even) {
    background: rgba(252,231,243,0.6);
}

tbody tr:hover {
    background: rgba(249,168,212,0.3);
    transform: scale(1.002);
}

td {
    padding: 1rem 1.5rem;
    font-weight: 500;
    font-size: 0.9rem;
}

.action-cell {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn-update {
    background: linear-gradient(135deg,#a855f7 0%,#c084fc 100%);
    color: white;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
    border-radius: 9999px;
    font-size: 0.85rem;
}

.btn-update:hover {
    background: linear-gradient(135deg,#9333ea 0%,#a855f7 100%);
    transform: translateY(-2px);
}

.btn-delete {
    background: linear-gradient(135deg,#fb7185 0%,#f43f5e 100%);
    color: white;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
    border-radius: 9999px;
    font-size: 0.85rem;
}

.btn-delete:hover {
    background: linear-gradient(135deg,#f43f5e 0%,#e11d48 100%);
    transform: translateY(-2px);
}

.bottom-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination a {
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    border: 1px solid #fbcfe8;
    margin: 0 0.25rem;
    color: #831843;
    text-decoration: none;
}

.pagination a:hover {
    background: rgba(249,168,212,0.4);
    transform: translateY(-2px);
}

.pagination strong {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg,#be185d 0%,#ec4899 100%);
    color: white;
    border-radius: 9999px;
    margin: 0 0.25rem;
}

@media (max-width: 768px) {
    .container { padding: 1.5rem; }
    h1 { font-size: 1.75rem; }
    .table-wrapper { overflow-x: auto; }
}
</style>
</head>
<body>

<div class="overlay"></div>

<div class="container">
    <!-- Header -->
    <div class="header-section flex justify-between items-center mb-6 flex-wrap gap-3">
        <div class="flex items-center gap-3">
            <div class="magic-icon"><i class="fa-solid fa-wand-magic-sparkles text-white"></i></div>
            <div>
                <h1>User Management</h1>
                <p class="subtitle">Manage your users with ease ♡</p>
            </div>
        </div>
        <?php if ($role === 'admin'): ?>
            <a class="btn-create" href="<?=site_url('users/create');?>">Add New User</a>
        <?php endif; ?>
    </div>

    <!-- Search -->
    <div class="search-section">
        <label class="search-label">Search Users</label>
        <form method="get" action="<?=site_url('/users')?>" class="search-bar">
            <input type="text" name="q" value="<?=html_escape($_GET['q'] ?? '')?>" placeholder="Type name, email, or ID..." />
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrapper mt-6">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <?php if ($role === 'admin'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users)): ?>
                    <?php foreach(html_escape($users) as $user): ?>
                        <tr>
                            <td style="font-weight:700;color:#be185d;"><?= $user['id']; ?></td>
                            <td><?= $user['first_name']; ?></td>
                            <td><?= $user['last_name']; ?></td>
                            <td style="color:#be185d;"><?= $user['email']; ?></td>
                            <?php if ($role === 'admin'): ?>
                                <td>
                                    <div class="action-cell">
                                        <a class="btn-update" href="<?= site_url('users/update/'.$user['id']); ?>">Update</a>
                                        <a class="btn-delete" href="<?= site_url('users/delete/'.$user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $role === 'admin' ? '5' : '4' ?>" class="text-center p-12 font-semibold text-pink-700">
                            No users found. Try searching with different keywords.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bottom section -->
    <div class="bottom-section mt-6">
        <div class="pagination">
            <?= $page ?? '' ?>
        </div>
        <a href="<?=site_url('auth/logout');?>" class="btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
