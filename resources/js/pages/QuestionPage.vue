<template>
  <div class="container-fluid" style="max-width:80%">
    <div class="row justify-content-center">
        <question :question="question"></question>
        <answers :question="question" :count="question.answers_count"></answers>
    </div>
</div>
</template>

<script>
import Question from '../components/Question';
import Answers from '../components/Answers';

export default {
    components: {
      Question,
      Answers,
    },

    props: [
      'question',
    ]
}

</script>

<style>

</style>