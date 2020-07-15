<template>
    <div class="select-container">
      <div class="image-preview" @mouseover="showSelectFile" @mouseleave="unShowSelectFile">
        <img :src="image" alt="">
        <input type="file" name="" id="file" class="file" @change="onInputChange">
        <label for="file" title="Upload File" v-show="showFile">SELECT FILE</label>
      </div>
      <div class="post-section">
        <textarea class="post-textarea" type="text" name="body" placeholder="Caption" v-model="profileCaption"></textarea>
        <a :href="'/user/' + id" @click="uploadProfile" class="btn btn-primary post-btn ml-4" :disabled="image === null">Upload Profile</a>
      </div>
    </div>
</template>

<script>
    export default {
        mounted() {
          console.log(this.createPath)
        },
        props: {
          userId: {
            type: String,
            require: true
          },
          path: {
            type: String,
            require: true
          }
        },
        data(){
          return {
            file: null,
            image: null,
            showFile: false,
            id: this.userId,
            profileCaption: '',
            createPath: this.path
          }
        },
        methods: {
          onInputChange(event){
              this.image = null
              this.file = null
              const imageFiles = event.target.files
              console.log(imageFiles)
              Array.from(imageFiles).forEach(file => this.addImage(file))
          },
          showSelectFile(){
            this.showFile = true
          },
          unShowSelectFile(){
              this.showFile = false
          },
          addImage(file){
              if(!file.type.match('image.*')){
                  return console.log(`${file.name} is not an image`)
              }



              this.file = file

              var reader = new FileReader()

              reader.onload = (event) => this.image = event.target.result

              reader.readAsDataURL(file)

              console.log(this.file)
          },
          uploadProfile(){
            const config = {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }

            const formData = new FormData();

            formData.append('image',this.file,this.file.name)
            formData.append('caption',this.profileCaption)


            if(this.createPath === 'user/'+this.id+'/cover-photo/create'){
                axios.post('/user/'+this.id+'/cover-photo',formData,config)
                .then(res => {
                    this.$toastr.s('Upload successfully')
                })
            }else{
                axios.post('/user/'+this.id+'/profile-picture',formData,config)
                .then(res => {
                    this.$toastr.s('Upload successfully')
                })
            }

          }
        }
    }
</script>

<style lang="scss" scoped>
*{
  margin: 0;
  padding:0;
  box-sizing: border-box;
}

.select-container{
  background-color: #E2E2E2;
  padding: 15px;

  .image-preview{
    display: flex;
    justify-content: center;
    align-items: center;

    height: 400px;
    width: 100%;
    background-color: pink;
    position: relative;

    .file{
      display: none;
    }

    label{
      position: absolute;
      font-size: 2rem;
      cursor: pointer;
      background-color: rgba(63, 93, 155,0.8);
      color: #ffffff;
      padding: 10px 18px;
      border-radius: 8px;
      transition: 0.3s ease-in;
    }

    label:hover{
        background-color: rgba(63, 93, 155,1);
    }

    img{
      position: absolute;
      max-height: 100%;
      max-width: 100%;
    }
  }

  .post-section{
    display: flex;
    flex-direction: column;

    textarea{
      height: 5.5rem;
      outline: none;
      border: none;
      resize: none;
      padding: 6px;
      margin-top: 15px;
    }

    a{
      margin-top: 10px;
      padding: 8px 16px;
      align-self: flex-end;
    }
  }

}

</style>
