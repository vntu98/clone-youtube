<template>
    <div>
        <p>{{ comments.length }} {{ maybePluralize(comments.length, 'comment') }}</p>

        <div class="video-comment clearfix" v-if="$root.user.authenticated">
            <textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>

            <div class="pull-right">
                <button type="submit" class="btn btn-default" @click="createComment">Post</button>
            </div>
        </div>

        <ul style="padding-left: 0" class="media-list">
            <li class="media" v-for="comment in comments" :key="comment.id">
                <div class="media-left">
                    <a :href="'/channel/' + comment.channel.data.slug">
                        <img width="40" height="40" style="margin-right: 5px" :src="comment.channel.data.image" :alt="`${comment.channel.data.name} image`" class="media-object">
                    </a>
                </div>
                <div class="media-body">
                    <a :href="'/channel/' + comment.channel.data.slug">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
                    <p>{{ comment.body }}</p>

                    <ul class="list-inline">
                        <li v-if="$root.user.authenticated">
                            <a href="" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                        </li>
                    </ul>
                    
                    <div class="video-comment clear" v-if="replyFormVisible === comment.id">
                        <textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-default" @click="createReply(comment.id)">Reply</button>
                        </div>
                    </div>

                    <div class="media" v-for="reply in comment.replies.data" :key="reply.id">
                        <div class="media-left">
                            <a :href="'/channel/' + reply.channel.data.slug">
                                <img width="40" height="40" style="margin-right: 5px" :src="reply.channel.data.image" :alt="`${reply.channel.data.name} image`" class="media-object">
                            </a>
                        </div>
                        <div class="media-body">
                            <a :href="'/channel/' + reply.channel.data.slug">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
                            <p>{{ reply.body }}</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    data() {
        return {
            comments: [],
            body: null,
            replyBody: null,
            replyFormVisible: null
        }
    },
    props: {
        videoUid: null
    },
    created() {
        this.getComments()
    },
    methods: {
        createReply(commenId) {
            this.$http.post('/videos/' + this.videoUid + '/comments', {
                    body: this.replyBody,
                    reply_id: commenId
                }).then(response => {
                this.comments.map((comment, index) => {
                    if (comment.id === commenId) {
                        this.comments[index].replies.data.push(response.body.data)
                    }
                })
                this.replyBody = null
            })
        },
        toggleReplyForm(commentId) {
            this.replyBody = null
            this.replyFormVisible = this.replyFormVisible !== commentId ? commentId : null
        },
        getComments() {
            this.$http.get('/videos/' + this.videoUid + '/comments').then(response => {
                this.comments = response.body.data
            })
        },
        maybePluralize(count, noun, suffix = 's') {
            return `${noun}${count !== 1 ? suffix : ''}`;
        },
        createComment() {
            this.$http.post('/videos/' + this.videoUid + '/comments', { body: this.body }).then(response => {
                const comment = response.body.data
                // this.comments.unshift(comment)
                this.getComments()
                this.body = null
            })
        }
    },
}
</script>
<style>
    
</style>