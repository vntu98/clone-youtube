<template>
    <div>
        <div class="video__voting">
            <a href="" class="video__voting-button" :class="{ 'video__voting-button--voted': userVote === 'up' }" @click.prevent="vote('up')">
                <i class="far fa-thumbs-up"></i>
            </a> {{ up }} &nbsp;

            <a href="" class="video__voting-button" :class="{ 'video__voting-button--voted': userVote === 'down' }" @click.prevent="vote('down')">
                <i class="far fa-thumbs-down"></i>
            </a> {{ down }}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            videoUid: null
        },
        data() {
            return {
                up: null,
                down: null,
                userVote: null,
                canVote: false
            }
        },
        created() {
            this.getVotes()
        },
        methods: {
            getVotes() {
                this.$http.get('/videos/' + this.videoUid + '/votes').then(response => {
                    const { data } = response.data
                    this.up = data.up
                    this.down = data.down
                    this.canVote = data.can_vote
                    this.userVote = data.user_vote
                })
            },
            vote(type) {
                if (this.userVote === type) {
                    this[type]--
                    this.userVote = null
                    this.deleteVote(type)

                    return
                }

                if (this.userVote) {
                    this[type === 'up' ? 'down' : 'up']--
                }

                this[type]++
                this.userVote = type

                this.createVote(type)
            },
            deleteVote(type) {
                this.$http.delete('/videos/' + this.videoUid + '/votes')
            },
            createVote(type) {
                this.$http.post('/videos/' + this.videoUid + '/votes', {
                    'type': type
                })
            }
        },
    }
</script>

<style lang="">
    
</style>