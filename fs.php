<?php

$files = new RecursiveCallbackFilterIterator(
    new RecursiveDirectoryIterator(__DIR__ . "/src"),
    function($current, $key, $iterator) {
        if ($iterator->hasChildren()) {
            return true;
        }
        if ("php" === $current->getExtension()) {
            return true;
        }

        return false;
    }
);

foreach (new RecursiveIteratorIterator($files) as $file) {
    echo $file . PHP_EOL;
    $content = file_get_contents($file);
    $newContent = preg_replace("#\*/\s+namespace#", "*/\nnamespace", $content);
    file_put_contents($file, $newContent);
}
