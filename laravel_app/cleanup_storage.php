<?php
$target = __DIR__ . '/public/storage';
if (file_exists($target)) {
    if (is_link($target)) {
        unlink($target);
        echo "Deleted link.";
    } elseif (is_dir($target)) {
        system('rm -rf ' . escapeshellarg($target));
        echo "Deleted directory.";
    } else {
        unlink($target);
        echo "Deleted file.";
    }
} else {
    echo "Nothing found at $target";
}
