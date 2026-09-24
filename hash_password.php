<?php
if (PHP_SAPI !== 'cli') { echo "Run this script from CLI\n"; exit; }
if ($argc < 2) { echo "Usage: php hash_password.php your_password\n"; exit; }
echo password_hash($argv[1], PASSWORD_DEFAULT) . "\n";
