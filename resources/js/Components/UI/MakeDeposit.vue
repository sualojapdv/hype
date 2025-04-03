<template>
    <div>
        <button 
            @click.prevent="toggleModalDeposit" 
            type="button" 
            :class="[showMobile === false ? 'hidden md:block' : '', isFull ? 'w-full' : '']" 
            class="ui-button mr-0 sm:ml-1 md:mr-1 roxDepositButton">
            {{ title }}
        </button>

        <div
            id="modalElDeposit"
            tabindex="-1"
            aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-hidden"
            style="height: 100vh; z-index: 99999;"
        >
            <div
            class="relative w-full max-w-2xl md:w-full mx-auto my-4 rounded-lg shadow h-full md:h-auto pt-[2rem] md:pt-none"
            style="background-color: var(--ci-primary-color);"
            >
            <div class="flex flex-col px-6 pb-8 my-auto w-full">
                <div class="flex w-full justify-between items-center modal-header mb-6 mt-6">
                
                    <div>
                        <i @click.prevent="toggleModalDeposit"  class="fa-solid fa-chevron-left block md:hidden cursor-pointer"></i>
                    </div>
                    <h1 class="text-base md:text-lg text-center" style="var(--ci-gray-light)">Depósito</h1>
                    <div></div>
                    
                
                </div>

                <DepositWidget :close-modal="toggleModalDeposit" v-if="modalDeposit" />
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from "@/Stores/Auth.js";
import DepositWidget from "@/Components/Widgets/DepositWidget.vue";
import { onMounted } from "vue";
import { initFlowbite, Modal } from "flowbite";

export default {
    props: ['showMobile', 'title', 'isFull'],
    components: { DepositWidget },
    data() {
        return {
            isLoading: false,
            modalDeposit: null,
        };
    },
    setup(props) {
        onMounted(() => {
            initFlowbite();
        });

        return {};
    },
    computed: {
        isAuthenticated() {
            const authStore = useAuthStore();
            return authStore.isAuth;
        },
    },
    mounted() {
        this.modalDeposit = new Modal(document.getElementById('modalElDeposit'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {
                this.paymentType = null;
            },
            onShow: () => {},
            onToggle: () => {},
        });

       
    },
    methods: {
        toggleModalDeposit() {
            this.modalDeposit.toggle();
        },
    },
};
</script>

<style scoped>
/* Adicione quaisquer estilos adicionais necessários aqui */

.roxDepositButton{
    background-color: var(--ci-primary-opacity-color);
    padding: 0.7rem;
    border-radius: 8px;
}

@media screen and (max-width: 768px){
    .roxDepositButton{
        padding: 0.4rem 0 0.4rem 0.4rem;
        border-radius: 8px 0 0 8px;
        border-right: 1px solid var(--ci-primary-opacity-color);
        transform: scale(0.8);
    }
}
</style>
