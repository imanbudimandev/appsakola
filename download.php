<?php
$zipFile = 'public/pluto.zip';
$extractPath = 'public/';

$url = 'https://github.com/hiteshindus/pluto-admin-dashboard/archive/refs/heads/main.zip';

echo "Downloading from $url...\n";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
file_put_contents($zipFile, curl_exec($ch));
curl_close($ch);

echo "Extracting...\n";
$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo($extractPath);
    $zip->close();
    echo "Extracted successfully!\n";
    unlink($zipFile);
} else {
    echo "Failed to extract.\n";
}
