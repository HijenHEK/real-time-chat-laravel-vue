<template>
  <div>
    
    <div class="discussion" v-for="user in users" :key="user.index" >
              {{user.name}}
    </div>
    
  </div>
</template>

<script>
export default {
  props : ['users']

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