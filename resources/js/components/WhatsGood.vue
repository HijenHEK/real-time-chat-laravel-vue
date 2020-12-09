<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <contact-list></contact-list>
            </div>
            <div class="col-md-8">
                <chat-box></chat-box>
                
            </div>            
        </div>
    </div>
</template>

<script>
import ContactList from './ContactList.vue'
import ChatBox from './ChatBox.vue'
    export default {
        components : {
            ContactList,
            ChatBox
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
