<?php
header('Content-Type: application/json');
$postData = file_get_contents("php://input");
$request = json_decode($postData);

$username = $request->username;
$isOnline = $request->isOnline;

$usersJson = file_get_contents('users.json');
$users = json_decode($usersJson, true);

foreach ($users as &$user) {
  if ($user['username'] === $username) {
    $user['online'] = $isOnline;
    break;
  }
}

file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
echo json_encode(['success' => true,'message' => '在线状态更新成功']);
?>