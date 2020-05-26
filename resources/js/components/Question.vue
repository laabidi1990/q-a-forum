<template>
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex" style="width:70%">
                            <h2 class="mt-2">{{ title }}</h2>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <a @click.prevent="editQuestion" class="btn btn-outline-info mr-2 px-3" 
                                v-if="authorize('modify', question)">
                                Edit
                            </a>

                            <button @click.prevent="deleteQuestion" class="btn btn-outline-danger mr-2" 
                                v-if="authorize('delete', question)">
                                Delete
                            </button>
                            <a href="/questions" class="btn btn-outline-secondary">
                                Back to all Questions
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body row">
                    <div class="col-md-3 d-flex justify-content-between">
                        <div class="d-flex flex-column align-items-between text-center text-secondary votes-control">
                            <vote :model="question" name="question"></vote>
                            <favorite :question="question"></favorite>
                        </div>
                        <div style="width:100%">
                            <user-infos :model="question"></user-infos>
                        </div>
                     
                    </div>
            
                    <div class="col-md-9 border-left pl-4" style="margin-left:-9%">
                        <form v-if="editing" @submit.prevent="updateQuestion">
                            <div class="form-group">
                                <input type="text" class="form-control mb-3" v-model="title" required>
                                <textarea rows="10" class="form-control" v-model="body" required>
                                </textarea>
                            </div>
                            <button class="btn btn-outline-info mr-2" type="submit" :disabled='isInvalid'>
                                Update
                            </button>
                            <button @click.prevent="cancelQuestion" class="btn btn-outline-secondary">
                                Cancel
                            </button>
                        </form>

                        <div v-else v-html="bodyHtml"></div>
                    
                        <span class="float-right mt-3 text-muted">
                            {{ createdDate }}
                        </span>
                    </div>
           
                </div>
            </div>

        </div>
</template>

<script>
import favorite from '../components/Favorite';

export default {
    components: {
        favorite,
    },

    props: [
        'question'
    ],

    data() {
        return {
            id: this.question.id,
            title: this.question.title,
            body: this.question.body,
            createdDate: this.question.created_date,
            bodyHtml: this.question.body_html,
            editing: false,
            beforeEditCache: [],
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 20 && this.title.length < 5;
        },
        endpoint() {
            return `/questions/${this.id}`;
        }
    },

    methods: {
        editQuestion() {
            this.beforeEditCache = [this.title, this.body];
            this.editing = true;
        },

        cancelQuestion() {
            this.title =  this.beforeEditCache[0];
            this.body =  this.beforeEditCache[1];
            this.editing = false;
        },

        updateQuestion() {
            axios.patch(this.endpoint, {
                title: this.title,
                body: this.body,
            })
            .then( res => {
                console.log(res);
                this.editing = false;
                this.bodyHtml = res.data.body_html;
                this.$toast.success(res.data.message, 'Success', { timeout : 3000 });
            })
            .catch(err => {
                this.$toast.error(err.data.message, 'Error', { timeout : 3000 });
            }) 
        },

        deleteQuestion() {
            if (confirm('Are you sure!'))
            {
                axios.delete(this.endpoint)
                .then( res => {
                    this.$toast.success(res.data.message, 'Success', { timeout : 3000 });
                    this.$emit('deleted');
                    window.location.href = '/questions';
                })
                .catch( err => {
                    console.log(err);
                })
            }
        }
    }
}
</script>

<style>

</style>