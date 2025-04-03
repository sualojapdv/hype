<template>
    <div>
        <div
      class="w-full flex justify-between p-4 items-center"
      style="
        background-color: var(--ci-primary-color);
        border-bottom: 1px solid var(--ci-secundary-color);
      "
    >
      <div @click="$router.push('/')"><i class="fa-solid fa-chevron-left"></i></div>
      <div><p class="text-2xl">Eventos</p></div>
      <div><p></p></div>
    </div>

    </div>
    <BottomNavComponent/>
    
</template>


<script>


import BottomNavComponent from "@/Components/Nav/BottomNavComponent.vue";
import HttpApi from "@/Services/HttpApi.js";

export default {
    props: [],
    components: {BottomNavComponent },
    data() {
        return {
            isLoading: false,
            games: null,
        }
    },
    setup(props) {


        return {};
    },
    computed: {

    },
    mounted() {

    },
    methods: {

    },
    async created() {

    },
    watch: {

    },
};
</script>

<style scoped>

</style>
