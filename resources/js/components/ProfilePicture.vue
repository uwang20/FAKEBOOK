<template>
    <div class="modal-bg" v-show="showModal">
        <div class="profile-picture-container row">
            <!-- IMAGES CONTAINER-->
            <div class="profile-image col-md-8">
                <!-- IMAGE CONTAINER, PROFILE/COVER/POST -->
                <div class="image-container">
                    <!-- PROFILE PICTURES -->
                    <div v-if="profiles.length" class="backdrop" v-for="(profile,index) in profiles" :key="index" v-show="profileView === index" :style="{ backgroundImage: `url(${'/storage/' + profile.profile_picture})`}">
                        <img :src="'/storage/' + profile.profile_picture" alt="">
                    </div>
                    <!--END  PROFILE PICTURES -->

                    <!-- COVER PHOTOS -->
                    <div v-if="covers.length" class="backdrop" v-for="(cover,index) in covers" :key="index" v-show="coverView === index" :style="{ backgroundImage: `url(${'/storage/' + cover.cover_photo})`}">
                        <img :src="'/storage/' + cover.cover_photo" alt="">
                    </div>
                    <!-- END COVER PHOTOS -->

                    <!-- POST IMAGES -->
                    <div v-if="postId !== null" class="backdrop" v-for="(postsImage,index) in postsImages.images" :key="index" v-show="postView === index" :style="{ backgroundImage: `url(${'/storage/' + postsImage.image})`}">
                        <img :src="'/storage/' + postsImage.image" alt="">
                    </div>
                    <!-- END POST IMAGES -->

                    <!-- NEXT-PREV -->
                    <div class="prev-next">
                        <div @click="prevPage" class="prev">prev</div>
                        <div @click="nextPage" class="next">next</div>
                    </div>
                    <!-- END NEXT-PREV -->
                </div>
                <!-- END IMAGE CONTAINER -->
            </div>
            <!-- IMAGES CONTAINER-->

            <!-- USER'S INFO AND CAPTION CONTAINER -->
            <div class="caption col-md-4">
                <!-- USER'S INFO AND CAPTION -->
                <div class="info-container">
                    <!-- USER'S INFO -->
                    <div class="user-info">
                        <!-- USER'S PROFILE AVATAR -->
                        <div class="profile-image">
                            <img :src="'/storage/' + profileAvatar" alt="">
                        </div>
                        <!-- END USER'S PROFILE AVATAR -->

                        <!-- USER'S NAME AND DATE POSTED -->
                        <div class="name-date">
                            <!-- USER'S NAME -->
                            <h2 v-text="profileOwner"></h2>
                            <!-- END USER'S NAME -->

                            <!-- PROFILE DATE -->
                            <p v-if="profiles.length" v-for="(info,index) in profiles" :key="index" v-show="profileView === index">
                                {{formatDate(info.created_at)}} <a v-show="id === auth" href="#" @click="setProfile(info.id)">set as profile picture</a>
                            </p>
                            <!-- END PROFILE DATE -->

                            <!-- COVER DATE -->
                            <p v-if="covers.length" v-for="(info,index) in covers" :key="index" v-show="coverView === index">
                                {{formatDate(info.created_at)}} <a v-show="id === auth" href="#" @click="setProfile(info.id)">set as cover photo</a>
                            </p>
                            <!-- END COVER DATE -->

                            <!-- POST DATE -->
                            <p v-if="postId !== null" v-for="(info,index) in postsImages.images" :key="index" v-show="postView === index">
                                {{formatDate(info.created_at)}}
                            </p>
                            <!-- END POST DATE -->
                        </div>
                        <!-- END USER'S NAME AND DATE POSTED -->

                    </div>
                    <!-- END USER'S INFO -->

                    <!-- PROFILE'S CAPTION -->
                    <div v-if="profiles.length" v-for="(info,index) in profiles" :key="index" v-show="profileView === index" class="body-caption">
                        <p>
                            {{info.caption}}
                        </p>
                    </div>
                    <!-- PROFILE'S CAPTION -->

                    <!-- COVER'S CAPTION -->
                    <div v-if="covers.length" v-for="(info,index) in covers" :key="index" v-show="coverView === index" class="body-caption">
                        <p>
                            {{info.caption}}
                        </p>
                    </div>
                    <!-- END COVER'S CAPTION -->

                    <!-- POST'S CAPTION -->
                    <div v-if="postId !== null" v-for="(info,index) in postsImages.images" :key="index" v-show="postView === index" class="body-caption">
                        <p>
                            {{postsImages.body}}
                        </p>
                    </div>
                    <!-- END POST'S CAPTION -->
                </div>
                <!-- USER'S INFO AND CAPTION -->

                <ReactComment v-for="(profile,index) in profiles"
                              v-show="profileView === index" :key="index"
                              :post="profile"
                              :show-react-icons="showReactIcons"
                              :modal-post-id="modalPostId"
                              :react-name="reactName"
                              :all-reactors="allReactors"
                              :is-not-auth="isNotAuth"
                              @showReactorsModal="showReactorsModal"
                              @closeModal="closeModal"
                              @showAllReactors="showAllReactors"
                              @showReactors="showReactors"
                              @showIcons="showIcons"
                              @hideIcons="hideIcons"
                              @reactPost="reactPost"
                              @unreact="unreact"
                ></ReactComment>
                <ReactComment v-for="(cover,index) in covers"
                              v-show="profileView === index" :key="index"
                              :post="cover"
                              :show-react-icons="showReactIcons"
                              :modal-post-id="modalPostId"
                              :react-name="reactName"
                              :all-reactors="allReactors"
                              :is-not-auth="isNotAuth"
                              @showReactorsModal="showReactorsModal"
                              @closeModal="closeModal"
                              @showAllReactors="showAllReactors"
                              @showReactors="showReactors"
                              @showIcons="showIcons"
                              @hideIcons="hideIcons"
                              @reactPost="reactPost"
                              @unreact="unreact"
                ></ReactComment>
                <ReactComment v-show="postId !== null"
                              :post="postsImages"
                              :show-react-icons="showReactIcons"
                              :modal-post-id="modalPostId"
                              :react-name="reactName"
                              :all-reactors="allReactors"
                              :is-not-auth="isNotAuth"
                              @showReactorsModal="showReactorsModal"
                              @closeModal="closeModal"
                              @showAllReactors="showAllReactors"
                              @showReactors="showReactors"
                              @showIcons="showIcons"
                              @hideIcons="hideIcons"
                              @reactPost="reactPost"
                              @unreact="unreact"
                ></ReactComment>
            </div>
            <!-- END USER'S INFO AND CAPTION CONTAINER -->


        </div>
    </div>
