<template>
  <div class="cover-photo dropright">

  </div>
</template>

<script>
    export default {
        props: {
          userId: {
            type: String,
            require: true
          },
          viewProfileUrl: {
            type: String,
            require: true
          },
          selectProfileUrl: {
            type: String,
            require: true
          }
        },
        data() {
            return {
                id: this.userId,
                viewProfile: this.viewProfileUrl,
                selectProfile: this.selectProfileUrl,
                avatar: ''
            }
        },
        mounted() {
          axios.get('/user/'+this.id+'/avatar')
            .then(res => this.avatar = res.data)
        },
        methods: {

        }
    }
</script>

<style lang="scss" scoped>
  .cover-photo{
    height: 300px;
    width: 100%;
    background-color: pink;

  }

</style>
