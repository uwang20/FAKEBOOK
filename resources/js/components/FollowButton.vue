<template>
  <div class="follow-container">
        <div v-if="confirmedFriend">
                <button class="btn btn-primary mt-2 mr-2">MESSAGE</button>
                <span class="dropdown">
                    <button 
                            class="btn btn-primary dropdown-toggle mt-2" 
                            type="button" 
                            id="dropdDownMenuButton" 
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"></button>

                    <div class="dropdown-menu" aria-labelledby="dropDownMenuButton">
                        <span class="dropdown-item" @click="unfriend">Unfriend</span>
                    </div>       

                </span>
        </div>
        <div v-else>
            <div v-if="pendingRequest">
                <button class="btn btn-primary mt-2 mr-2" @click="confirmAsFriend">CONFIRM</button>
                <button class="btn btn-danger mt-2" @click="deleteRequest">DELETE</button>
            </div>
            <div v-else>
                <button class="btn btn-primary mt-2" @click="addFriend" v-text="sendRequest"></button>
            </div>
        </div>
  </div>
</template>

<script>
export default {
    props: {
        userId: {
            type: String,
            required: true
        },
        requestsFromAuth: {
            type: String,
            required: true
        },
        requestsToAuth: {
            type: String,
            required: true
        },
        userRequestConfirmed: {
            type: String,
            required: true
        },
        authRequestConfirmed: {
            type: String,
            required: true
        }
    },
    mounted(){
        
    },
    data(){
        return {
            requestsFromAuthStatus : this.requestsFromAuth,
            requestsToAuthStatus : this.requestsToAuth,
            userRequestConfirmedStatus: this.userRequestConfirmed,
            authRequestConfirmedStatus : this.authRequestConfirmed,
        }
    },
    methods: {
        addFriend(){
            axios.post(`/add/${parseInt(this.userId)}`)
                .then(res => this.requestsFromAuthStatus = !this.requestsFromAuthStatus)
        },
        deleteRequest(){
            axios.delete(`/delete/${parseInt(this.userId)}`)
                .then(res => this.requestsToAuthStatus = !this.requestsToAuthStatus)
        },
        confirmAsFriend(){
            axios.patch(`/confirm/${parseInt(this.userId)}`)
                .then(res => {  console.log(res.data)
                    this.userRequestConfirmedStatus = '1'
                    // this.requestsToAuthStatus = !this.requestsToAuthStatus
                    // this.confirmedAsFriend = !this.confirmedAsFriend
                })
        },
        unfriend(){
            axios.delete(`/delete/${parseInt(this.userId)}`)
                .then(res => { console.log(res.data)
                    this.userRequestConfirmedStatus = '0'
                    this.authRequestConfirmedStatus = '0'
                    this.requestsToAuthStatus = false
                    this.requestsFromAuthStatus = false
                    // this.friendIsNotConfirmed = true
                    // this.isAlreadyFriend = true
                })
        }
    },
    computed: {
        sendRequest(){
           return (this.requestsFromAuthStatus)? 'Cancel Request' : 'Add Friend'
        },
        pendingRequest(){
            if(this.requestsFromAuthStatus){
                return false
            }
            else if(this.requestsToAuthStatus){
                return true
            }
            else{
                return false
            }
        },
        confirmedFriend(){
            if(this.authRequestConfirmedStatus === '1'){
                return true
            }
            else if(this.userRequestConfirmedStatus === '1'){
                return true
            }
            else{
                return false
            }
        }
    }
}
</script>

<style>

</style>