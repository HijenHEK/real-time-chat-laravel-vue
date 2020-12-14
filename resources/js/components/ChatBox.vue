<template>
<div class="chat-box" v-if="discussion && id">


  <div class="discussion">
    <div v-for="message in discussion" :key="message.id" class="msg"  :class="message.user.id === auth ? 'send' : 'receive' " >
          
          <span class="content">

          <span class="pre">{{message.content}}</span> 
          
          </span>
          <!-- <img class="eye" src="eye.jpg" v-if="message.views.length> 0 && message.user.id === auth && message.id > discussion.length - 1"> -->
          <div class="avatar" v-if="message.views.length> 0 && message.user.id === auth && message.id > discussion.length - 1">
          <img :src="message.user.avatar" >
          </div>

          <span class="time">
              {{message.created_at | moment("calendar") | removeToday()}}
          </span>
              
    </div>

  </div>
  
  
  <form  class="form"  @submit.prevent="sendMsg" @keypress="handleKeys($event)">
      <textarea v-model="form.content" type="text" name="content"
          class="form-control" :class="{ 'is-invalid': form.errors.has('content') }"></textarea>

      <button :disabled="form.busy" type="submit" class="btn btn-primary">Send !</button>
  </form>
</div>

  


</template>

<script>
import Form from 'vform'
export default {
  props : ['discussion' ,'id', 'auth'],
  data() {
    return {
      form : new Form({
        content : ''
      })

    }
  },
  filters: {
    removeToday(S) {
      if(S.includes('Today at ')){
        return S.slice(9,-2)
      }
      return S
    }
  },
  methods : {
    handleKeys(event){

      if (event.keyCode == 13  && !event.shiftKey) {
        event.preventDefault();
        this.sendMsg();
      }
    }, 

       sendMsg(){

      this.form.post('/messages/'+this.id).then((response) => {
        this.form.reset()
        this.form.fill({
          content :''
        })
        this.form.content.focus();
        
      })
        

    }
  },
  mounted() {
    
  }
}
</script>

<style scoped>
  .eye {
    max-width: 1.5rem;
    margin: 0 0.2rem ;
  }
  .avatar {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 100%;
    overflow: hidden;
    box-shadow: 0 0 2px 1px rgb(100, 198, 255);
    margin: 0 0.5rem;
  }
  .avatar img {
    height: 100%;
  }
  .chat-box {
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: space-between;
    background-color: rgb(232, 241, 252) ;
  }
  .discussion {
    display: flex;
    flex-direction: column-reverse;
    width: 100%;
    height: 100%;
    overflow-y: scroll;
    overflow-x:hidden; 

  }
  /*.discussion::-webkit-scrollbar-track-piece {
      color: rgb(0, 0, 0);
      border-radius: 5px;
  }
   .discussion::-webkit-scrollbar-corner {
      display: none;
  }

  .discussion::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px rgb(0, 162, 255); 

      max-width: 7px;
      color: rgb(0, 132, 255);
      background-color: rgb(232, 241, 252);

  }*/
  .msg {

    margin: 0.5rem;

    max-width: 80%;
    display: flex;
    align-items: flex-end;
  }
  .msg:last-child .content::before{
    content: '';
    padding: 5rem;
  }
  .time {
    margin: 0.5rem;
    font-size: 0.7rem;
    opacity: 0.1;
  }
  
  .msg:hover .time{
    opacity: 0.8;
    transition:all 0.5s ease-in-out;
  }
  .msg .content {
    color: white;
    padding: 0.5rem 1rem;
    border-radius:  5px;
    min-width: 4rem;
    word-break: break-all ;
    box-shadow: 0 0 1px 1px rgb(0, 162, 255) ;
    
  }
  .send .content {
    text-align: right;
    background-color: rgb(0, 132, 255) ;

  }
  .receive .content {
    text-align: right;
        background-color: rgb(0, 162, 255) ;

  }
  .send {
    align-self: flex-end;
    text-align: right;
    flex-direction: row-reverse;
  }
  .receive {
    align-self: flex-start;


  }
  .pre {
    white-space: pre-line;
  }
  .form {
    margin-top: 10px ;
    background-color: rgb(188, 219, 255) ;
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items:  flex-end;
    box-shadow: 0 -1px 2px 1px rgb(188, 219, 255);
  }
 
  textarea {
    border: none;
    outline: none;
    border-radius: 5px;
    resize: none;
    flex: 1;

  }
  button {
      margin-left: 10px ;
      margin-bottom: 5px ;
  }
</style>