</template>

<script>
 import ReactComment from './ReactComment.vue'
    export default {
        components:{ReactComment},
        async mounted() {
            if(this.postId){
              const getPost = await axios.get('/users/'+this.id+'/post/'+this.postId)
              const postData = await getPost.data
              this.postsImages = postData
            }else{
              if(this.path === 'user/'+this.id+'/profile-picture'){
                const getProfile = await axios.get('/user/'+this.id+'/profile')
                const profileData = await getProfile.data
                this.profiles = profileData
              }
              else{
                const getCoverPhoto = await axios.get('/user/'+this.id+'/cover')
                const coverData = await getCoverPhoto.data
                this.covers = coverData
              }
            }

            axios.get('/user/'+this.id+'/avatar')
                .then(res => {
                    this.profileAvatar = res.data
                })
            console.log(this.postsImages)
        },
        props: {
            userId: {
                type: String,
                required: true
            },
            owner: {
                type: String,
                required: true
            },
            authId: {
              type: String,
              required: true
            },
            requestPath: {
              type: String,
              required: true
            },
            userPostId: {
              type: String,
              require: true
            },
            notAuth: {
              type: Number,
              require: true
            }
        },
        data() {
            return {
                showModal: true,
                profiles: [],
                covers: [],
                postsImages: {},
                id: this.userId,
                profileView: 0,
                coverView: 0,
                postView: 0,
                profileOwner: this.owner,
                profileAvatar: '',
                auth: this.authId,
                path: this.requestPath,
                postId: this.userPostId,
                showReactIcons: null,
                modalPostId: null,
                reactName: null,
                allReactors: 'all',
                isNotAuth: this.notAuth
            }
        },
        methods: {
            exitModal(){
                return this.showModal = false;
            },
            nextPage(){
                if(this.postId) if(this.postView === this.postsImages.images.length - 1) return
                if(this.coverView === this.covers.length - 1) return
                if(this.profileView === this.profiles.length - 1) return
                this.profileView++
                this.coverView++
                this.postView++
            },
            prevPage(){
                if(this.postView === 0) return
                if(this.coverView === 0) return
                if(this.profileView === 0) return
                this.profileView--
                this.coverView--
                this.postView--
            },
            formatDate(date){
                return moment(date).format('ll')
            },
            setProfile(profileId){
                const config = {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }

                    if(this.path === 'user/'+this.id+'/profile-picture'){
                      axios.patch('/user/'+this.id+'/profile-picture/'+profileId,config)
                          .then(res => {
                              this.profiles = res.data
                              this.$toastr.s('Profile Picture setted')
                          })
                    }
                    else{
                      axios.patch('/user/'+this.id+'/cover-photo/'+profileId,config)
                          .then(res => {
                              this.covers = res.data
                              this.$toastr.s('Cover Photo setted')
                          })
                    }

                axios.get('/user/'+this.id+'/avatar')
                    .then(res => {
                        this.profileAvatar = res.data
                        this.profileView = 0
                        this.coverView = 0
                    })
            },
            showIcons(postId){
              setTimeout(() => {
                this.showReactIcons = postId
                console.log(this.showReactIcons)
              },100)
            },
            hideIcons(e){
              setTimeout(() => {
                this.showReactIcons = null
              },50)

            },
            async reactPost(choseReact,profilePictureId){
              const config = {
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              }

              if(this.postId){
                const getPost = await axios.post('/users/'+this.id+'/post/react/'+this.postId,
                                                      {react: choseReact},config)
                const postData = await getPost.data
                this.postsImages = postData
                return
              }
              else{
                if(this.path === 'user/'+this.id+'/profile-picture'){
                  axios.post(`/profile/react/${profilePictureId}`,{
                    react: choseReact
                  },config)
                      .then(res => {
                        this.profiles = res.data
                      })
                }
                else{
                  axios.post(`/cover/react/${profilePictureId}`,{
                    react: choseReact
                  },config)
                      .then(res => {
                        this.covers = res.data
                      })
                }
              }



              this.showReactIcons = null
            },
            async unreact(profilePictureId){
              const config = {
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              }

              if(this.postId){
                const getPost = await axios.delete('/users/'+this.id+'/post/unreact/'+this.postId,config)
                const postData = await getPost.data
                this.postsImages = postData
                return
              }
              else{
                if(this.path === 'user/'+this.id+'/profile-picture'){
                  axios.delete(`/profile/unreact/${profilePictureId}`,config)
                      .then(res => {
                        this.profiles = res.data
                      })
                }
                else{
                  axios.delete(`/cover/unreact/${profilePictureId}`,config)
                      .then(res => {
                        this.covers = res.data
                      })
                }
              }

            },
            showReactorsModal(postId){
              this.modalPostId = postId
            },
            closeModal(e){
                  if(e.target.classList.contains('modal-reactors')){
                    this.modalPostId = null
                    this.reactName = null
                    this.allReactors = 'all'

                }
            },
            showReactors(react){
              this.reactName = react
              this.allReactors = null
            },
            showAllReactors(all){
              this.allReactors = all
              this.reactName = null
            }
        }
    }
