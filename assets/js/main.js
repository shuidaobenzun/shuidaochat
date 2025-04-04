const { createApp } = Vue;

createApp({
  data() {
    return {
      newMessage: '',
      messages: [],
      userList: [],
      selectedChatType: 'group',
      selectedUser: null
    };
  },

  mounted() {
    this.getMessages();
    this.getUserList();
    setInterval(() => {
      this.getMessages();
      this.getUserList();
    }, 3000);
  },

  methods: {
    sendMessage() {
      const username = localStorage.getItem('username');
      if (this.newMessage.trim()!== '' && username) {
        let toUserId = null;
        if (this.selectedChatType === 'private') {
          toUserId = this.selectedUser;
        }

        fetch('backend/sendMessage.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            username,
            message: this.newMessage,
            chatType: this.selectedChatType,
            toUserId
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            this.newMessage = '';
            this.getMessages();
          } else {
            alert(data.message);
          }
        });
      }
    },

    getMessages() {
      const username = localStorage.getItem('username');
      let url = `backend/getMessages.php?username=${username}&chatType=${this.selectedChatType}`;
      if (this.selectedChatType === 'private') {
        url += `&toUserId=${this.selectedUser}`;
      }

      fetch(url)
      .then(response => response.json())
      .then(data => {
        this.messages = data.messages;
      });
    },

    getUserList() {
      fetch('backend/getUserList.php')
      .then(response => response.json())
      .then(data => {
        this.userList = data.users;
      });
    }
  }
}).mount('#app');