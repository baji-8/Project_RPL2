<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=elearning', 'root', '');
$stmt = $pdo->query("DESCRIBE quiz");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Quiz Table Schema:\n";
echo str_repeat("=", 50) . "\n";
foreach($columns as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . "\n";
}
