<template>
    <div class="w-full max-w-xl mx-auto">
    <div
      id="roxAgentHeader"
      class="w-full flex justify-between px-4 py-2  items-center"
      style="
        background-color: var(--ci-primary-color);
        border-bottom: 1px solid var(--ci-secundary-color);
      "
    >
      <div @click="$router.push('/')"><i class="fa-solid fa-chevron-left cursor-pointer text-lg"></i></div>
      <div><p class="text-lg">Centro de mensagens</p></div>
      <div><p></p></div>
    </div>

    <nav
      id="roxAgentNav"
      class="w-full py-2 pb-0"
      style="border-bottom: 1px solid var(--ci-secundary-color); background-color: var(--ci-primary-color);"
    >
      <ul
        class="flex flex-row gap-2 overflow-scroll items-center justify-start font-medium"
      >
        <li
          v-for="item in navItems"
          :key="item.id"
          :class="[
            isActive(item.id) ? 'active' : 'desactive',
            'w-fit whitespace-nowrap pb-1 px-2 text-xs',
          ]"
          @click="activateNav(item.id)"
        >
          {{ item.label }}
        </li>
      </ul>
    </nav>

    <div>

      <div class="flex flex-col gap-2 " v-show="activeContent === 'suporte'" id="divsuporte"
      >
            <div class="flex gap-3 justify-between items-start bg-[var(--ci-primary-color)] rounded-lg p-4 mx-3 mt-3">
                <div class="w-26 mr-1">
                    <img :src="`/storage/rox/img_kf_kf01.webp`" alt="Support">
                </div>

                <div class="flex flex-col justify-center items-start gap-2">
                    <h2 class="text-lg text-white">Apoio online 24/7</h2>
                    <p class="text-[var(--ci-gray-medium)] text-xs">Converse com o serviço profissional de apoio ao cliente online para resolver os seus problemas</p>
                    <a :href="socialsLink.telegram" target="_blank" class="border-2 border-[var(--ci-primary-opacity-color)] rounded-lg p-1 px-3 text-[var(--ci-primary-opacity-color)] font-semibold text-sm">Clique aqui</a>
                </div>
            </div>

            <div class="flex flex-col gap-2 justify-between items-start bg-[var(--ci-primary-color)] rounded-lg p-4 mx-3">
                <div class=" border-b-2 border-[var(--ci-secundary-color)] flex justify-start items-center gap-2 w-full mb-4">
                    <img class="w-8" :src="`/storage/rox/icon_im_telegram.webp`" alt="Telegram">
                    <p>Telegram Suporte</p>
                </div>

                <div class="flex justify-between items-center w-full">
                    <img class="w-8 h-8 rounded-full" :src="`/storage/rox/icon_im_telegram.webp`" alt="Telegram">
                    <div class="text-left w-[40%] text-xs pr-4">
                        <p>serviço on-line</p>
                        <p class="text-[var(--sub-text-color)]">PGgame{{ domain }}</p>
                    </div>
                    <a class="text-white bg-[var(--ci-primary-opacity-color)] p-1 px-2 text-xs rounded-lg max-w-[90px] w-full text-center break-words" :href="socialsLink.telegram">Contactar agora</a>
                </div>
            </div>
        
        </div>
      <div v-show="activeContent === 'noticias'" id="divNoticia">
        <div
                    class="w-full h-[80vh] m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Notícias</p>
                </div>
        </div>
      <div v-show="activeContent === 'notificacao'" id="divNotificacao">
        <div
                    class="w-full h-[80vh] m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Notificações</p>
                </div>
        </div>
      <div v-show="activeContent === 'painelRolante'" id="divPainelRolante">
               
                <!-- <div
                    class="w-full h-[80vh] m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Registros</p>
                </div> -->
                <p class="m-4 text-sm">{{ scrollingText }}</p>
        
            </div>
      <div v-show="activeContent === 'bonusDeSugestao'" id="divBonusDeSugestao" class="p-3">
                <div class="w-full p-4 flex gap-2 justify-start items-center text-white">
                    <div class="rounded-lg p-1 px-2 bg-[var(--ci-primary-opacity-color)] border border-[var(--ci-primary-opacity-color)]">Criar Feedback</div> <div class="bg-[rgb(60, 60, 60, 0.4)] border border-gray rounded-lg p-1 px-2">Meu Feedback</div>
                </div>

                <div class="bg-[var(--ci-primary-color)] flex flex-col gap-2 p-4 rounded-lg">
                    <p class="text-white">Conteúdo do Feedback <span class="text-gray font-extralight">(Faça sugestões para melhorias)</span></p>
                    <textarea class="bg-transparent h-32 border-[var(--ci-secundary-color)]" placeholder="Suas opiniões são valiosas para nós. Qualquer sugestão valiosa será considerada, e uma vez adotada, o nível de importância determinará a recompensa em dinheiro. Sinta-se à vontade para fazer sugestões!"></textarea>
                    <p class="text-white">As imagens não mentem <span class="text-gray font-extralight">(Mais fácil de ser aceito)</span></p>
                    <div class="text-center text-gray border border-gray text-xl w-[45px] h-[45px] flex justify-center items-center"><p>+</p></div>
                    <span class="text-gray font-extralight">O envio de imagens e vídeos é suportado (com até 50MB)</span>
                    <p class="text-white">Regras para recompensas </p>
                    <span class="text-gray font-extralight">Estabelecemos bônus substanciais especificamente para coletar feedback, a fim de otimizar o sistema e recursos para proporcionar uma melhor experiência a você! Uma vez aceitas, as recompensas serão concedidas com base na utilidade (exceto aquelas não aceitas).</span>

                </div>
                <button class="bg-[var(--ci-primary-opacity-color)] text-white w-full self-center rounded-lg h-8 mt-3" @click="$router.push('/')">Enviar feedback</button>
        </div>
   
    </div>
  
