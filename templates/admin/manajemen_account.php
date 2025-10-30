<?php
$accounts = [
    [
        'id' => 1,
        'name' => 'Muhammad Thoriq Firdaus',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Last login: 1 mount ago',
        'role' => 'Admin',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=12'
    ],
    [
        'id' => 2,
        'name' => 'M Ghani Gazali',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Login: 1 bulan lalu',
        'role' => 'Admin',
        'is_active' => false,
        'avatar' => 'https://i.pravatar.cc/150?img=45'
    ],
    [
        'id' => 3,
        'name' => 'Herdiansyah Hidayatullah',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Login: 1 bulan lalu',
        'role' => 'Owner',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=33'
    ],
    [
        'id' => 4,
        'name' => 'Nuril Aisyahroni',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Last login: 1 mount ago',
        'role' => 'Admin',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=27'
    ],
    [
        'id' => 5,
        'name' => 'Ananda Rafael',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Login: 1 bulan lalu',
        'role' => 'Owner',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=33'
    ],
    [
        'id' => 6,
        'name' => 'Ananta Wldayani',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Last login: 1 mount ago',
        'role' => 'Admin',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=27'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun - Kaliwates Mobil Jember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        [id^="status-badge-"] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 94px;
        text-align: center;
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
                        <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-white bg-indigo-950 rounded-md">
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
                        <h2 class="text-4xl font-bold text-gray-900 mb-1.5">Manajemen Akun</h2>
                        <p class="text-gray-600 text-base">Edit dan Tambah akun di halaman ini</p>
                    </div>
                    <a href="add_account.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium transition-colors">
                        <i class="fas fa-plus text-sm"></i>
                        <span>Tambah Akun</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <?php foreach ($accounts as $account): ?>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <div class="flex gap-4">
                            <img src="<?= $account['avatar'] ?>" alt="<?= $account['name'] ?>" 
                                 class="w-28 h-28 rounded-full object-cover flex-shrink-0">
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-900"><?= $account['name'] ?></h3>
                                </div>
                                <p class="text-gray-700 mb-0.5 text-sm"><?= $account['email'] ?></p>
                                <p class="text-xs text-gray-500 mb-3"><?= $account['last_login'] ?></p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="<?= $account['role'] == 'Admin' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' ?> px-4 py-2 rounded-full text-sm font-semibold">
                                            <?= $account['role'] ?>
                                        </span>
                                        
                                        <span id="status-badge-<?= $account['id'] ?>" class="<?= $account['is_active'] ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' ?> px-4 py-2 rounded-full text-sm font-semibold">
                                            <?= $account['is_active'] ? 'Aktif' : 'NonAktif' ?>
                                        </span>
                                        
                                        <label class="relative inline-block w-16 h-8 cursor-pointer">
                                            <input 
                                                type="checkbox" 
                                                id="toggle-<?= $account['id'] ?>" 
                                                class="sr-only peer"
                                                <?= $account['is_active'] ? 'checked' : '' ?>
                                                onchange="toggleStatus(<?= $account['id'] ?>, this.checked)"
                                            >
                                            <div class="w-16 h-8 bg-red-500 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-8 peer-checked:bg-green-500 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all"></div>
                                        </label>
                                    </div>
                                    
                                    <a href="edit_account.php?id=<?= $account['id'] ?>" 
                                       class="text-blue-600 hover:text-blue-700 flex items-center gap-1.5 font-medium text-sm">
                                        <i class="fas fa-pen text-sm"></i>
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleStatus(accountId, isActive) {
            console.log('Account ID:', accountId, 'Status:', isActive ? 'Aktif' : 'Non Aktif');
            
            const statusBadge = document.getElementById(`status-badge-${accountId}`);
            if (isActive) {
                statusBadge.textContent = 'Aktif';
                statusBadge.className = 'bg-green-50 text-green-600 px-4 py-2 rounded-full text-sm font-semibold';
            } else {
                statusBadge.textContent = 'Non Aktif';
                statusBadge.className = 'bg-red-50 text-red-600 px-4 py-2 rounded-full text-sm font-semibold';
            }
            
        }
    </script>
</body>
</html>