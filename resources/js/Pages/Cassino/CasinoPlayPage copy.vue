<template>
    
        
        <div v-if="!isLoading && game" :class="{ 'w-full': modeMovie, 'lg:w-2/3': !modeMovie }" class="h-screen">
    
            <button class="back-button">VOLTAR</button>
            <div class="game-screen" id="game-screen">
                <iframe  :src="gameUrl" class="game-full fullscreen-wrapper"></iframe>
            </div>
            
        </div>
        <div v-if="undermaintenance" class="flex flex-col items-center justify-center text-center py-24">
            <h1 class="text-2xl mb-4">JOGO EM MANUTENÇÃO</h1>
            <img :src="`/assets/images/work-in-progress.gif`" alt="" width="400">
        </div>
   
</template>

<script>
import { initFlowbite, Tabs, Modal } from 'flowbite';
import { RouterLink, useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/Stores/Auth.js";
import { component } from 'vue-fullscreen';
import LoadingComponent from "@/Components/UI/LoadingComponent.vue";
import GameLayout from "@/Layouts/GameLayout.vue";
import HttpApi from "@/Services/HttpApi.js";

import {
    defineComponent,
    toRefs,
    reactive,
} from 'vue';

export default {
    props: [],
    components: {
        GameLayout,
        LoadingComponent,
        RouterLink,
        component
    },
    data() {
        return {
            isLoading: true,
            game: null,
            modeMovie: true,
            gameUrl: null,
            token: null,
            gameId: null,
            tabs: null,
            undermaintenance: false,
        }
    },
    setup() {
        
        const router = useRouter();
        const state = reactive({
            fullscreen: false,
            pageOnly: false,
        })
        function togglefullscreen() {
            console.log("CLICOU");
            state.fullscreen = !state.fullscreen
        }

        return {
            ...toRefs(state),
            togglefullscreen,
            router
        }
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {

        const userAgent = navigator.userAgent.toLowerCase();
        const isSafari = userAgent.includes('safari') && !userAgent.includes('chrome');
        const isSamsungInternet = userAgent.includes('samsung') && userAgent.includes('safari') && !userAgent.includes('chrome');
        const isIOS = userAgent.includes('iphone') || userAgent.includes('ipad');

        if (isSafari || isSamsungInternet || isIOS) {
            this.showButton = true;
        }
    },
    methods: {
            loadingTab: function() {
            const tabsElement = document.getElementById('tabs-info');
            if(tabsElement) {
                const tabElements = [
                    {
                        id: 'default',
                        triggerEl: document.querySelector('#default-tab'),
                        targetEl: document.querySelector('#default-panel'),
                    },
                    {
                        id: 'descriptions',
                        triggerEl: document.querySelector('#description-tab'),
                        targetEl: document.querySelector('#description-panel'),
                    },
                    {
                        id: 'reviews',
                        triggerEl: document.querySelector('#reviews-tab'),
                        targetEl: document.querySelector('#reviews-panel'),
                    },
                ];

                const options = {
                    defaultTabId: 'default',
                    activeClasses: 'text-green-600 hover:text-green-600 dark:text-green-500 dark:hover:text-green-400 border-green-600 dark:border-green-500',
                    inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
                    onShow: () => {

                    },
                };

                const instanceOptions = {
                    id: 'default',
                    override: true
                };

               
                this.tabs = new Tabs(tabsElement, tabElements, options, instanceOptions);
            }
        },
        openModal(gameUrl) {
            window.open(gameUrl);
        },

        getGame: async function() {
            const _this = this;

            return await HttpApi.get('games/single/'+ _this.gameId)
                .then(async response =>  {
                    if(response.data?.action === 'deposit') {
                        _this.$nextTick(() => {
                            _this.router.push({ name: 'profileDeposit' });
                        });

                    }

                    const game = response.data.game;
                    _this.game = game;


                    _this.gameUrl = response.data.gameUrl;
                    _this.token = response.data.token;
                    _this.isLoading = false;

                    _this.$nextTick(() => {
                        _this.loadingTab();
                    });
                })
                .catch(error => {

                    _this.isLoading = false;
                    _this.undermaintenance = true;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {

                    });
                });
        }
    },
    async created() {
        if(this.isAuthenticated) {
            const route = useRoute();
            this.gameId = route.params.id;


            await this.getGame();
        }else{
            this.router.push({ name: 'login', params: { action: 'openlogin' } });
        }
    },
    watch: {


    },
};
</script>

<style>
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  overflow: hidden; /* Para evitar rolagem */
}

.back-button {
  position: absolute;
  top: 10px;
  left: 10px;
  background-color: var(--ci-primary-color);
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 20px;
  font-weight: bold;
  color: var(--ci-primary-opacity-color);
  border-radius: 5px;
  z-index: 1000;
  transition: background-color 0.3s;
}

.game-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100vw; /* Largura total da viewport */
  height: 100vh; /* Altura total da viewport */
  margin: 0;
  padding: 0;
  overflow: hidden; /* Para garantir que nada além do iframe seja visível */
}

.game-screen {
  width: 100%;
  height: 100%;
}

.game-full {
  width: 100%;
  height: 100%;
  border: none; /* Remover borda padrão do iframe */
  display: block; /* Garantir que o iframe se comporte como um bloco */
}

.fullscreen-wrapper {
  width: 100%;
  height: 100%;
}

/* Estilo para o gif de manutenção */
img {
  max-width: 100%; /* Garantir que a imagem não ultrapasse a largura do container */
}

.float{
    display:none !important
}
</style>