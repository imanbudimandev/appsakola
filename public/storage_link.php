<?php
/**
 * Storage Link Creator
 * Upload file ini ke: public/storage_link.php
 * Buka di browser: https://yourdomain.com/storage_link.php
 * HAPUS file ini setelah berhasil!
 */

$target = dirname(__DIR__) . '/storage/app/public';
$link   = __DIR__ . '/storage';

if (is_link($link)) {
    echo '<p style="color:orange">⚠️ Symlink sudah ada di: ' . $link . '</p>';
} elseif (is_dir($link)) {
    echo '<p style="color:orange">⚠️ Folder /public/storage sudah ada (bukan symlink).</p>';
} else {
    // Try symlink first
    if (function_exists('symlink') && @symlink($target, $link)) {
        echo '<p style="color:green">✅ Symlink berhasil dibuat!</p>';
    } else {
        // Fallback: copy all files
        echo '<p>Symlink gagal, mencoba copy file...</p>';
        
        if (!is_dir($link)) {
            mkdir($link, 0755, true);
        }

        function copyDir($src, $dst) {
            if (!is_dir($dst)) mkdir($dst, 0755, true);
            $files = scandir($src);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;
                if (is_dir($srcPath)) {
                    copyDir($srcPath, $dstPath);
                } else {
                    copy($srcPath, $dstPath);
                }
            }
        }

        copyDir($target, $link);
        echo '<p style="color:green">✅ File storage berhasil disalin ke public/storage!</p>';
    }
}

echo '<p>Target: ' . $target . '</p>';
echo '<p>Link: ' . $link . '</p>';
echo '<hr>';
echo '<p style="color:red"><strong>⚠️ PENTING: Hapus file ini setelah berhasil!</strong></p>';
echo '<p><a href="' . str_replace('storage_link.php', '', $_SERVER['PHP_SELF']) . '">← Kembali ke website</a></p>';
