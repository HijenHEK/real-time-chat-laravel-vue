<template>
  <div>
    
    <div>
      <form class="form" @submit.prevent="addContact" @keydown="form.onKeydown($event)">
      <label for="username"></label>
        <input v-model="form.uname" id="username" type="text" name="uname" placeholder="enter a username"
            class="form-control" :class="{ 'is-invalid': form.errors.has('uname') }">

        <button :disabled="form.busy" type="submit" class="btn btn-primary">add!</button>
      </form>
    </div>

    <div class="discussion"  v-for="discussion in discussions" :class="{'selected' : discussion.id == selected}"  :key="discussion.index"  @click="selectDiscussion(discussion.id)" >
              <div class="username">{{discussion.users[0].name}}</div>
              <div class="meta">
              <div class="lastMessage" v-if="discussion.messages[0]">{{ discussion.messages[0].content}}</div>
              <div class="lastMessage" v-if="discussion.messages[0]">{{discussion.messages[0].created_at | moment("from", "now")}}</div>
              </div>
    </div>
    
    
    
  </div>
</template>

<script>
// import moment from 'moment'
import Form from 'vform'
export default {
  props : ['discussions', 'auth' , 'selected'],
  data() {
    return {
      form : new Form({
        uname : ''
      })
    }
  },

  // filters: {
  //   moment: function (date) {
  //     return moment(date).fromNow();
  //   }
  // },

  methods : {
    moment() {
      return moment("from" , "now");
    },
    selectDiscussion(el){
      
      this.$emit('discussion-selected' , el)
    },
    addContact(){
      this.form.post('/discussions').then((response) => {
        this.form.reset()
      })
        
        
    }
  },
  mounted() {

    console.log(this.discussions)
  }
}
</script>

<style scoped>
  .discussion {
    padding: 0.5rem 1rem;
    font: 1.1rem;
  }
  .discussion:hover {
    background-color: rgb(171, 208, 250);
    color: black;
    cursor: pointer;
  }
  .discussion.selected {
    background-color: rgba(44, 146, 255, 0.836);
    color: white;
  }
  .form {
    background-color: rgb(188, 219, 255) ;
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items:  flex-start;
    box-shadow: 0 1px 2px 1px rgb(188, 219, 255);
  }
 
  input {
    border: none;
    outline: none;
    border-radius: 5px;
    resize: none;
    flex: 1;

  }
  button {
      margin-left: 10px ;
  }
  .username {
        padding: 0.5rem 0;
        font-size: 1.1rem;
        font-weight: 500;

  }
  .meta {
    display: flex;
    justify-content: space-between;
    padding-bottom: 0.2rem;
  }
</style>