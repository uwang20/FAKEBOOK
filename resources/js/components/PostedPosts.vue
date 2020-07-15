<template>
    <div class="container">
        <ul class="list-group list-group-flush">
            <li v-for="(post, index) in posts"  :key="index" class="list-group-item">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">user</h5>
                        <h6 class="card-subtitle text-muted">date</h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{post.body}}</p>
                    </div>
                </div>
            </li>
        </ul>             
    </div>
</template>

<script>
    export default {
        name: 'post-text',
        props: {
            userId: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                posts: []
            }
        },
        mounted() {
            var id = parseInt(this.userId)
            axios.get(`/users/${id}/posts`)
            .then(res => this.posts = res.data)
        }
    }
</script>

<style lang="stylus">

</style>

