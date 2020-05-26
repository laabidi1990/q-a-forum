<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h2>Ask a Question</h2>
                        <div class="ml-auto">
                            <a href="/questions" class="btn btn-outline-secondary">
                                Back to all Questions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form @submit="addQuestion">
                        <div class="form-group">
                            <label for="question-title">Question Title</label>
                            <input type="text" id="question-title" name="title" v-model="title" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="question-body">Explain your question</label>
                            <textarea type="text" id="question-body" name="body" v-model="body" class="form-control" rows="10" required>
                            </textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary btn-lg px-4" :disabled="isInvalid">
                               Ask
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
      return {
            title: '',
            body: '',
        }
    },

    computed: {
        isInvalid() {
             return ! this.signedIn || this.title.length < 5 || this.body.length < 10;
        }
    },

    methods: {
        addQuestion() {
            axios.post(`/questions`, {
                title: this.title,
                body: this.body
            })
            .then(({data}) => {
                this.$toast.success(data.message, "Success", { timeout: 4000 });
                window.location.href = '/questions';
            })
            .catch(err => {
                this.$toast.error(error.response.data.message, "Error")
            })
    }
    },
}
</script>

<style>

</style>