</div>
<BottomNavComponent/>
  

   
</template>


<script>
import { Modal } from 'flowbite';
import HttpApi from "@/Services/HttpApi.js";
import { useRouter } from "vue-router";
import BottomNavComponent from "@/Components/Nav/BottomNavComponent.vue";

export default {
    props: [],
    components: { Modal, BottomNavComponent},
    data() {
        return {
            scrollingText: '',
            socialsLink: {},
            domain: '',
            isLoading: false,         
            activeContent: "suporte",
            navItems: [
                { id: "suporte", label: "Suporte" },
                { id: "noticias", label: "Notícia" },
                { id: "notificacao", label: "Notificação" },
                { id: "painelRolante", label: "Painel Rolante" },
                { id: "bonusDeSugestao", label: "Bônus de Sugestão" },
            ],
        }
    },
    mounted() {
        this.getDomain();
        this.getSocials(); // Chamada correta para inicializar socialsLink

        const scrollText = localStorage.getItem('scrollingText');
        if(scrollText) {
        this.scrollingText = scrollText;
        };
    },
    methods: {
        getSocials() {
            // Exemplo simulado de obtenção de dados do localStorage
            this.socialsLink = JSON.parse(localStorage.getItem('customData')) || {};
        },  
        getDomain() {
            const hostname = window.location.hostname.replace('www.', '');
            this.domain = hostname;
        },
        activateNav(id) {
            this.activeContent = id;
        },
        isActive(id) {
            return this.activeContent === id;
        },  
    },
    async created() {
        this.getSocials(); // Corrigido para chamar o método corretamente
    },
    watch: {
        // Se houver necessidade de usar watchers, você pode implementá-los aqui
    },
};
</script>

<style scoped>
nav ul {
    cursor: pointer;
}

#roxAgentNav ul {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

#roxAgentNav ul::-webkit-scrollbar {
    display: none;
}

.active {
    border-bottom: 4px solid var(--ci-primary-opacity-color);
    color: var(--ci-primary-opacity-color);
}

.desactive {
    border: none;
}

.cursor-pointer {
  cursor: pointer;
}
</style>
