<?php
header('Content-Type: application/json');
$postData = file_get_contents("php://input");
$request = json_decode($postData);

$username = $request->username;
$message = $request->message;
$chatType = $request->chatType;
$toUserId = $request->toUserId;

$messages = [];

if (file_exists('messages.json')) {
  $messagesJson = file_get_contents('messages.json');
  $messages = json_decode($messagesJson, true);
}

$newMessage = [
  'username' => $username,
  'message' => $message,
  'chatType' => $chatType,
  'toUserId' => $toUserId
];

$messages[] = $newMessage;

file_put_contents('messages.json', json_encode($messages, JSON_PRETTY_PRINT));

// 如果是一对一聊天，更新用户的聊天记录
if ($chatType === 'private') {
  $usersJson = file_get_contents('users.json');
  $users = json_decode($usersJson, true);

  $fromUser = null;
  $toUser = null;

  foreach ($users as &$user) {
    if ($user['username'] === $username) {
      $fromUser = &$user;
    }
    if ($user['id'] === $toUserId) {
      $toUser = &$user;
    }
  }

  if ($fromUser && $toUser) {
    if (!isset($fromUser['chatRecords'][$toUserId])) {
      $fromUser['chatRecords'][$toUserId] = [];
    }
    if (!isset($toUser['chatRecords'][$fromUser['id']])) {
      $toUser['chatRecords'][$fromUser['id']] = [];
    }

    $fromUser['chatRecords'][$toUserId][] = $newMessage;
    $toUser['chatRecords'][$fromUser['id']][] = $newMessage;

    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
  }
}

echo json_encode(['success' => true, 'message' => '消息发送成功']);
?>