</script>

<style lang="scss" scoped>
    .modal-bg{
        position: fixed;
        height: 100vh;
        width: 100%;
        top:0;
        background-color: #000000;

        .exit{
            position: absolute;
            top: 0;
            left: 0;
            margin-left: 10px;
            color: #ffffff;
        }

        .profile-picture-container{
            width: 85%;
            height: 100vh;
            background-color: #000000;
            margin: auto;


            .profile-image{

                    .image-container {
                        width: 100%;
                        height: 100%;
                        background-color: red;
                        position: relative;


                        .prev-next{
                            position: absolute;
                            width: 100%;
                            top: 50%;
                            transform: translateY(-50%);

                            display: flex;
                            justify-content: space-between;
                            z-index: 3;
                        }

                        .backdrop{
                            position: absolute;
                            width: 100%;
                            top: 0;
                            bottom: 0;

                            background-position: center;
                            background-size: cover;
                            background-repeat: no-repeat;

                            display: flex;
                            justify-content: center;
                            align-items: center;

                            &::before{
                                position: absolute;
                                content: '';
                                width: 100%;
                                height: 100%;
                                background-color: rgba(0,0,0,0.5);
                                backdrop-filter: blur(8px);
                                z-index: 0;
                            }

                            img{
                                position: absolute;
                                z-index: 2;
                                max-height: 100%;
                                max-width: 100%;
                            }
                        }

                        // .swiper-slide{
                        //     position: relative;
                        //     height: 100vh;
                        //     width: 100%;

                        //     background-position: center;
                        //     background-size: cover;
                        //     background-repeat: no-repeat;

                        //     display: flex;
                        //     justify-content: center;
                        //     align-items: center;

                        //     &::before{
                        //         position: absolute;
                        //         content: '';
                        //         width: 100%;
                        //         height: 100%;
                        //         background-color: rgba(0,0,0,0.5);
                        //         backdrop-filter: blur(8px);
                        //         z-index: 0;
                        //     }

                        //     img{
                        //         position: absolute;
                        //         z-index: 2;
                        //         max-height: 100%;
                        //         max-width: 100%;
                        //     }
                        // }
                    }
            }

            .caption{
                padding: 0;
                padding-top: 50px;
                background-color: #fff;

                .info-container{
                    background-color:  #F0F0F0;
                    padding: 15px;

                    .user-info{
                        width: 100%;
                        border-radius: 6px;

                        display: flex;

                        .profile-image{
                            height: 50px;
                            width: 50px;
                            background-color: green;
                            border-radius: 50%;
                            margin-right: 10px;

                            img{
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                            }
                        }

                        .name-date{
                            margin-top: 10px;

                            h2{
                                font-size: 1.4rem;
                            }

                            p{
                                font-size: 0.7rem;
                            }
                        }
                    }

                    .body-caption{
                        margin-top: 10px;
                    }

                }


            }
        }




    }
</style>
