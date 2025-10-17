<?php require "templates/header.php"; ?>
<div class="center-align">

    <h1>Health Check</h1>
    <br>
<?php
header('Content-Type: application/json');
http_response_code(200);

echo json_encode([
    'status' => 'healthy',
    'timestamp' => date('c'),
]);
?>
<?php require "templates/footer.php"; ?>