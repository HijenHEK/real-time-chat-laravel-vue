<template>
    <div class="container-xl whatsgood">
                <contact-list v-on:search-discussions="search" v-on:discussion-selected="getDiscussion" :auth="auth" :selected="discussion_id" :discussions="searchResults"></contact-list>
                <chat-box  :id="discussion_id" :auth="auth" :discussion="discussion"></chat-box>
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
                searchResults : {},
                discussion : null ,
                discussion_id : null,
                tabFocus : true ,
                unreadCount : 0
            }
        },
        methods : {
            
            search(s){
                if(s === '') {
                this.searchResults = this.discussions
              }else {

                this.searchResults = this.discussions.filter((d) => {
                        // console.log(this.search , d.users[0].name)
                        if( d.users[0].name.includes(s)) {
                            return d
                        }
                });
              }
            },
            getContactList(){
                axios.get('/discussions')
                    .then((response) => {
                        this.discussions = response.data
                        this.searchResults = response.data

                        }).then(()=>{
                        var count = 0
                        for( const d in this.discussions ) {
                            count = count + this.discussions[d].unreadCount
                        }
                        this.unreadCount =  count 
                    });
            },
            
            getDiscussion(discussion) {
                
                this.discussion_id = discussion
                if(this.discussion_id) {
                    axios.get('/discussions/' + discussion +'?page=1&view=' + this.tabFocus)
                    .then((response) => {this.discussion = response.data})

                }
                


            },
            playNew(){
                var audio = new Audio('new.mp3');
                audio.play();
            },
            detectFocusOut() {
                    let inView = false;

                    const onWindowFocusChange = (e) => {
                        if ({ focus: 1, pageshow: 1 }[e.type]) {
                            if (inView) return;
                            this.tabFocus = true;
                            inView = true;
                        } else if (inView) {
                            this.tabFocus = !this.tabFocus;
                            inView = false;
                        }
                    };

                    window.addEventListener('focus', onWindowFocusChange);
                    window.addEventListener('blur', onWindowFocusChange);
                    window.addEventListener('pageshow', onWindowFocusChange);
                    window.addEventListener('pagehide', onWindowFocusChange);
                }
        },
        watch :{
            tabFocus :function(val) {
                if(val){
                    this.getDiscussion(this.discussion_id)
                }
            },
            unreadCount:function(oldval , newval) {
                if(newval){
                    console.log('new msg')
                    this.playNew()
                }
            }
        },
        mounted() {
            this.detectFocusOut()
            Echo.channel('update')
                .listen('Update', e => {
                        this.getContactList()
                        this.getDiscussion(this.discussion_id)
                });
            axios.get('/discussions')
                    .then((response) => {
                        
                        this.discussions = response.data
                        this.searchResults = response.data
                        console.log(this.discussions)
                    }).then(()=>{
                        var count = 0
                        for( const d in this.discussions ) {
                            count = count + this.discussions[d].unreadCount
                        }
                        this.unreadCount =  count 
                    });
                    
                    
        }
    }
</script>

<style scoped>
    .whatsgood {
        box-shadow : 0px 0 2px 2px rgb(182, 220, 255);
        height: 100%;
            background-color: rgb(239, 243, 248) ;
        overflow: hidden;
        position: relative;
        display: flex;
        padding: 0;
        justify-content: stretch;
        
    }
    .col-md-4 , .col-md-8 {
       padding : 0 ; 
      height: 100%;

    }
</style>
