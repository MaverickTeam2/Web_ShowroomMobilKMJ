<?php
$account_id = $_GET['id'] ?? 1;

$accounts = [
    1 => [
        'id' => 1,
        'first_name' => 'Muhammad Thoriq',
        'last_name' => 'Firdaus',
        'username' => 'thoriq123',
        'email' => 'Bugatti456@gmail.com',
        'phone' => '+628123456789',
        'address' => 'Jember, Jawa Timur',
        'avatar' => 'https://i.pravatar.cc/150?img=12'
    ],
    2 => [
        'id' => 2,
        'first_name' => 'M Ghani',
        'last_name' => 'Gazali',
        'username' => 'ghani456',
        'email' => 'Bugatti456@gmail.com',
        'phone' => '+628987654321',
        'address' => 'Jember, Jawa Timur',
        'avatar' => 'https://i.pravatar.cc/150?img=45'
    ],
];

$account = $accounts[$account_id] ?? $accounts[1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Location: manajemen_account.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun - Kaliwates Mobil Jember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <aside class="w-56 bg-white border-r border-gray-200 flex flex-col fixed h-screen">
            <div class="p-4 border-b border-gray-200 flex items-center gap-3">
                <div class="w-10 h-10 bg-black rounded flex items-center justify-center flex-shrink-0">
                    <span class="text-yellow-400 font-bold text-lg">KM</span>
                </div>
                <div class="min-w-0">
                    <h1 class="font-semibold text-sm leading-tight">Kaliwates Mobil Jember</h1>
                    <p class="text-xs text-gray-500">Admin Dashboard</p>
                </div>
            </div>
            
            <nav class="flex-1 p-3 overflow-y-auto">
                <p class="text-xs font-medium text-gray-500 mb-2 px-2">Menu</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-home text-base w-4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-exchange-alt text-base w-4"></i>
                            <span>Transaksi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-car text-base w-4"></i>
                            <span>Manejemen Mobil</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-chart-bar text-base w-4"></i>
                            <span>Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="manajemen_account.php" class="flex items-center gap-2.5 px-3 py-2 text-sm text-white bg-indigo-950 rounded-md">
                            <i class="fas fa-users text-base w-4"></i>
                            <span>Manajemen Akun</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-3 border-t border-gray-200">
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md mb-0.5 transition-colors">
                    <i class="fas fa-cog text-base w-4"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                    <i class="fas fa-question-circle text-base w-4"></i>
                    <span>Help Center</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 ml-56">
            <div class="px-10 pt-6 pb-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 mb-1.5">Edit Akun</h2>
                        <p class="text-gray-600 text-base">Edit informasi akun admin</p>
                    </div>
                    <a href="manajemen_account.php" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 font-medium text-base">
                        <i class="fas fa-arrow-left"></i>
                        <span>Go Back</span>
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-16">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="flex justify-center mb-16">
                            <label for="photo" class="cursor-pointer">
                                <div id="photoPreview" class="w-52 h-52 rounded-full border-2 border-dashed border-gray-300 flex flex-col items-center justify-center bg-white hover:bg-gray-50 transition-colors overflow-hidden">
                                    <img src="<?= $account['avatar'] ?>" class="w-full h-full object-cover" />
                                </div>
                                <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                            </label>
                        </div>

                        <div class="max-w-5xl mx-auto">
                            <div class="grid grid-cols-2 gap-x-16 gap-y-8">
                                <div>
                                    <label for="first_name" class="block text-base font-semibold text-gray-900 mb-3">
                                        Nama depan
                                    </label>
                                    <input type="text" id="first_name" name="first_name" 
                                           value="<?= $account['first_name'] ?>"
                                           placeholder="Masukkan nama depan"
                                           class="w-full px-5 py-4 border border-gray-300 rounded-xl text-base focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none placeholder:text-gray-400">
                                </div>

                                <div>
                                    <label for="last_name" class="block text-base font-semibold text-gray-900 mb-3">
                                        Nama belakang
                                    </label>
                                    <input type="text" id="last_name" name="last_name" 
                                           value="<?= $account['last_name'] ?>"
                                           placeholder="Masukkan nama belakang"
                                           class="w-full px-5 py-4 border border-gray-300 rounded-xl text-base focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none placeholder:text-gray-400">
                                </div>

                                <div>
                                    <label for="username" class="block text-base font-semibold text-gray-900 mb-3">
                                        Username
                                    </label>
                                    <input type="text" id="username" name="username" 
                                           value="<?= $account['username'] ?>"
                                           placeholder="Masukkan username"
                                           class="w-full px-5 py-4 border border-gray-300 rounded-xl text-base focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none placeholder:text-gray-400">
                                </div>

                                <div>
                                    <label for="phone" class="block text-base font-semibold text-gray-900 mb-3">
                                        No telp
                                    </label>
                                    <input type="tel" id="phone" name="phone" 
                                           value="<?= $account['phone'] ?>"
                                           placeholder="+628123456789"
                                           class="w-full px-5 py-4 border border-gray-300 rounded-xl text-base focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none placeholder:text-gray-400">
                                </div>

                                <div>
                                    <label for="email" class="block text-base font-semibold text-gray-900 mb-3">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email" 
                                           value="<?= $account['email'] ?>"
                                           placeholder="example@exc.com"
                                           class="w-full px-5 py-4 border border-gray-300 rounded-xl text-base focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none placeholder:text-gray-400">
                                </div>

                                <div>
                                    <label for="address" class="block text-base font-semibold text-gray-900 mb-3">
                                        Alamat
                                    </label>
                                    <input type="text" id="address" name="address" 
                                           value="<?= $account['address'] ?>"
                                           placeholder="Masukkan Alamat"
                                           class="w-full px-5 py-4 border border-gray-300 rounded-xl text-base focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none placeholder:text-gray-400">
                                </div>
                            </div>

                            <div class="flex justify-end gap-4 mt-12">
                                <a href="manajemen_account.php" class="px-8 py-3.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 flex items-center gap-2.5 transition-colors text-base font-medium">
                                    <i class="fas fa-times text-lg"></i>
                                    <span>Cancel Changes</span>
                                </a>
                                <button type="submit" class="px-8 py-3.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 flex items-center gap-2.5 transition-colors text-base font-medium shadow-sm">
                                    <i class="fas fa-save text-lg"></i>
                                    <span>Save Changes</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const photoPreview = document.getElementById('photoPreview');
                    photoPreview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" />';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>