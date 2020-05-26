<template>
    <div class="media row my-3 pb-3 position-relative border-bottom" v-cloak>
        <div class="col-md-2 border-right">
            <div class="row d-flex justify-content-between">
                <div class="col-md-6 text-center votes-control">

                    <vote :model="answer" name="answer"></vote>

                    <accept :answer="answer"></accept>

                </div>
                
                <user-infos :model="answer"></user-infos>

            </div>
            
        </div>
    
        <div class="col-md-10">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea name="" id="" rows="8" class="form-control" v-model="body" required>
                    </textarea>
                </div>
                <button class="btn btn-outline-info mr-2" type="submit" :disabled='isInvalid'>
                    Update
                </button>
                <button @click.prevent="cancelAnswer" class="btn btn-outline-secondary">
                    Cancel
                </button>
            </form>

            <div v-else class="media-body" v-html="bodyHtml"></div>
            
        </div>
        
        <div class="text-muted position-absolute" style="bottom:10%;right:1%">
            {{ createdDate }}
        </div>

        <div class="text-muted position-absolute d-flex" style="bottom:10%;left:18%" v-if="!editing">
            <a @click.prevent="editAnswer" class="btn btn-outline-info mr-2 px-3" v-if="authorize('modify', answer)">
                Edit
            </a>

            <button @click.prevent="deleteAnswer" class="btn btn-outline-danger mr-2" v-if="authorize('modify', answer)">
                Delete
            </button>
        </div>

    </div>
</template>

<script>
import accept from '../components/AcceptAnswer';

export default {
    components: {
        accept
    },

    props: [
        'answer',
    ],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            createdDate: this.answer.created_date,
            questionId: this.answer.question_id,
            beforeEditCache: null,
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10
        },
        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`;
        }

    },

    methods: {
        editAnswer() {
            this.beforeEditCache = this.body;
            this.editing = true;
        },

        cancelAnswer() {
            this.body =  this.beforeEditCache;
            this.editing = false;
        },

        update() {
            axios.patch(this.endpoint, {
                body: this.body
            })
            .then( res => {
                this.editing = false;
                this.bodyHtml = res.data.body_html;
                this.$toast.success(res.data.message, 'Success', { timeout : 3000 });
            })
            .catch(err => {
                this.$toast.error(err.data.message, 'Error', { timeout : 3000 });
            }) 
        },

        deleteAnswer() {
            if (confirm('Are you sure!'))
            {
                axios.delete(this.endpoint)
                .then( res => {
                    this.$toast.success(res.data.message, 'Success', { timeout : 3000 });
                    this.$emit('deleted');
                })

                .catch( error => {
                    this.$toast.error(err.data.message, 'Error', { timeout : 3000 });
                })
            }
      
        }
    }
}
</script>

<style>

</style>