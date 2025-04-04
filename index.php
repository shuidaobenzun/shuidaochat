<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>聊天室</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div id="app" class="container-fluid py-5">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h1 class="text-center mb-4">聊天界面</h1>
        <div id="messageList" class="list-group mb-3"></div>
        <div class="input-group mb-3">
          <input v-model="newMessage" placeholder="输入消息" class="form-control">
          <button @click="sendMessage" class="btn btn-primary">发送</button>
        </div>
      </div>
      <div class="col-md-4">
        <h1 class="text-center mb-4">在线用户</h1>
        <div id="userList" class="list-group"></div>
      </div>
    </div>
  </div>

  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>