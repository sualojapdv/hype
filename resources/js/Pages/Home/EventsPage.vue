<template>
    <div class="w-full max-w-xl mx-auto">
        <div
      class="w-full flex justify-between p-4 items-center"
      style="
        background-color: var(--ci-primary-color);
        border-bottom: 1px solid var(--ci-secundary-color);
      "
    >
      <div @click="$router.push('/')"><i class="fa-solid fa-chevron-left"></i></div>
      <div><p class="text-lg">Eventos</p></div>
      <div><p></p></div>
    </div>

    <div class="flex justify-between my-4">
        <div class="flex flex-col justify-start items-center ml-1 mr-2 w-[19%] max-w-sm">
            <div class="flex justify-between items-center bg-[var(--ci-primary-opacity-color)] gap-1 w-full p-4 rounded-lg text-xs flex-col"><i class="fa-solid fa-calendar-days"></i> <p>Misto</p></div>
        </div>


        <div class="flex flex-col justify-start items-center w-[79%] bg-[var(--ci-primary-color)] rounded-lg p-2 mr-1">
            <div v-for="banner in bannersHome" :key="banner.id" class="mb-4 w-full h-full bg-blue-800 rounded">
                <a :href="banner.link" class="w-full h-full">
                    <img :src="`/storage/` + banner.image" alt="" class="h-full w-full rounded">
                </a>
            </div>
        </div>
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
            bannersHome: [],
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
        getBanners: async function() {
            const _this = this;

            try {
                const response = await HttpApi.get('settings/banners');
                const allBanners = response.data.banners;

                
                _this.bannersHome = allBanners.filter(banner => banner.type === 'home');
            } catch (error) {
                console.error(error);
            } finally {

            }
        }
    },
    async created() {
        await this.getBanners();
    },
    watch: {

    },
};
</script>

<style scoped>

</style>
