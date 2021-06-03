<template>
    <Media
        :kind="'video'"
        :isMuted="(false)"
        :src="[videoUrl]"
        :poster="thumbnailUrl"
        :autoplay="true"
        :controls="true"
        :loop="true"
        :ref="'player'"
        width="100%"
        @loadedmetadata="loaded"
    ></Media>
</template>
<script>
import Media from '@dongido/vue-viaudio'
export default {
    components: {
        Media
    },
    props: {
        videoUid: null,
        videoUrl: null,
        thumbnailUrl: null
    },
    data() {
        return {
            duration: 0
        }
    },
    methods: {
        hasHitQuotaView() {
            if (!this.duration) {
                return false
            }

            // Wathing 10% => increare view
            return Math.round(this.$refs.player.currentTime) === Math.round((10 * this.duration) / 100)
        },
        createView() {
            this.$http.post('/videos/' + this.videoUid + '/views')
        },
        loaded() {
            console.log(this.$refs.player)
            this.duration = Math.floor(this.$refs.player.duration)

            setInterval(() => {
                if (this.hasHitQuotaView()) {
                    this.createView()
                } 
            }, 1000)
        }
    },
}
</script>
<style>
    
</style>