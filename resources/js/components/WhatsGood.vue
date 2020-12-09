<template>
    <div class="container whatsgood">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <contact-list :auth="auth" :discussions="discussions"></contact-list>
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
        props : ['auth'],
        components : {
            ContactList,
            ChatBox
        },
        data(){
            return {
                discussions : {}
            }
        },
        methods : {
            getContactList(){
                axios.get('/discussions')
                    .then((response) => {this.discussions = response.data})
            }
        },
        mounted() {
            this.getContactList()
        }
    }
</script>

<style scoped>
    .whatsgood {
        box-shadow: 0 0 2px 1px rgb(22, 83, 214);
    }
    .col-md-4 , .col-md-8 {
       padding : 0 ; 
    }
</style>
