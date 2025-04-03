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
      <div><p class="text-2xl">Pendentes</p></div>
      <div><p></p></div>
    </div>

    
        <div
                    class="w-full h-[80vh] m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Registros</p>
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
