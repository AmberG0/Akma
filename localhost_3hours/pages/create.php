<?

$var = 1;

$stmt = $pdo ->prepare('SELECT * FROM user WHERE ID = ?');
$stmt -> execute([$var]);
$order = $stmt -> fetchAll();

?>