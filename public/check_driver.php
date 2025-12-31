<?php
echo "Loaded INI: " . php_ini_loaded_file() . "\n";
echo "PDO SQLite Loaded: " . (extension_loaded('pdo_sqlite') ? 'YES' : 'NO') . "\n";
echo "SQLite3 Loaded: " . (extension_loaded('sqlite3') ? 'YES' : 'NO') . "\n";
echo "Extensions: " . implode(', ', get_loaded_extensions());
