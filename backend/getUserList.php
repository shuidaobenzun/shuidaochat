<?php
header('Content-Type: application/json');

$usersJson = file_get_contents('users.json');
$users = json_decode($usersJson, true);

$onlineUsers = [];
foreach ($users as $user) {
  if ($user['online']) {
    $onlineUsers[] = $user['username'];
  }
}

echo json_encode(['users' => $onlineUsers]);
?>