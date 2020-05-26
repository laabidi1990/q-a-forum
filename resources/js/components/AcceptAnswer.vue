<template>
    <a v-if="canAccept" title="Best Answer" :class="classes" @click="acceptAnswer">
        <i class="fas fa-check fa-2x"></i>
    </a>
    <a v-else-if="AnswerStatus" title="Best Answer" :class="classes" @click="acceptAnswer" >
        <i class="fas fa-check fa-2x"></i>
    </a>
</template>

<script>
import eventBus from '../eventBus';
export default {
    props: [
        'answer'
    ],

    data() {
        return {
            AnswerStatus: this.answer.answer_status,
            id: this.answer.id,
            questionId: this.answer.question_id,
        }
    },

    computed: {
        classes() {
            return (! this.signedIn && this.AnswerStatus ) ? 'vote-accepted' : (this.AnswerStatus ? 'vote-accepted' : '');
        },

        canAccept() {
           return this.authorize('accept', this.answer);
        }
    },

    methods: {
        acceptAnswer() {
            axios.post(`/questions/${this.questionId}/answers/${this.id}/best-answer`)
            .then(res => {
                this.$toast.success('Best answer Accepted', 'Success', { timeout: 4000 });
                //this.AnswerStatus = true

                eventBus.$emit('accepted', this.id);
            })
            .catch(err => {
                console.error(err);
            })
        }
    },

    created() {
        eventBus.$on('accepted', id => {
            this.AnswerStatus = (id === this.id);
            console.log(this.AnswerStatus);
        })
    }
}
</script>

<style>

</style>