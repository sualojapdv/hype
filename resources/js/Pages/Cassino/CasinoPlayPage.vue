<template>
    <div v-if="!isLoading && game" :class="{ 'w-full': modeMovie, 'lg:w-2/3': !modeMovie }" class="h-screen">
        <button @click="$router.push('/')" class="back-button">
            <i class="fa-solid fa-house"></i>
            <span class="text-[8px]">Sair</span>
        </button>
         <button v-if="!fullscreen && isWideScreen" @click="toggleFullscreen" class="screen-button" >
            <i class="fa-solid fa-expand"></i>
            <span class="text-[8px]"></span>
        </button> 
        
        <!-- <button v-else @click="exitFullscreen" class="screen-button">
            <i class="fa-solid fa-compress"></i>
            <span class="text-[8px]"></span>
        </button> -->
        <div class="game-screen" id="game-screen">
            <iframe :src="gameUrl" class="game-full fullscreen-wrapper"></iframe>
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
            isWideScreen: window.innerWidth > 650,
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
        });

        function toggleFullscreen() {
            const gameScreen = document.getElementById('game-screen');
            if (gameScreen.requestFullscreen) {
                gameScreen.requestFullscreen();
            } else if (gameScreen.webkitRequestFullscreen) { /* Safari */
                gameScreen.webkitRequestFullscreen();
            } else if (gameScreen.msRequestFullscreen) { /* IE11 */
                gameScreen.msRequestFullscreen();
            }
            state.fullscreen = true;
        }

        function exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
            state.fullscreen = false;
        }

        // Listen for fullscreen change events to update state
        document.addEventListener('fullscreenchange', () => {
            state.fullscreen = !!document.fullscreenElement;
        });

        return {
            ...toRefs(state),
            toggleFullscreen,
            exitFullscreen,
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
        window.addEventListener('resize', this.checkScreenWidth);
        const userAgent = navigator.userAgent.toLowerCase();
        const isSafari = userAgent.includes('safari') && !userAgent.includes('chrome');
        const isSamsungInternet = userAgent.includes('samsung') && userAgent.includes('safari') && !userAgent.includes('chrome');
        const isIOS = userAgent.includes('iphone') || userAgent.includes('ipad');

        if (isSafari || isSamsungInternet || isIOS) {
            this.showButton = true;
        }

        const float1 = document.getElementById('float1');
        const float2 = document.getElementById('float2');
        const closeBtn = document.querySelector('.close-btn');
        const closeBtn2 = document.querySelector('.close-btn2');
        float1.style.display = 'none';
        float2.style.display = 'none';
        closeBtn.style.display = 'none';
        closeBtn2.style.display = 'none';
    },beforeUnmount() {
        window.removeEventListener('resize', this.checkScreenWidth);
        const float1 = document.getElementById('float1');
        const float2 = document.getElementById('float2');
        const closeBtn = document.querySelector('.close-btn');
        const closeBtn2 = document.querySelector('.close-btn2');
        float1.style.display = 'block';
        float2.style.display = 'block';
        closeBtn.style.display = 'block';
        closeBtn2.style.display = 'block';
  },    
    methods: {
        loadingTab: function() {
            const tabsElement = document.getElementById('tabs-info');
            if (tabsElement) {
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

            return await HttpApi.get('games/single/' + _this.gameId)
                .then(async response => {
                    if (response.data?.action === 'deposit') {
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
        if (this.isAuthenticated) {
            const route = useRoute();
            this.gameId = route.params.id;

            await this.getGame();
        } else {
            this.router.push({ name: 'login', params: { action: 'openlogin' } });
        }
    },
    watch: {

    },
};
</script>


<style>html, body {
    margin: 0;
    padding: 0;
    height: 100%;
}

.back-button, .fullscreen-button, .exit-fullscreen-button, .screen-button{
    position: fixed;
    background-color: rgba(0,0,0,0.45);
    border: none;
    padding: 10px;
    cursor: pointer;
    color: white;
    z-index: 99999999;
}

.back-button {
    top: 20px;
    left: 10px;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid white;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    gap: 3px;
    justify-content: center;
    align-items: center;
    text-align: center;
    transition: background-color 0.3s;
}

.screen-button {
    top: 75px;
    left: 10px;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid white;
    font-size: 18px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    gap: 3px;
    justify-content: center;
    align-items: center;
    text-align: center;
    transition: background-color 0.3s;
}

.fullscreen-button {
    top: 80px;
    left: 10px;
    width: 90px;
    height: 45px;
    border-radius: 20px;
}

.exit-fullscreen-button {
    top: 80px;
    left: 10px;
    width: 130px;
    height: 45px;
    border-radius: 20px;
}

.game-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw; /* Largura total da viewport */
    height: 100dvh; /* Altura total da viewport */
    margin: 0;
    padding: 0;
    overflow: hidden; /* Para garantir que nada além do iframe seja visível */
    z-index: 999;
}

.game-screen {
    width: 100%;
    height: 100dvh;
    z-index: 999;
}

.game-full {
    width: 100%;
    height: 100%;
    border: none; /* Remover borda padrão do iframe */
    display: block; /* Garantir que o iframe se comporte como um bloco */
    z-index: 999;
}

.fullscreen-wrapper {
    width: 100%;
    height: 100%;
    z-index: 999;
}

/* Estilo para o gif de manutenção */
img {
    max-width: 100%; /* Garantir que a imagem não ultrapasse a largura do container */
}

</style>