<template>
    <a title="Favorite question (click again to remove)" 
        :class="classes" @click="toggleFavorite">
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>
</template>

<script>
export default {
    props: [
        'question',
    ],

    data() {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorites_count,
            id: this.question.id,
        }
    },

    computed: {
        classes() {
            return [
                'favorite',
                ! this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : ''),
            ]
        },
    },

    methods: {
        toggleFavorite() {
            if (! this.signedIn) {
               this.$toast.warning('Please Sign In to favorite this question', 'Warning', {
                   timeout: 4000,
                   position: 'bottomLeft',
               }) 
            }

            this.isFavorited ? this.destroy() : this.create();

        },

        destroy() {
            axios.delete(`/questions/${this.id}/delete-favorites`)
            .then(res => {
                this.count--;
                this.isFavorited = false;
            })
            .catch(err => {
                console.log(err);
            })
        },

        create() {
            axios.post(`/questions/${this.id}/add-favorites`)
            .then(res => {
                this.count++;
                this.isFavorited = true;
            })
            .catch(err => {
                console.log(err);
            })
        },
    }

}
</script>

<style>

</style>