<?php
require 'app/Config/Database.php';
$db = \Config\Database::connect();
$result = $db->query('SELECT * FROM tb_lamaran WHERE id IS NULL OR id = 0');
$rows = $result->getResultArray();
echo 'Records with NULL or 0 id: ' . count($rows) . PHP_EOL;
if (!empty($rows)) {
    print_r($rows);
}
?>