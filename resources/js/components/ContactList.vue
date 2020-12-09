<template>
  <div>
    
    <div class="discussion"  v-for="discussion in discussions" :key="discussion.index" >
              <h5>{{discussion.users[0].name}}</h5>
              <div >{{ discussion.messages[0] ? discussion.messages[0].content : ''}}</div>
    </div>
    
  </div>
</template>

<script>
export default {
  props : ['discussions', 'auth'],
  
  mounted() {
    console.log(this.discussions)
  }
}
</script>

<style>
  .discussion {
    padding: 0.5rem 1rem;
    font: 1.1rem;
  }
  .discussion:hover {
    background-color: rgb(45, 105, 216);
    color: white;
    cursor: pointer;
  }
</style>