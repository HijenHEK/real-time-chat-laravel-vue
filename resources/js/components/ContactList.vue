<template>
  <div class="contactList">
    
    <div>
      <form class="form" @submit.prevent="addContact" @keydown="form.onKeydown($event)">
      <label for="username"></label>
        <div class="group">
          <input v-model="form.uname" id="username" type="text" name="uname" placeholder="enter a username"
            class="form-control" :class="addContactClass">
          <div v-if="form.errors.has('uname')" class="error"> 
               {{form.errors.get('uname')}}
          </div>
          <div v-else-if="form.errors.any()" class="error"> 
               {{formResponse}}
          </div>
          <div v-else-if="form.successful" class="error"> 
               {{formResponse}}
          </div>
        </div>
        <button :disabled="form.busy" type="submit" class="btn btn-primary">add!</button>
      </form>
    </div>

    <div class="discussion"  v-for="discussion in discussions" :class="{'selected' : discussion.id == selected}"  :key="discussion.index"  @click="selectDiscussion(discussion.id)" >
              <div class="username">{{discussion.users[0].name}}</div>
              <div class="meta">
              <div class="lastMessage" v-if="discussion.messages[0]">{{ discussion.messages[0].content | max30() }}</div>
              <div class="createdAt" v-if="discussion.messages[0]">{{discussion.messages[0].created_at | moment("from", "now")}}</div>
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
        uname : '',
      }),
      formResponse : '',
    }
  },
  computed : {
    addContactClass(){
      if(this.form.errors.any()) {
        return 'is-invalid'
      }else if (this.form.successful){
        return 'is-valid'
      }
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
      this.form.post('/contacts')
      // .then(response => this.formResponse = response.payload )
      .then(response => this.form.reset())
      
        
        
    }
  },
  filters : {
    max30(s) {
      if(s.length > 30) {
        return s.slice(0 , 31) + ' ...'
      }
      else {
        return s
      }
    }
  },
  mounted() {
    console.log(this.discussions)
  }
}
</script>

<style scoped>
.contactList{
      box-shadow : 1px 0 2px 1px rgb(182, 220, 255);
      height: 100%;
}
  .discussion {
    padding: 0.5rem 1rem;
    font: 1.1rem;
    box-shadow: 0 1px 1px 1px rgb(188, 219, 255);
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
  .error {
    padding-top: 5px;
    padding-left: 5px;
    color: rgb(231, 56, 56);
  }
  input {
    border: none;
    outline: none;
    border-radius: 5px;
    resize: none;
    
    flex: 1;

  }
  .group {
    width: 100%;
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

  .lastMessage {
    flex: 70%;
  }
  .createdAt {
    flex: 30%;
  }
</style>