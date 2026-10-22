<?php
/**
 * ===================================================
 * SCRIPT DEPLOY & MIGRATE - KANDANG JATI KULON
 * ===================================================
 * PERINGATAN: Hapus file ini setelah digunakan!
 * CARA PAKAI: Upload ke folder public_html, lalu akses
 * via browser: https://kandangjati-kulon.probolinggokab.go.id/deploy_migrate.php
 * ===================================================
 */

// Password sederhana untuk keamanan
$password = 'KandangJati2026!';

if (!isset($_GET['key']) || $_GET['key'] !== $password) {
    http_response_code(403);
    echo '<h1>403 - Akses Ditolak</h1>';
    echo '<p>Tambahkan ?key=KandangJati2026! pada URL untuk mengakses.</p>';
    exit;
}

define('LARAVEL_START', microtime(true));

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deploy Script - Kandang Jati Kulon</title>
<style>
  body { font-family: monospace; background: #1a1a2e; color: #e0e0e0; padding: 20px; }
  .container { max-width: 900px; margin: 0 auto; }
  h1 { color: #00d4ff; border-bottom: 2px solid #00d4ff; padding-bottom: 10px; }
  h2 { color: #ffd700; margin-top: 30px; }
  .output { background: #0d0d0d; border: 1px solid #333; border-radius: 8px; padding: 15px; margin: 10px 0; white-space: pre-wrap; font-size: 13px; line-height: 1.6; }
  .success { color: #00ff88; }
  .error { color: #ff4444; }
  .warning { color: #ffaa00; }
  .info { color: #00d4ff; }
  .btn { display: inline-block; padding: 10px 20px; background: #ff4444; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
  .step { background: #16213e; border-left: 4px solid #00d4ff; padding: 10px 15px; margin: 5px 0; border-radius: 0 5px 5px 0; }
</style>
</head>
<body>
<div class="container">
<h1>🚀 Deploy Script - Kandang Jati Kulon</h1>
<p class="warning">⚠️ Hapus file ini setelah selesai digunakan!</p>

<?php

$action = $_GET['action'] ?? 'status';

function runArtisan($kernel, $command, $args = []) {
    $output = new Symfony\Component\Console\Output\BufferedOutput();
    $result = $kernel->call($command, $args, $output);
    return ['code' => $result, 'output' => $output->fetch()];
}

function showResult($label, $result) {
    $isSuccess = $result['code'] === 0;
    $icon = $isSuccess ? '✅' : '❌';
    $class = $isSuccess ? 'success' : 'error';
    echo "<div class='step'>";
    echo "<strong class='{$class}'>{$icon} {$label}</strong>";
    echo "<div class='output'>" . htmlspecialchars($result['output']) . "</div>";
    echo "</div>";
}

// Tampilkan menu aksi
echo "<h2>🔧 Pilih Aksi</h2>";
echo "<div class='output'>";
echo "<a href='?key=" . htmlspecialchars($password) . "&action=status' style='color:#00d4ff;'>📊 Status Migration</a> | ";
echo "<a href='?key=" . htmlspecialchars($password) . "&action=migrate' style='color:#00ff88;'>🗄️ Jalankan Migration</a> | ";
echo "<a href='?key=" . htmlspecialchars($password) . "&action=cache' style='color:#ffd700;'>🔄 Clear & Optimize Cache</a> | ";
echo "<a href='?key=" . htmlspecialchars($password) . "&action=storage' style='color:#ff88ff;'>📁 Storage Link</a> | ";
echo "<a href='?key=" . htmlspecialchars($password) . "&action=all' style='color:#ff4444;font-weight:bold;'>⚡ JALANKAN SEMUA</a>";
echo "</div>";

switch ($action) {
    case 'status':
        echo "<h2>📊 Status Sistem</h2>";
        
        // PHP Info
        echo "<div class='step'><strong class='info'>ℹ️ Info PHP & Sistem</strong>";
        echo "<div class='output'>";
        echo "PHP Version: " . PHP_VERSION . "\n";
        echo "Laravel Version: " . app()->version() . "\n";
        echo "Environment: " . app()->environment() . "\n";
        echo "Debug Mode: " . (config('app.debug') ? 'AKTIF (matikan untuk production!)' : 'NONAKTIF ✓') . "\n";
        echo "App URL: " . config('app.url') . "\n";
        echo "DB Connection: " . config('database.default') . "\n";
        echo "DB Database: " . config('database.connections.mysql.database') . "\n";
        echo "DB Host: " . config('database.connections.mysql.host') . "\n";
        echo "</div></div>";
        
        // Test DB Connection
        echo "<div class='step'><strong>🔌 Test Koneksi Database</strong>";
        try {
            DB::connection()->getPdo();
            echo "<div class='output success'>✅ Koneksi database berhasil!</div>";
            
            // Check tables
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map(function($t) { return array_values((array)$t)[0]; }, $tables);
            $requiredTables = ['users', 'settings', 'posts', 'services', 'announcements', 
                              'albums', 'album_photos', 'videos', 'documents', 'categories',
                              'agendas', 'navigation_menus', 'lembagas', 'complaints',
                              'rukun_wargas', 'maklumats', 'partnerships', 'survei_kepuasans',
                              'anggaran_kelurahans', 'activity_logs', 'migrations'];
            
            echo "<div class='output'>";
            echo "<strong>Tabel yang ada (" . count($tableNames) . " tabel):</strong>\n\n";
            foreach ($requiredTables as $table) {
                $exists = in_array($table, $tableNames);
                echo ($exists ? "✅" : "❌") . " {$table}\n";
            }
            echo "\n<strong>Semua tabel di database:</strong>\n";
            echo implode(', ', $tableNames);
            echo "</div>";
            
        } catch (\Exception $e) {
            echo "<div class='output error'>❌ Gagal konek database: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        echo "</div>";
        
        // Migration status
        echo "<div class='step'><strong>📋 Status Migration</strong>";
        $r = runArtisan($kernel, 'migrate:status');
        echo "<div class='output " . ($r['code'] === 0 ? 'success' : 'warning') . "'>" . htmlspecialchars($r['output']) . "</div>";
        echo "</div>";
        break;
        
    case 'migrate':
        echo "<h2>🗄️ Menjalankan Migration</h2>";
        $r = runArtisan($kernel, 'migrate', ['--force' => true]);
        showResult('php artisan migrate --force', $r);
        break;
        
    case 'cache':
        echo "<h2>🔄 Clear & Optimize Cache</h2>";
        
        $commands = [
            ['config:clear', 'Clear Config Cache'],
            ['cache:clear', 'Clear Application Cache'],
            ['route:clear', 'Clear Route Cache'],
            ['view:clear', 'Clear View Cache'],
            ['config:cache', 'Cache Config'],
            ['route:cache', 'Cache Routes'],
            ['view:cache', 'Cache Views'],
            ['optimize', 'Optimize Application'],
        ];
        
        foreach ($commands as [$cmd, $label]) {
            $r = runArtisan($kernel, $cmd);
            showResult("php artisan {$cmd} - {$label}", $r);
        }
        break;
        
    case 'storage':
        echo "<h2>📁 Storage Link</h2>";
        $r = runArtisan($kernel, 'storage:link');
        showResult('php artisan storage:link', $r);
        break;
        
    case 'all':
        echo "<h2>⚡ Menjalankan Semua Proses Deploy</h2>";
        
        // 1. Migrate
        echo "<h3 class='info'>1. Database Migration</h3>";
        $r = runArtisan($kernel, 'migrate', ['--force' => true]);
        showResult('php artisan migrate --force', $r);
        
        // 2. Storage link
        echo "<h3 class='info'>2. Storage Link</h3>";
        $r = runArtisan($kernel, 'storage:link');
        showResult('php artisan storage:link', $r);
        
        // 3. Clear caches
        echo "<h3 class='info'>3. Clear Semua Cache</h3>";
        foreach (['config:clear', 'cache:clear', 'route:clear', 'view:clear'] as $cmd) {
            $r = runArtisan($kernel, $cmd);
            showResult("php artisan {$cmd}", $r);
        }
        
        // 4. Rebuild caches
        echo "<h3 class='info'>4. Build Ulang Cache (Production)</h3>";
        foreach (['config:cache', 'route:cache', 'optimize'] as $cmd) {
            $r = runArtisan($kernel, $cmd);
            showResult("php artisan {$cmd}", $r);
        }
        
        echo "<div class='step'><strong class='success'>✅ Semua proses deploy selesai!</strong>";
        echo "<div class='output success'>Website Anda sudah siap untuk digunakan.\nJangan lupa HAPUS file deploy_migrate.php ini dari server!</div>";
        echo "</div>";
        break;
}
?>

<div style="margin-top: 30px; padding: 15px; background: #2d0000; border: 2px solid #ff4444; border-radius: 8px;">
    <strong class="error">⚠️ PENTING: Hapus file ini dari server setelah selesai!</strong><br>
    File ini berbahaya jika dibiarkan di server production karena memberikan akses penuh ke artisan commands.
</div>

</div>
</body>
</html>
<?php
$kernel->terminate(new Symfony\Component\HttpFoundation\Request(), 0);
?>
