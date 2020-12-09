<template>
<div class="chat-box">


  <div class="discussion">
    <div v-for="message in discussion" :key="message.id" class="msg"  :class="message.user.id === auth ? 'send' : 'receive' " >
          {{message.content}}
    </div>


  </div>
  
  
  <form class="form" @submit.prevent="sendMsg" @keydown="form.onKeydown($event)">
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
  methods : {
    sendMsg(){

      this.form.post('/messages/'+this.id)
        

    }
  }
}
</script>

<style scoped>

  .chat-box {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: space-between;
    box-shadow : -1px 0 2px 1px rgb(182, 220, 255);
    background-color: rgb(232, 241, 252) ;
  }
  .discussion {
    display: flex;
    flex-direction: column-reverse;
    width: 100%;
    height: 100%;
    overflow-y: scroll;
    

  }
  .msg {
    padding: 0.5rem 1rem;
    border-radius:  5px;
    background-color: rgb(0, 132, 255) ;
    color: white;
    margin: 0.5rem;
    min-width: 6rem;
    box-shadow: 0 0 1px 1px rgb(0, 162, 255) ;
  }
  .msg:last-child::before{
    content: '';
    padding: 5rem;
  }
  .send {
    align-self: flex-end;
    text-align: right;
    background-color: rgb(0, 162, 255) ;

  }
  .receive {
    align-self: flex-start;
    

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