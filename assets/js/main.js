const { createApp } = Vue;

createApp({
  data() {
    return {
      newMessage: '',
      messages: [],
      userList: []
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
        fetch('backend/sendMessage.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, message: this.newMessage })
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
      fetch('backend/getMessages.php')
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
