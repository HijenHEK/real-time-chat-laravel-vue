<template>
    <div class="container-xl whatsgood">
        <div class="row justify-content-between h-100">
            <div class="col-md-4">
                <contact-list v-on:discussion-selected="getDiscussion" :auth="auth" :selected="discussion_id" :discussions="discussions"></contact-list>
            </div>
            <div class="col-md-8">
                <chat-box :id="discussion_id" :auth="auth" :discussion="discussion"></chat-box>
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
                discussions : {},
                discussion : null ,
                discussion_id : null
            }
        },
        methods : {
            getContactList(){
                axios.get('/discussions')
                    .then((response) => {this.discussions = response.data})
            },
            
            getDiscussion(discussion) {
                this.discussion_id = discussion
                axios.get('/discussions/' + discussion)
                .then((response) => {this.discussion = response.data})


            }
        },
        mounted() {
            Echo.channel('update')
                .listen('Update', e => {
                        this.getContactList()
                        this.getDiscussion(this.discussion_id)
                });
            axios.get('/discussions')
                    .then((response) => {
                        
                        this.discussions = response.data
                        console.log(this.discussions)
                    })
                    
        }
    }
</script>

<style scoped>
    .whatsgood {
        box-shadow : 0px 0 2px 2px rgb(182, 220, 255);
        height: 100%;
            background-color: rgb(239, 243, 248) ;
    }
    .col-md-4 , .col-md-8 {
       padding : 0 ; 
      height: 100%;

    }
</style>
