<?php
header('Content-Type: application/json');
$postData = file_get_contents("php://input");
$request = json_decode($postData);

$username = $request->username;
$message = $request->message;

$messages = [];

if (file_exists('messages.json')) {
  $messagesJson = file_get_contents('messages.json');
  $messages = json_decode($messagesJson, true);
}

$newMessage = [
  'username' => $username,
  'message' => $message
];

$messages[] = $newMessage;

file_put_contents('messages.json', json_encode($messages, JSON_PRETTY_PRINT));
echo json_encode(['success' => true,'message' => '消息发送成功']);
?>