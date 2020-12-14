<template>
  <div class="contactList">
    
    <div>
      <div class="nav">
          <a href="/profile">
          
              <font-awesome-icon class="icon" icon="cog" size="lg"/>
          
          </a> 

          <font-awesome-icon @click="setMenu('search')" class="icon" icon="search" size="lg"/>

          <font-awesome-icon @click="setMenu('add')" class="icon" icon="plus" size="lg"/>

          <font-awesome-icon class="icon" icon="bars" size="lg"/>
      </div>
      <form v-if="menu==='add'" class="form" @submit.prevent="addContact" @keydown="form.onKeydown($event)">
        <label for="username"></label>
          <div class="group">
            <input v-model="form.uname" ref="add" id="username" type="text" name="uname" placeholder="enter a username"
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

      <div v-if="menu==='search'" class="form" >
        <input @keydown="filterDiscussions()" ref="search" type="text" class="form-control" v-model="searchQuery" placeholder="search for a discussion">
      </div>
    </div>

      <div v-for="discussion in discussions"  :key="discussion.index"  @click="selectDiscussion(discussion)" >
              <div v-if="discussion.users[0].requests_in[0] || discussion.users[0].requests_out[0]" class="discussion" :class="discussionItemClass(discussion)" >
                
                    <div  class="avatar" >
                           <img :src="discussion.users[0].avatar" alt="" srcset="">
                    </div>
                
                    <div class="content">
                            <div class="header">
                                <div class="username">
                                  {{discussion.users[0].name}}
                                </div>

                                <div class="unreadCount" v-if="discussion.unreadCount"> {{discussion.unreadCount}}</div>
                  
                                <div v-if="!discussion.users[0].pivot.contact && discussion.pivot.contact" class="status">
                                
                                  Request pending ... 
                                  <button class="btn btn-sm btn-warning" @click="deleteRequest(discussion.users[0].uname)">cancel</button>
                                </div>
                              
                                <div v-if="!discussion.pivot.contact && discussion.users[0].pivot.contact" class="status"> 
                                  <button class="btn btn-sm btn-success" @click="acceptRequest(discussion.users[0].uname,discussion.id)">accept</button>
                                  <button class="btn btn-sm btn-warning" @click="deleteRequest(discussion.users[0].uname)">delete</button>
                                </div>
                            </div>
                          
                            <div class="meta">
                                <div class="lastMessage" v-if="discussion.messages[0]">{{ discussion.messages[0].content | max30() }}</div>
                              <div class="createdAt" v-if="discussion.messages[0]">{{discussion.messages[0].created_at | moment("from", "now")}}</div>
                            </div>
                  </div>
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
      searchQuery : '',
      search : '' ,
      menu : 'none',
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
    setMenu(menu){
      if(this.menu === menu) {
        this.menu = 'none'
      }else {

        this.menu = menu
       
        setTimeout(() => this.$refs[menu].focus(), 1);
      }
      

    },
    filterDiscussions(){
        this.$emit('search-discussions' , this.searchQuery)
    },
    moment() {
      return moment("from" , "now");
    },
    selectDiscussion(el){
      if(el.pivot.contact && el.users[0].pivot.contact) {
          this.$emit('discussion-selected' , el.id)
      }
    },
    addContact(){
      
      this.form.post('/contacts')
      .then(response => this.form.reset())
      
        
        
    },
    acceptRequest(uname,id){
      axios.post('/contacts/'+uname+'/'+id)

    },
    deleteRequest(uname){
      axios.delete('/contacts/'+uname)

    },
    discussionItemClass(discussion){

      let r = '' 
      if(discussion.id == this.selected) {
        r+= ' selected '
      }
      if(!discussion.pivot.contact){
          r+= ' requestRecieved '
      }else if (discussion.pivot.contact && discussion.users[0].pivot.contact === 0) {
         r+= ' requestSent '
      }  
      return r
 
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
.nav {
  padding: 0.5rem 1rem;
  display: flex;
  background-color: rgb(182, 220, 255);
}
.nav > *:last-child {
  margin-left: auto ;
}
.icon {
  color: #3490dc;
  margin: 0 0.3rem;
  cursor: pointer;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.status  {
  font-weight: 500;
  font-size: 0.8rem;
  color: rgba(255, 121, 44, 0.836);
}
.selected .header .status {
  color: rgb(255, 58, 58);
}
.contactList{
      box-shadow : 1px 0 2px 1px rgb(182, 220, 255);
      height: 100%;
}
  .discussion {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    font: 1.1rem;
    box-shadow: 0 1px 1px 1px rgb(188, 219, 255);
  }
  .content {
    flex: 100%;
  }
  .avatar {
    width: 4rem;
    height: 4rem;
    border-radius: 100%;
    box-shadow: 0 0 2px 1px rgb(171, 208, 250);
    margin-right: 1rem ;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink:0 ;
  }
  .avatar > img {
    max-height:100%;
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
  .unreadCount {
    box-shadow: 0 0 2px 1px white;
    color: white;
    border-radius: 10px;
    padding: 0.3rem 0.6rem;
    background-color: rgba(253, 71, 39, 0.836) ;
  }
  .meta {
    display: flex;
    justify-content: space-between;
    padding-bottom: 0.2rem;
  }

  .lastMessage {
    flex: 60%;
  }
  .createdAt {
    flex: 40%;
  }
  @media(max-width: 1000px) {
    .meta {
    flex-direction: column;
    justify-content: unset;
  }

  .lastMessage {
    flex: unset;
  }
  .createdAt {
        flex: unset;

    font-size: 0.8rem;
    justify-self: flex-end;
  }
  }
</style>