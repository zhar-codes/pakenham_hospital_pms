<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');
$pw = $_GET['pw'] ?? 'Test#123';
echo password_hash($pw, PASSWORD_DEFAULT);
