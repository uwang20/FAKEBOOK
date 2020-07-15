<template>
    <div class="wrapper">
      <hr class="my-0">
      <div class="reacts-comments">
        <!-- reacts-icons and reacts count display -->
        <div class="reacts" @click="showReactorsModal(post.id)" style="cursor: pointer;">
          <div class="majorities">
            <div class="major-react first" v-if="post.majority_reacts[0]">
              <img :src="`/images/${post.majority_reacts[0]}.png`" style="width: 20px;">
              <div class="reacts-count" v-show="!post.majority_reacts[1] && !post.majority_reacts[2]"  style="width: 500%; transform: translateX(40%)">
                <span v-if="post.reacted && post.users_reacts.length === 1">{{'You'}}</span>
                <span v-else-if="post.reacted">{{'You and '}}</span>
                {{post.reacted? (post.users_reacts.length-1===0? '':post.users_reacts.length-1) : post.users_reacts.length}}
                <span v-if="post.reacted && post.users_reacts.length > 1">{{' others'}}</span>
                <span v-else-if="!post.reacted && post.users_reacts.length === 1"></span>
              </div>
            </div>
            <div class="major-react second" v-if="post.majority_reacts[1]">
              <img :src="`/images/${post.majority_reacts[1]}.png`" style="width: 20px;">
              <div class="reacts-count" v-show="post.majority_reacts[1] && !post.majority_reacts[2]" style="width: 500%; transform: translateX(40%)">
                <span v-if="post.reacted && post.users_reacts.length === 1">{{'You'}}</span>
                <span v-else-if="post.reacted">{{'You and '}}</span>
                {{post.reacted? post.users_reacts.length-1 : post.users_reacts.length}}
                <span v-if="post.reacted && post.users_reacts.length > 1">{{' others'}}</span>
                <span v-else-if="!post.reacted && post.users_reacts.length === 1"></span>
              </div>
            </div>
            <div class="major-react third" v-if="post.majority_reacts[2]">
              <img :src="`/images/${post.majority_reacts[2]}.png`" style="width: 20px;">
              <div class="reacts-count" v-show="post.majority_reacts[1] && post.majority_reacts[2]" style="width: 500%; transform: translateX(40%)">
                <span v-if="post.reacted && post.users_reacts.length === 1">{{'You'}}</span>
                <span v-else-if="post.reacted">{{'You and '}}</span>
                {{post.reacted? post.users_reacts.length-1 : post.users_reacts.length}}
                <span v-if="post.reacted && post.users_reacts.length > 1">{{' others'}}</span>
                <span v-else-if="!post.reacted && post.users_reacts.length === 1"></span>
              </div>
            </div>
          </div>
        </div>
        <!-- reacts-icons and reacts count display -->

        <!-- modal-reactor -->
        <div v-show="post.id === modalPostId" class="modal-reactors" @click="closeModal">

          <div class="reactors">
            <div class="exit-container">
              <div class="exit">exit</div>
              <div class="text">People who reacted</div>
            </div>
            <hr>
            <div class="react-icon">
              <div v-show="post.users_reacts.length" class="all" :class="{'show-border-b':'all' === allReactors}" style="font-weight: 600; font-size: 1.1rem; color: #9C9C9C" @click="showAllReactors('all')">
                {{'All ' + post.users_reacts.length}}
              </div>
              <div v-for="(react,index) in post.each_react_count" :key="index" v-show="react.count" class="img-container" :class="{ 'show-border-b'  :react.react === reactName}" @click="showReactors(react.react)">
                <img :src="`/images/${react.react}.png`" :alt="react.react" style="width: 25px; margin-right: 15px;">
                <span style="font-weight: 600; font-size: 1.1rem; color: #9C9C9C">{{react.count}}</span>
              </div>
            </div>
            <hr>
            <div  class="all-reactors" v-show="'all' === allReactors">
              <div v-for="(reactor,index) in post.all_reactors" :key="index" class="user">
                <div  class="pic" :style="{backgroundImage: `url(${'/storage/'+reactor.profile_pic})`}">
                  <img :src="`/images/${reactor.react}.png`" :alt="reactor.react" style="width: 20px;">
                </div>
                <a href="#">{{reactor.name}}</a>
              </div>
            </div>
            <div v-for="(react,index) in post.each_react_count" :key="index" v-show="react.react === reactName" class="people">
              <div v-for="(user,index) in react.user_id" :key="index" class="user">
                <div class="pic" :style="{backgroundImage: `url(${'/storage/'+user.profile_pic})`}">
                  <img :src="`/images/${react.react}.png`" :alt="react.react" style="width: 20px;">
                </div>
                <a href="#">{{user.name}}</a>
              </div>
            </div>
          </div>

        </div>
        <!-- modal-reactor -->

        <!-- comments view  no implementaion for now-->
        <div class="comments-count" v-show="post.comments" @click="showComments(post.id)">{{post.comments.length + ' comments'}}</div>
        <!-- comments view  -->
      </div>
      <div class="comments" v-show="post.show_comments">
        <div class="comment" v-for="(comment,index) in post.comments" :key="index">
          <div class="avatar" ></div>
          <div class="user-comment-container">
            <div class="user-comment">
              <p class="name reset">{{comment.name}}</p>
              <p class="comment reset">{{comment.comment}}</p>
            </div>
            <div class="others">
              <div class="time">{{formatDate(comment.created_at)}}</div>
              <div class="like">Like</div>
              <div class="reply">Reply</div>
            </div>
          </div>
        </div>
      </div>
      <hr class="mx-2 my-0">

      <div class="set-react-comment" v-show="!isNotAuth">
        <!-- react button - click to react -->
        <div @mouseenter="showIcons(post.id)" @mouseleave="hideIcons" class="like">
          <!-- reacts container - hover to show -->
          <div v-show="post.id == showReactIcons" class="reacts-icons">
            <div @click="reactPost('Like',post.id,post.post_type)" class="like-icon">
              <img src="/images/like.png" alt="like" style="width: 50px;" class="icon">
            </div>
            <div @click="reactPost('Love',post.id,post.post_type)" class="love-icon">
              <img src="/images/love.png" alt="love" style="width: 50px;" class="icon">
            </div>
            <div @click="reactPost('Care',post.id,post.post_type)" class="care-icon">
              <img src="/images/care.png" alt="care" style="width: 50px;" class="icon">
            </div>
            <div @click="reactPost('Haha',post.id,post.post_type)" class="haha-icon">
              <img src="/images/haha.png" alt="haha" style="width: 50px;" class="icon">
            </div>
            <div @click="reactPost('Wow',post.id,post.post_type)" class="wow-icon">
              <img src="/images/wow.png" alt="wow" style="width: 50px;" class="icon">
            </div>
            <div @click="reactPost('Sad',post.id,post.post_type)" class="sad-icon">
              <img src="/images/sad.png" alt="sad" style="width: 50px;" class="icon">
            </div>
            <div @click="reactPost('Angry',post.id,post.post_type)" class="angry-icon">
              <img src="/images/angry.png" alt="angry" style="width: 50px;" class="icon">
            </div>
          </div>
          <!-- reacts container - hover to show -->

          <!-- show when you reacted a post -->
          <span @click="unreact(post.id,post.post_type)" v-if="post.reacted" :class="'react react-'+post.chosen_react">
            <img  v-for="(reactIcon,index) in reactIcons" :key="index" v-show="post.chosen_react === reactIcon.react" :src="reactIcon.imageUrl" :alt="reactIcon.react" style="width: 30px; margin-right: 10px">
            {{ post.chosen_react}}
          </span>
          <!-- show when you reacted a post -->

          <!-- react icon - click to react -->
          <span @click="reactPost('Like',post.id,post.post_type)" v-else style="display: flex; align-items: center;">
            <img src="/images/like-line.png" alt="like-line" style="width: 30px; margin-right: 10px">
            <span>LIKE</span>
          </span>
          <!-- react icon - click to react -->
        </div>
        <!-- react button - click to react -->
        <div class="comment">COMMENT</div>
        <div class="share">SHARE</div>
      </div>

    </div>
