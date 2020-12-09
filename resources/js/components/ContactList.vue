<template>
  <div>
    
    <div class="discussion"  v-for="discussion in discussions" :key="discussion.index"  @click="selectDiscussion(discussion.id)" >
              <h5>{{discussion.users[0].name}}</h5>
              <h5>{{discussion.id}}</h5>
              <div >{{ discussion.messages[0] ? discussion.messages[0].content : ''}}</div>
    </div>
    
  </div>
</template>

<script>
export default {
  props : ['discussions', 'auth'],
  methods : {
    selectDiscussion(el){
      
      this.$emit('discussion-selected' , el)
    }
  },
  mounted() {
  }
}
</script>

<style scoped>
  .discussion {
    padding: 0.5rem 1rem;
    font: 1.1rem;
  }
  .discussion:hover {
    background-color: rgb(5, 115, 231);
    color: white;
    cursor: pointer;
  }
</style>