<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=elearning', 'root', '');
$stmt = $pdo->query("DESCRIBE users");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Users Table Columns:\n";
echo str_repeat("=", 70) . "\n";
foreach($columns as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . ' - ' . ($col['Null'] == 'YES' ? 'nullable' : 'required') . "\n";
}
