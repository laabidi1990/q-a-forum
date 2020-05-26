<template>

    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header h3">
                {{ title }} 
            </div>
            <div class="card-body">

                <answer :answer="answer" v-for="(answer, index) in answers" :key="answer.id" @deleted="remove(index)">
                </answer>

                <div class="text-center" v-if="nextUrl">
                    <button class="btn btn-outline-primary mt-3" @click="fetch(nextUrl)">
                        Load more Answers
                    </button>
                </div>
            </div>
        </div>
   
        <new-answer @answerAdded="addToAnswersArray" :questionId="question.id"></new-answer>
    </div>

</template>

<script>
import Answer from './Answer.vue';
import newAnswer from './newAnswer.vue';

export default {
    components: {
        Answer,
        newAnswer,
    },

    props: [
        'question',
    ],

    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null,
        }
    }, 

    created() {
        this.fetch(`/questions/${this.questionId}/answers`);
    },

    methods: {
        fetch(endpoint) {
            axios.get(endpoint)
            .then(({ data }) => {   // .then(res =>
               this.answers.push(...data.data)  // .push(...res.data.data)>
               this.nextUrl = data.next_page_url; 
            })

            .catch(err => {
                console.log(err);
            })  
        },

        remove(index) {
            this.answers.splice(index, 1);
            this.count--;
        },

        addToAnswersArray(answer) {
            this.answers.push(answer);
            this.count++;
        }
    },

    computed: {
        title() {
            return this.count +" "+ (this.count > 1 ? 'Answers' : 'Answer')
        }
    }
}
</script>

<style>

</style>