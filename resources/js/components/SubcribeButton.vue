<template>
    <div v-if="subcribers !== null">
        {{ subcribers }} {{ maybePluralize(subcribers, 'subcriber') }} &nbsp;
        <button class="btn btn-xs btn-default" type="button" v-if="canSubcribe" @click.prevent="handle">{{ userSubcribed ? 'Unsubcribe' : 'Subcribe' }}</button>
    </div>
</template>
<script>
export default {
    props: {
        channelSlug: null
    },
    data() {
        return {
            subcribers: null,
            userSubcribed: false,
            canSubcribe: false
        }
    },
    methods: {
        getSubcriptionStatus() {
            this.$http.get('/subcription/' + this.channelSlug).then(response => {
                this.subcribers = response.data.count
                this.userSubcribed = response.data.user_subcribed
                this.canSubcribe = response.data.can_subcribe
            })
        },
        maybePluralize(count, noun, suffix = 's') {
            return `${noun}${count !== 1 ? suffix : ''}`;
        },
        handle() {
            if (this.userSubcribed) {
                this.unsubcribe()
            } else {
                this.subcribe()
            }
        },
        unsubcribe() {
            this.userSubcribed = false
            this.subcribers--

            this.$http.delete('/subcriptions/' + this.channelSlug)
        },
        subcribe() {
            this.userSubcribed = true
            this.subcribers++

            this.$http.post('/subcriptions/' + this.channelSlug)
        }
    },
    created() {
        this.getSubcriptionStatus()
    }
}
</script>
<style>
    
</style>