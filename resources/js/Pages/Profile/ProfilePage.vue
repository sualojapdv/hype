<template>
    <div class="w-full max-w-xl mx-auto">
        <div class="w-full bg-[var(--ci-primary-color)]">
            <div class="w-full flex px-2 py-4 justify-between">
                <div class="flex gap-2">
                    <img class="w-[75px] rounded-lg" :src="`/storage/rox/img_txn23.png`" alt="minha foto"/>
                    <div>
                        <p class="pl-2">ID: {{ idUser }} <i class="fa-regular fa-copy text-[var(--ci-primary-opacity-color)] cursor-pointer ml-2"></i></p>
                        <p class="pl-2">Conta: {{ userName }}</p>
                        <WalletBalance style="border:none !important; transform: scale(1.2)"/>
                    </div>
                </div>
                <div @click="$router.push('/home/support')" class="flex flex-col gap-1 items-center justify-start ">
                    <i class="block fa-solid fa-envelope cursor-pointer text-xl"></i>
                    <p class="block cursor-pointer">Informação</p>
                </div>
            </div>

            <div class="w-full flex p-4 justify-between items-center ">
                <div @click.prevent="toggleModalDeposit" class="flex flex-col items-center justify-center gap-1 px-2">
                    <i class="fa-solid fa-money-bill-transfer block text-3xl text-white"></i>
                    <p class="block">Depositar</p>
                </div>

                <div @click="$router.push('/profile/withdraw')" class="flex flex-col items-center justify-center gap-1 px-2">
                    <i class="fa-solid fa-sack-dollar block text-3xl text-white"></i>
                    <p class="block">Sacar</p>
                </div>

                <div @click="$router.push('/profile/transactions')" class="flex flex-col items-center justify-center gap-1 px-2">
                    <i class="fa-solid fa-cash-register block text-3xl text-white"></i>
                    <p class="block">Transações</p>
                </div>

                <div @click="$router.push('/home/events')" class="flex flex-col items-center justify-center gap-1 px-2">
                    <i class="fa-solid fa-calendar-days block text-3xl text-white"></i>
                    <p class="block">Promoções</p>
                </div>
            </div>


            <!-- <div v-if="setting.disable_rollover === false || setting.rollover_deposit > 0" class="flex justify-between col-span-2 p-4">
                                <div class="flex w-1/2">
                                    <div class="rounded-full ring-2 ring-[var(--ci-secundary-color)] px-4 py-2 text-center flex justify-center items-center">
                                        <i class="fa-sharp fa-regular fa-dollar-sign text-2xl"></i>
                                    </div>
                                    <div class="leading-4 ml-3">
                                        <span>Rollover Depósito</span>
                                        <h1 class="text-lg font-bold " style="color: var(--ci-primary-opacity-color)">{{ state.currencyFormat(parseFloat(wallet.balance_deposit_rollover), wallet.currency) }}</h1>
                                    </div>
                                </div>
                                <div class="w-1/2">
                                    <div class="w-full bg-[var(--ci-secundary-color)] rounded-full dark:bg-[var(--ci-secundary-color)]">
                                        <div class="bg-green-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full truncate px-3" :style="{ width: rolloverPercentage(parseFloat(wallet.balance_deposit_rollover))   }">
                                            {{ rolloverPercentage(parseFloat(wallet.balance_deposit_rollover)) }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="setting.disable_rollover === false || setting.rollover > 0" class="flex justify-between w-full col-span-2 p-4">
                               <div class="flex w-1/2">
                                   <div class="rounded-full ring-2 ring-[var(--ci-secundary-color)] px-4 py-2 text-center flex justify-center items-center">
                                       <i class="fa-sharp fa-regular fa-dollar-sign text-2xl"></i>
                                   </div>
                                   <div class="leading-4 ml-3">
                                       <span>Rollover de Bônus</span>
                                       <h1 class="text-lg font-bold " style="color: var(--ci-primary-opacity-color)">{{ state.currencyFormat(parseFloat(wallet.balance_bonus_rollover), wallet.currency) }}</h1>
                                   </div>
                               </div>
                                <div class="w-1/2">
                                    <div class="w-full bg-[var(--ci-secundary-color)] rounded-full dark:bg-[var(--ci-secundary-color)] mb-1">
                                        <div class="flex bg-green-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full truncate px-3" :style="{ width: rolloverPercentage(parseFloat(wallet.balance_bonus_rollover))   }">
                                            {{ rolloverPercentage(parseFloat(wallet.balance_bonus_rollover)) }}% - Barra de Rollover
                                        </div>
                                    </div>
                                    <div class="w-full bg-[var(--ci-secundary-color)] rounded-full dark:bg-[var(--ci-secundary-color)]">
                                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full truncate px-3" :style="{ width: rolloverPercentage(parseFloat(setting.rollover_protection))   }">
                                            {{ rolloverPercentage(parseFloat(setting.rollover_protection)) }} - Barra de Proteção
                                        </div>
                                    </div>
                                </div>
                            </div>
                        -->
        </div>
        


        <div 
                id="modalElDeposit" 
                tabindex="-1" 
                aria-hidden="true" 
                class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto h-screen">
                <div class="relative w-full max-w-2xl mx-auto my-8 rounded-lg shadow" style="background-color: var(--ci-primary-color);">
                    <div class="flex flex-col px-6 pb-8 my-auto">
                        <div class="flex justify-center items-center modal-header mb-6 mt-6">
                            <div>
                                <h1 class="font-bold text-xl text-center" style="var(--ci-gray-light)">Depósito</h1>
                            </div>
                        </div>

                        <DepositWidget  :close-modal="toggleModalDeposit" v-if="modalDeposit"/>
                    </div>
                </div>
            </div>

        <div class="mx-2 my-2 flex flex-col p-2 rounded-lg bg-[var(--ci-primary-color)]">
            <div @click="$router.push('/home/agents')" class="flex w-full justify-between items-center text-white border-b border-[var(--ci-secundary-color)] p-1 pt-2 cursor-pointer">
                <div><p class="text-sm flex gap-2 items-center"><i class="fa-regular fa-bullhorn text-[var(--ci-primary-opacity-color)]"></i> Convide</p></div>
                <i class="fa-solid fa-angle-right"></i>
            </div>
            
            <div @click="$router.push('/home/support')" class="flex w-full justify-between items-center text-white border-b border-[var(--ci-secundary-color)] p-1 pt-2 cursor-pointer">
                <div><p class="text-sm flex gap-2 items-center"><i class="fa-regular fa-headset text-[var(--ci-primary-opacity-color)]"></i> Suporte</p></div>
                <i class="fa-solid fa-angle-right"></i>
            </div>
            
            <div @click="downloadApp" class="flex w-full justify-between items-center text-white border-b border-[var(--ci-secundary-color)] p-1 pt-2 cursor-pointer">
                <div><p class="text-sm flex gap-2 items-center"><i class="fa-regular fa-download text-[var(--ci-primary-opacity-color)]"></i> Baixar aplicativo</p></div>
                <i class="fa-solid fa-angle-right"></i>
            </div>
            <div @click="$router.push('/home/about')" class="flex w-full justify-between items-center text-white border-b border-[var(--ci-secundary-color)] p-1 pt-2 cursor-pointer">
                <div><p class="text-sm flex gap-2 items-center"><i class="fa-regular fa-circle-info text-[var(--ci-primary-opacity-color)]"></i> Sobre</p></div>
                <i class="fa-solid fa-angle-right"></i>
            </div>
            
            <div @click="logoutAccount" class="flex w-full justify-between items-center text-white p-1 pt-2 cursor-pointer">
                <div><p class="text-sm flex gap-2 items-center"><i class="fa-solid fa-arrow-right-from-bracket text-[var(--ci-primary-opacity-color)]"></i> Sair</p></div>
                <i class="fa-solid fa-angle-right"></i>
            </div>
        </div>
    </div>
    <BottomNavComponent/>
</template>


<script>
import BottomNavComponent from "@/Components/Nav/BottomNavComponent.vue";
import WalletBalance from "@/Components/UI/WalletBalance.vue";
import DepositWidget from "@/Components/Widgets/DepositWidget.vue";
import WithdrawWidget from "@/Components/Widgets/WithdrawWidget.vue";
import HttpApi from "@/Services/HttpApi.js"; 
import { useAuthStore } from "@/Stores/Auth.js";
import { useToast } from "vue-toastification"; // Ajuste para o caminho correto
import {useSettingStore} from "@/Stores/SettingStore.js";

export default {
    components: {BottomNavComponent, WalletBalance, DepositWidget, WithdrawWidget},
    data() {
        return {
            idUser: '',
            userName: '',
            modalDeposit: null,
            isLoadingWallet: true,
            wallet: null,
            mywallets: null,
            setting: null,
            isLoading: false,
        };
    },
    mounted() {
        this.getProfile();
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
        setWallet: function(id) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.post('profile/mywallet/'+ id, {})
                .then(response => {
                   _this.getMyWallet();
                    _this.isLoadingWallet = false;
                    window.location.reload();

                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        // _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;
                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        // _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getMyWallet: function() {
            const _this = this;
            const _toast = useToast();

            HttpApi.get('profile/mywallet')
                .then(response => {
                    _this.mywallets = response.data.wallets;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        // _toast.error(`${value}`);
                    });
                });
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting = settingData;
            }

            _this.isLoading = false;
        },
        rolloverPercentage(balance) {
            return Math.max(0, ((balance / 100) * 100).toFixed(2));
        },
        toggleModalDeposit() {
            this.modalDeposit.toggle();
        },
        
        async getProfile() {
            this.isLoadingProfile = true;
            try {
                const response = await HttpApi.get("/profile/");
                const user = response.data.user;
                // console.log(user)
                if (user) {
                    this.idUser = user.id;
                    this.userName = user.name;
                }
            } catch (error) {
                console.error("Erro ao obter perfil:", error);
            } finally {
                this.isLoadingProfile = false;
            }
        },
        downloadApp() {
            const link = document.createElement('a');
            link.href = '/assets/1716362201126-rox777_1.0.2.apk';
            link.download = 'rox777_1.0.2.apk';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        async logoutAccount() {
            const authStore = useAuthStore();
            const _toast = useToast();
            try {
                await HttpApi.post("auth/logout", {});
                authStore.logout();
                this.$router.push("/home/game");
                // _toast.success("Você foi desconectado com sucesso");
            } catch (error) {
                console.error("Erro ao fazer logout:", error);
                const errorMsg = JSON.parse(error.request.responseText);
                _toast.error(errorMsg.message || "Erro ao fazer logout");
            }
        }
    },
    created() {
        this.getWallet();
        this.getMyWallet();
        this.getSetting();
    },
    watch: {

    }
};
</script>

<style scoped>
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
