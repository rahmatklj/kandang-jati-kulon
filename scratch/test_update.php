<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/dashboard/settings/update', 'PUT', [
    'nama_lurah' => 'H. Ahmad Syarif, S.STP, M.Si',
    'additional_aparatur' => [
        ['name' => 'FAISOL, S.Sos', 'jabatan' => 'Pengelola Layanan Operasional', 'nip' => '197508292010011002', 'atasan' => '', 'photo_url' => '', 'photo_old' => ''],
        ['name' => 'SUDARIYANTO', 'jabatan' => 'Operator Layanan Operasional', 'nip' => '198803212025211089', 'atasan' => '', 'photo_url' => '', 'photo_old' => ''],
        ['name' => 'SUSI SUSANTI', 'jabatan' => 'Operator Layanan Operasional', 'nip' => '199404132025212093', 'atasan' => '', 'photo_url' => '', 'photo_old' => ''],
        ['name' => 'ANGGOTA BARU KE 4', 'jabatan' => 'Staf Pelayanan', 'nip' => '199901012024011001', 'atasan' => '', 'photo_url' => '', 'photo_old' => '']
    ]
]);

$controller = new App\Http\Controllers\SettingController();
try {
    $response = $controller->update($request);
    echo "SUCCESS: Saved " . App\Models\Setting::where('key', 'additional_aparatur')->value('value') . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
