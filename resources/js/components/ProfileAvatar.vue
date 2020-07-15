<template>
  <div class="photo-container">
    <div class="cover-photo dropright">
        <div  :style="{ backgroundImage: `url(${'/storage/'+cover})`}"
              alt=""
              class="dropdown-toggle"
              id="dropdDownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"></div>
        <div class="dropdown-menu ml-2" aria-labelledby="dropDownMenuButton">
          <a :href="viewCover" class="dropdown-item">
            View Cover Photo
          </a>
          <a v-show="id === authUser" :href="selectCover" class="dropdown-item">
            Select Cover Photo
          </a>
        </div>
    </div>
    <div class="profile-photo dropright">
        <div :style="{ backgroundImage: `url(${'/storage/'+avatar})`}"
              alt=""
              class="dropdown-toggle"
              id="dropdDownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"></div>
        <div class="dropdown-menu ml-2" aria-labelledby="dropDownMenuButton">
          <a :href="viewProfile" class="dropdown-item">
            View Profile Picture
          </a>
          <a v-show="id === authUser" :href="selectProfile" class="dropdown-item">
            Select Profile Picture
          </a>
        </div>
    </div>
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
          },
          viewCoverUrl: {
            type: String,
            require: true
          },
          selectCoverUrl: {
            type: String,
            require: true
          },
          auth: {
            type: String,
            require: true
          }
        },
        data() {
            return {
                id: this.userId,
                viewProfile: this.viewProfileUrl,
                selectProfile: this.selectProfileUrl,
                avatar: '',
                viewCover: this.viewCoverUrl,
                selectCover: this.selectCoverUrl,
                cover: '',
                authUser: this.auth
            }
        },
        mounted() {
          axios.get('/user/'+this.id+'/avatar')
            .then(res => this.avatar = res.data)

          axios.get('/user/'+this.id+'/cover-avatar')
            .then(res => this.cover = res.data)

            console.log(this.authUser)
        },
        methods: {

        }
    }
</script>

<style lang="scss" scoped>
.photo-container{
  .cover-photo{
    height: 300px;
    width: 100%;
    background-color: #000000;

    .dropdown-toggle{
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      height: 100%;
    }

  }

  .profile-photo{
    position: absolute;
    left: 25px;
    bottom: 0;
    transform: translateY(50%);
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background-color: cyan;

    .dropdown-toggle{
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border-radius: 50%;
    }
  }
}


</style>
