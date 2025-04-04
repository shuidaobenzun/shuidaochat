<?php
header('Content-Type: application/json');

if (file_exists('messages.json')) {
  $messagesJson = file_get_contents('messages.json');
  $messages = json_decode($messagesJson, true);
  echo json_encode(['messages' => $messages]);
} else {
  echo json_encode(['messages' => []]);
}
?>