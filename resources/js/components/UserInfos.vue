<template>
    <div class="col-md-6 d-flex flex-column text-center mt-1">
        <a :href="user.url" class="text-body">
            <img :src="user.avatar" alt="user-img" 
                    width="40px" height="40px" class="rounded-circle border border-secondary">

            <div class="mt-1 font-weight-bold">
                {{ user.name }}
            </div>
        </a> 

        <div class="mt-2">
            <small class="text-success">online</small>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'model',
    ],
    data() {
        return {
            user: this.model.user,
        }
    },
}
</script>

<style>

</style>