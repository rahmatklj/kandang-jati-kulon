<?php
$viewsDir = dirname(__DIR__) . '/resources/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$count = 0;
foreach ($iterator as $file) {
    if ($file->isFile() && str_contains($file->getFilename(), '.blade.php')) {
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        if (stripos($content, 'sidomukti') !== false) {
            $newContent = str_ireplace('sidomukti', 'Kandang Jati Kulon', $content);
            $newContent = str_replace('Kelurahan Kelurahan Kandang Jati Kulon', 'Kelurahan Kandang Jati Kulon', $newContent);
            $newContent = str_replace('Desa Kelurahan Kandang Jati Kulon', 'Kelurahan Kandang Jati Kulon', $newContent);
            file_put_contents($filePath, $newContent);
            echo "Updated: " . basename($filePath) . "\n";
            $count++;
        }
    }
}
echo "Total files updated: $count\n";
