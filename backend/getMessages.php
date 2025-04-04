<?php
header('Content-Type: application/json');

if (file_exists('messages.json')) {
  $messagesJson = file_get_contents('messages.json');
  $messages = json_decode($messagesJson, true);

  $username = $_GET['username']?? null;
  $chatType = $_GET['chatType']?? 'group';
  $toUserId = $_GET['toUserId']?? null;

  if ($chatType === 'group') {
    $filteredMessages = array_filter($messages, function ($msg) {
      return $msg['chatType'] === 'group';
    });
  } else if ($chatType === 'private') {
    $usersJson = file_get_contents('users.json');
    $users = json_decode($usersJson, true);

    $fromUser = null;
    foreach ($users as $user) {
      if ($user['username'] === $username) {
        $fromUser = $user;
        break;
      }
    }

    if ($fromUser && isset($fromUser['chatRecords'][$toUserId])) {
      $filteredMessages = $fromUser['chatRecords'][$toUserId];
    } else {
      $filteredMessages = [];
    }
  }

  echo json_encode(['messages' => array_values($filteredMessages)]);
} else {
  echo json_encode(['messages' => []]);
}
?>