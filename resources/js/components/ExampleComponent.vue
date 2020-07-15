<template>
    <div class="container">
      <!-- POST-ONLY-CONTAINER -->
        <div v-show="!isNotAuth" class="post-container" v-if="show">
            <textarea class="post-textarea" type="text" name="body" placeholder="What's on your mind?" v-model="post"></textarea>
            <div class="container">
                <div class="row justify-content-between">
                    <button class="btn btn-success" @click="show = !show">Add Photo</button>
                    <button @click="postSomething" class="btn btn-primary post-btn ml-4" :disabled="isDisable">Post</button>
                </div>
            </div>
        </div>
        <!-- POST-IMAGE-CONTAINER -->
        <div class="post-image-container" v-else>
            <div class="image-drop" @dragenter="onDragEnter" @dragleave="onDragLeave" @dragover.prevent @drop="onDrop" :class="{dragging: isDragging}">
                <h1 v-text="dropText"></h1>
                <div class="images-preview" v-show="images.length">
                    <div class="image-wrapper" v-for="(image,index) in images" :key="index">
                        <img :src="image" :alt="`Image Uploader ${index}`">
                    </div>
                </div>
            </div>
            <form action="#">
                <textarea class="post-textarea" type="text" name="body" placeholder="What's on your mind?" v-model="imageCaption"></textarea>
                <div class="container">
                        <button class="btn btn-success" @click="show = !show">Back</button>
                        <div>
                            <input type="file" id="file" @change="onInputChange" multiple>
                            <label for="file" class="upload-btn">Upload Image</label>
                            <button @click="postPhoto" class="btn btn-primary post-btn ml-4" :disabled="false">Post</button>
                        </div>
                </div>
            </form>
        </div>
        <!-- POSTS -->
        <div class="posts">
            <ul class="list-group list-group-flush">
                <li v-for="(post, index) in posts"  :key="index" class="list-group-item">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                              <div v-if="post.user_id === post.posted_by_id" class="avatar" :style="{ backgroundImage: `url(${'/storage/'+avatar})`}">
                              </div>
                              <div class="col-md-10">
                                <h5 v-if="post.user_id === post.posted_by_id" class="card-title">
                                  {{user}}
                                  <span v-show="post.post_type === 'profile'" class="text-muted">{{`change ${post.pronoun} profile picture`}}</span>
                                  <span v-show="post.post_type === 'cover'" class="text-muted">{{`change ${post.pronoun} cover photo`}}</span>
                                </h5>
                                <div v-else class="">
                                  <h5 class="card-title"><a class="font-weight-bold text-dark" :href="'/user/'+post.posted_by_id" style="text-decoration: none;">{{post.posted_by}}</a><span class="mx-4">></span><span>{{user}}</span></h5>
                                </div>
                                <h6 class="card-subtitle text-muted">{{formatDate(post.created_at)}}</h6>
                              </div>
                            </div>
                        </div>
                        <div class="card-body" v-show="post.body">
                            <p class="card-text" >{{post.body}}</p>
                        </div>
                        <div class="image" v-show="post.images">
                            <div v-show="post.images" class="image-post" v-for="(image,index) in post.images" :key="index">
                              <a :href="'/users/'+id+'/posts/'+post.id" ><img v-show="index===0" :src="'/storage/' + image.image" alt=""></a>
                            </div>
                        </div>
                        <!-- REACT/COMMENT SECTION -->
                        <ReactComment :post="post"
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
                                      @showComments="showComments"
                        ></ReactComment >
                      <!-- END   -->
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
 import ReactComment from './ReactComment.vue'

    export default {
        components:{ReactComment},
        async mounted() {
            var id = parseInt(this.userId.id)
            const getPosts = await axios.get(`/users/${id}/posts`)
            const postsData = await getPosts.data
            this.posts = postsData

            axios.get(`/user/${id}/avatar`)
              .then(res => this.avatar = res.data)

              console.log(this.posts)


        },
        props: {
            userId: {
                type: Object,
                required: true
            },
            notAuth: {
              type: Number,
              require: true
            },
            authId: {
              type: Number,
              required: true
            },
            userPosts: {
              type: Array,
              required: true
            }
        },
        data() {
            return {
                id: parseInt(this.userId.id),
                post: '',
                posts: [],
                postImages: {},
                photos: [],
                user: `${this.userId.first_name} ${this.userId.last_name}`,
                show: true,
                isDragging: false,
                files: [],
                images: [],
                dropText: 'DROP IMAGE HERE',
                imageCaption: '',
                avatar: '',
                isNotAuth: this.notAuth,
                authUser: this.authId,
                postedBy: '',
                showReactIcons: null,
                modalPostId: null,
                reactName: null,
                allReactors: 'all',
            }
        },
        computed: {
            isDisable(){
                if(this.post !== ''){
                    return false
                }

                return true
            }
        },
        methods: {
            async postSomething() {
                const config = {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }

                const post = await axios.post(`/post/${this.id}`,{
                    body: this.post,
                    posted_by_id: this.authUser
                },config)

                var id = parseInt(this.userId.id)
                const getPosts = await axios.get(`/users/${id}/posts`)
                const postsData = await getPosts.data
                this.posts = postsData

                this.post = '';
            },
            formatDate(date){
                return moment(date).fromNow()
            },
            onInputChange(event){
                const imageFiles = event.target.files

                Array.from(imageFiles).forEach(file => this.addImage(file))
            },
            onDragEnter(event){
                event.preventDefault()

                this.isDragging = true
            },
            onDragLeave(event){
                event.preventDefault()

                this.isDragging = false
            },
            onDrop(event){
                event.preventDefault()
                event.stopPropagation()

                this.isDragging = false
                this.dropText = ''

                const imageFiles = event.dataTransfer.files

                Array.from(imageFiles).forEach(file => this.addImage(file))
            },
            addImage(file){
                if(!file.type.match('image.*')){
                    return console.log(`${file.name} is not an image`)
                }

                this.files.push(file)

                var reader = new FileReader()

                reader.onload = (event) => this.images.push(event.target.result)

                reader.readAsDataURL(file)
            },
            async postPhoto(){
                var id = parseInt(this.userId.id)
                const config = {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }

                const formData = new FormData();

                for(var i = 0; i < this.files.length; i++){
                    formData.append('images[]', this.files[i], this.files[i].name)
                }


                // posted_by_id: this.authUser
                formData.append('caption',this.imageCaption)
                formData.append('posted_by_id',this.authUser)

                const postImage = await axios.post(`/post-image/${this.id}`,formData,config)
                const postImageData = await postImage.data

                const getPosts = await axios.get(`/users/${id}/posts`)
                const postsData = await getPosts.data
                this.posts = postsData
                this.$toastr.s('Upload successfully')




                this.imageCaption = '';
                this.dropText = 'DROP IMAGE HERE'
                this.files = []
                this.images = []


                // .then(res => {
                //     this.$toastr.s('Upload successfully')
                // })
                //
                // setTimeout(() => {
                //     var id = parseInt(JSON.parse(this.userId).id)
                //
                //     axios.get(`/users/${id}/posts`)
                //     .then(res => this.posts = res.data)
                // },500)

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
            reactPost(choseReact,postId,postType){
              const config = {
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              }

              switch(postType){
                case 'post' :
                  axios.post(`/post/react/${postId}`,{
                    react: choseReact
                  },config)
                      .then(res => {
                        this.posts = res.data
                      })
                  break
                case 'profile':
                  axios.post(`/user/profile/react/${postId}`,{
                    react: choseReact
                  },config)
                      .then(res => {
                        this.posts = res.data
                      })
                  break
                case 'cover':
                  axios.post(`/user/cover/react/${postId}`,{
                    react: choseReact
                  },config)
                      .then(res => {
                        this.posts = res.data
                      })
                  break
              }


              this.showReactIcons = null
            },
            unreact(postId,postType){
              const config = {
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              }

              switch(postType){
                case 'post' :
                  axios.delete(`/post/unreact/${postId}`,config)
                      .then(res => {
                        this.posts = res.data
                      })
                  break
                case 'profile':
                axios.delete(`/user/profile/unreact/${postId}`,config)
                    .then(res => {
                      this.posts = res.data
                    })
                  break
                case 'cover':
                axios.delete(`/user/cover/unreact/${postId}`,config)
                    .then(res => {
                      this.posts = res.data
                    })
                  break
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
            },
            showComments(id){
              this.posts.forEach(post => {
                if(post.id === id){
                  return post.show_comments = true
                }
              })
            }
        }
    }
</script>

<style lang="scss">
@import '~vue-toastr/src/vue-toastr.scss';

.container{


    .posts{
        .avatar{
          height: 50px;
          width: 50px;
          background-position: center;
          background-size: cover;
          background-repeat: no-repeat;
          border-radius: 50%;
          margin-left: 10px;
        }

        .image{
            background-color: red;
            width: 100%;

            .image-post{
                background-color: black;

                img{
                    width: 100%;
                    height: 100%;
                    margin: auto;
                }
            }

        }

        .reacts-comments{
          display: flex;
          justify-content: space-between;


          padding: 15px 20px;

          .reacts{
            display: flex;
            align-items: center;

            .majorities{
              display: flex;
              align-items: center;
              position: relative;

              .major-react{
                width: 25px;
                height: 25px;
                border-radius: 50px;
                padding: 4px;
                background-color: white;

                display:flex;
                justify-content: center;
                align-items: center;

                position: absolute;

                .reacts-count{
                  position: absolute;
                }
              }

              .first{
                z-index: 4;
              }
              .second{
                z-index: 3;
                transform: translateX(18px);
              }
              .third{
                z-index: 2;
                transform: translateX(35px);
              }
            }

            .reacts-count{
              margin-left: 20px;
            }
          }

          .modal-reactors{
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100%;
            background-color: rgba(0,0,0,0.4);
            z-index: 10;

            .reactors{
              position: absolute;
              left: 50%;
              top: 50%;
              transform: translate(-50%,-50%);
              width: 60%;
              height: 85%;
              background-color: white;

              hr{
                margin: 0;
              }


              .exit-container{
                display: flex;
                justify-content: flex-start;
                align-items: center;
                padding: 18px 25px;

                .text{
                  margin-left: 10px;
                  font-size: 1.3rem;
                  font-weight: 700;
                }
              }

              .react-icon{
                padding: 0 25px;
                display: flex;
                justify-content: flex-start;
                align-items: center;

                .all{
                  margin-right: 35px;
                  padding: 18px 10px;
                  text-align: center;
                  height: 100%;
                  cursor: pointer;
                }

                .img-container{
                  display: flex;
                  align-items: center;
                  margin-right: 40px;
                  padding: 18px 10px;
                  text-align: center;
                  height: 100%;
                  cursor: pointer;
                }

                .show-border-b{
                  border-bottom: 2px solid #1B65F2;
                }
                // .like{
                //   border-bottom: 2px solid #1B65F2;
                // }
                // .love{
                //   border-bottom: 2px solid #E11933;
                // }
                // .care{
                //   border-bottom: 2px solid #FB627E;
                // }
                // .haha, .wow{
                //   border-bottom: 2px solid #F8BA4F;
                // }
                // .sad, .angry{
                //   border-bottom: 2px solid #D27209;
                // }

              }

              .all-reactors{
                padding: 0 25px;
                padding-top: 35px;

              .user{
                margin-bottom: 25px;
                display: flex;
                align-items: center;

                .pic{
                  border-radius: 50%;
                  background-size: cover;
                  background-position: center;
                  width: 40px;
                  height: 40px;

                  position: relative;

                  img{
                    display: absolute;
                    right:0;
                    bottom: 0;
                    transform: translate(125%,125%);
                  }
                }

                a{
                  text-decoration: none;
                  color: black;
                  font-size: 1.1rem;
                  margin-left: 30px;
                }
              }

              }

              .people{
                padding: 0 25px;
                padding-top: 35px;

                .user{
                  margin-bottom: 25px;
                  display: flex;
                  align-items: center;

                  .pic{
                    border-radius: 50%;
                    background-size: cover;
                    background-position: center;
                    width: 40px;
                    height: 40px;

                    position: relative;

                    img{
                      display: absolute;
                      right:0;
                      bottom: 0;
                      transform: translate(125%,125%);
                    }
                  }

                  a{
                    text-decoration: none;
                    color: black;
                    font-size: 1.1rem;
                    margin-left: 30px;
                  }
                }
              }

            }
          }

        }

        .set-react-comment{
          display: flex;
          justify-content: space-between;
          font-weight: bold;


          padding:0 20px;

          >div{
            padding: 15px 5px;
            cursor: pointer;

            &:hover{
              background-color: rgba(0,0,0,0.1);
            }
          }

          .like{
            position: relative;
            cursor: pointer;

            .reacts-icons{
              position: absolute;
              top:5px;
              left:-15px;
              transform: translateY(-100%);
              transition: 0.3s ease-in;
              z-index: 6;

              background-color: white;
              box-shadow: 0 0 5px rgba(0,0,0,0.7);
              padding: 10px 15px;
              border-radius: 50px;

              display: flex;


              div{
                margin:0 10px;
                font-size: 1.2rem;
                font-weight: 700;
                transition: 0.3s ease-in;

              &:hover{
                transform: scale(1.2);
              }
              }

              .like-icon{
                &:hover{
                  color: blue;
                }
              }
            }

            .react{
              font-weight: bold;
              letter-spacing: 2px;
              font-size: 1.2rem;
            }

            .react-Like{
              color: #119CF6;
            }
            .react-Love{
              color: #F9627B;
            }
            .react-Haha,.react-Haha,.react-Wow,.react-Sad,.react-Angry{
              color: #FCDB64;
            }

          }
        }


    }

    .post-container{
        display: flex;
        flex-direction: column;

        textarea{
            height: 5.5rem;
            outline: none;
            border: none;
            resize: none;
            padding: 6px;
        }

        button{
            margin-top: 10px;
        }

    }

    .post-image-container{
        padding: 10px;
        background-color: #E2E2E2;

        .image-drop{
            background-color: #E2E2E2;
            border: 5px dotted #8B8B8B;
            border-radius: 6px;
            min-height: 200px;
            width: 100%;
            margin-bottom: 10px;
            position: relative;

            h1{
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                transform: translateY(-50%);
                text-align: center;
                font-weight: 700;
                color: rgba(0,0,0,0.2);
            }

            &.dragging {
                background-color: white;
            }

            .images-preview{
                display: flex;
                flex-wrap: wrap;


                .image-wrapper{
                    width: 150px;
                    height: 140px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    background: white;
                    margin: 11px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.5);
                    border-radius: 5px;


                    img{
                        max-height: 100%;
                        border-radius: 5px;
                    }

                }

            }
        }

        form{
            display: flex;
            flex-direction: column;

            textarea{
                height: 5.5rem;
                outline: none;
                border: none;
                resize: none;
                padding: 6px;
            }

            .container{
                margin-top: 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0;

                div{
                    position: relative;

                    input{
                        position: absolute;
                        z-index: -2;
                        opacity: 0;
                    }

                    label{
                        background-color: #00AAAA;
                        color: #fff;
                        padding: 7px 8px;
                        border-radius: 6px;
                    }
                }
            }
        }
    }


}
</style>
