<template>
    <button v-if="wallet?.total_balance === undefined || isLoadingWallet" disabled type="button" class="flex justify-center items-center mr-3 pt-1">
        
    </button>
    <button v-else type="button" class="flex justify-center items-center mr-0 md:mr-3 max-h-8 md:max-h-none wallet-money walletButton ">
        <div class="mr-1">
            <img class="flag" :src="`/storage/rox/brazilian_rox.webp`" alt="BRL" >
        </div>
        <div>
            <strong class="text-lg md:text-lg underline" style="color: var(--ci-primary-opacity-color); " >{{ formatCurrency(wallet?.total_balance) }}</strong>
        </div>
       <div class="ml-2 text-md flex items-center">
          <i @click="refreshBalance" :class="{ 'refreshing': isRefreshing }" style="color: var(--ci-primary-opacity-color);" class="fa-solid fa-arrows-rotate refresh-icon"></i>
        </div>
    </button>
</template>

<script>
    import HttpApi from "@/Services/HttpApi.js";
    import {onMounted, ref, watch, watchEffect} from "vue";
    import {useRoute} from "vue-router";

    export default {
        props: {
            wallet: {
            type: Object,
            default: () => ({})
            }
        },
        components: {},
        data() {
            return {
                isLoadingWallet: true,
                wallet: null,
                processInterval: null,
                isRefreshing: false
            }
        },
        setup(props) {
            const route = useRoute();
            const isCasinoPlayPage = ref(false);

            watchEffect(() => {
                checkRoute();
            });

            onMounted(() => {
                checkRoute();
            });

            function checkRoute() {
                // Verifique se a rota atual é 'casinoPlayPage'
                isCasinoPlayPage.value = route.name === 'casinoPlayPage';
            }

            return {
                isCasinoPlayPage
            };
        },
        computed: {

        },
        beforeUnmount() {
            clearInterval(this.processInterval);
        },
        mounted() {

        },
        methods: {
            async refreshBalance() {
                this.isRefreshing = true;
                await this.getWallet();
                setTimeout(() => {
                    this.isRefreshing = false;
                }, 1000); 
            },
            formatCurrency(value) {
      if (value == null) return '';
      return Number(value).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
            getWallet: async function() {
                const _this = this;

                await HttpApi.get('profile/wallet')
                    .then(response => {
                        _this.wallet = response.data.wallet;
                        _this.isLoadingWallet = false;
                    })
                    .catch(error => {
                        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                            if(value == 'unauthenticated') {
                                localStorage. clear();
                                clearInterval(this.processInterval);
                            }
                        });

                        _this.isLoadingWallet = false;
                    });
            },
        },
        async created() {
            if(this.isCasinoPlayPage) {
                this.processInterval = setInterval(async  () => {
                    await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método
                }, 5000);
            }

            await this.getWallet(); // Substitua 'seuMetodo' pelo nome do seu método
        },
        watch: {

        },
    };
</script>

<style scoped>
.refreshing{
    animation: spinrefresh 1s infinite;
}

@keyframes spinrefresh {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
.walletButton{
    transform: scale(0.99) !important;

}

@media screen and (max-width: 450px){
    .walletButton{
    transform: scale(0.8) !important;

}
}
.flag{
    width:25%;
    min-width: 20px !important;
    max-width: 30px;
}




</style>
