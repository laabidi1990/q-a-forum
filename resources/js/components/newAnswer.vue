<template>
    <div class="card mt-4 col-md-8 text-center" style="margin:auto;">
        <div class="card-header">Write your answer</div>
        <div class="card-body">
            <form @submit.prevent="addAnswer">
                <div class="form-group">
                    <textarea name="body" v-model="body" cols="5" rows="5" class="form-control" required>
                    </textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-25" :disabled="isInvalid">Add your Answer</button>
                </div>
            </form>
        </div>
    </div>  
</template>

<script>
export default {
    props: [
        'questionId',
    ],

    data() {
        return {
            body: '',
        }
    },

    computed: {
        isInvalid() {
            return ! this.signedIn || this.body.length < 5;
        }
    },

    methods: {
        addAnswer() {
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body
            })
            .catch(err => {
                this.$toast.error(error.response.data.message, "Error")
            })
            .then(({data}) => {
                this.$toast.success(data.message, "Success");
                this.body = '';
                this.$emit('answerAdded', data.answer);
            })
        }
    }
}
</script>

<style>

</style>