</template>

<script>
    export default {
      name: 'ReactComment',
      props: {
        post: {
          type: Object,
          require: true
        },
        showReactIcons: {
          type: Number,
          require: true
        },
        modalPostId: {
          type: Number,
          require: true
        },
        reactName: {
          type: String,
          require: true
        },
        allReactors: {
          type: String,
          require: true
        },
        isNotAuth: {
          type: Number,
          require: true
        }
      },
      data(){
        return{
          reactIcons: [
            {react:'Like',imageUrl: '/images/like.png'},
            {react:'Love',imageUrl: '/images/love.png'},
            {react:'Care',imageUrl: '/images/care.png'},
            {react:'Haha',imageUrl: '/images/haha.png'},
            {react:'Wow',imageUrl: '/images/wow.png'},
            {react:'Sad',imageUrl: '/images/sad.png'},
            {react:'Angry',imageUrl: '/images/angry.png'}
          ]
        }
      },
      methods: {
        showReactorsModal(postId){
          this.$emit('showReactorsModal',postId)
        },
        closeModal(e){
          this.$emit('closeModal',e)
        },
        showAllReactors(all){
          this.$emit('showAllReactors',all)
        },
        showReactors(react){
          this.$emit('showReactors',react)
        },
        showIcons(postId){
          this.$emit('showIcons',postId)
        },
        hideIcons(){
          this.$emit('hideIcons')
        },
        reactPost(react,postId,postType){
          this.$emit('reactPost',react,postId,postType)
        },
        unreact(postId,postType){
          this.$emit('unreact',postId,postType)
        },
        formatDate(date){
            return moment(date).fromNow()
        },
        showComments(id){
          this.$emit('showComments',id)
        }
      },
      computed: {

      }
}
</script>

<style lang="scss" scoped>
.wrapper, *{
  box-sizing: border-box;

  >.comments{
    border-top: 2px solid #9C9C9C;
    padding: 20px;

    .comment{
      display: flex;
      margin-bottom: 20px;

      .avatar{
        background-color: green;
        border-radius: 50%;
        margin-right: 15px;
      }

      .user-comment-container{
        flex: 1;

        .user-comment{
          background-color: #E2E2E2;
          border-radius: 24px;
          padding: 14px 18px;
          display: inline-block;

          .reset{
            margin:0;
            padding:0;

          }

          .name{
            font-weight: 600;
            margin-bottom: 5px;
          }

          .comment{
            font-weight: 400;
            font-size: 0.9rem;
          }
        }

        .others{
          display: flex;
          margin-top: 5px;
          margin-left: 20px;

          .time{
            color: #656565;
            font-weight: bold;
            margin-right: 25px;
          }

          .like, .reply{
            color: #5A5A5A;
            font-weight: 600;
            margin-right: 25px;
          }
        }

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
            padding-left: 10px;
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
</style>
