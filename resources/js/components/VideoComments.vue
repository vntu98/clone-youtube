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
            <li style="margin-bottom: 15px;" class="media" v-for="comment in comments" :key="comment.id">
                <div class="media-left">
                    <a :href="'/channel/' + comment.channel.data.slug">
                        <img width="40" height="40" style="margin-right: 5px" :src="comment.channel.data.image" :alt="`${comment.channel.data.name} image`" class="media-object">
                    </a>
                </div>
                <div class="media-body">
                    <a :href="'/channel/' + comment.channel.data.slug">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
                    <p style="margin-bottom: 0;">{{ comment.body }}</p>

                    <ul class="list-inline" v-if="$root.user.authenticated">
                        <li style="display: inline-block; margin-right: 5px;">
                            <a href="" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                        </li>
                        <li style="display: inline-block;">
                            <a href="" v-if="$root.user.id === comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>
                        </li>
                    </ul>
                    
                    <div class="video-comment clear" v-if="replyFormVisible === comment.id">
                        <textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-default" @click="createReply(comment.id)">Reply</button>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;" class="media" v-for="reply in comment.replies.data" :key="reply.id">
                        <div class="media-left">
                            <a :href="'/channel/' + reply.channel.data.slug">
                                <img width="40" height="40" style="margin-right: 5px" :src="reply.channel.data.image" :alt="`${reply.channel.data.name} image`" class="media-object">
                            </a>
                        </div>
                        <div class="media-body">
                            <a :href="'/channel/' + reply.channel.data.slug">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
                            <p style="margin-bottom: 0;">{{ reply.body }}</p>

                            <ul class="list-inline" v-if="$root.user.authenticated">
                                <li>
                                    <a href="" v-if="$root.user.id === reply.user_id" @click.prevent="deleteComment(reply.id)">Delete</a>
                                </li>
                            </ul>
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
        },
        deleteComment(commentId) {
            if (!confirm('Are you sure you want to delete this comment?')) {
                return
            }

            this.deleteById(commentId)
            this.$http.delete('/videos/' + this.videoUid + '/comments/' + commentId)
        },
        deleteById(commentId) {
            this.comments.map((comment, index) => {
                if (comment.id === commentId) {
                    this.comments.splice(index, 1);
                }

                comment.replies.data.map((reply, replyIndex) => {
                    if (reply.id === commentId) {
                        this.comments[index].replies.data.splice(replyIndex, 1)
                        return
                    }
                })
            })
        }
    },
}
</script>
<style>
    
</style>