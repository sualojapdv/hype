

<template>
    <div class="w-full max-w-xl mx-auto h-screen bg-[var(--ci-primary-color)] z-50">
    <div
      id="roxAgentHeader"
      class="w-full flex justify-between px-4 py-2  items-center z-50"
      style="
        background-color: var(--ci-primary-color);
        padding-top: 2rem;
      "
    >
      <div @click="$router.push('/')"><i class="fa-solid fa-chevron-left cursor-pointer text-lg"></i></div>
      <div><p class="text-lg">Solicitar Saque</p></div>
      <div><p></p></div>
    </div>

    

    <div class="z-50">
        <div v-if="setting != null && wallet != null && isLoading === false" class="flex flex-col p-4 w-full h-full" style="background-color: var(--ci-primary-color);">
                    
                    <form v-if="wallet.currency === 'BRL'" action="" @submit.prevent="submitWithdraw">
                        <div class="w-full flex justify-start items-center border-b border-[var(--ci-secundary-color)] mt-4">
                        <div class="flex gap-2 items-center text-[var(--sub-text-color)] pb-1 px-1 border-b-2 border-[var(--ci-primary-opacity-color)] relative bottom-[-2px]">
                          <i class="fa-solid fa-mobile-screen-button"></i>
                          <p class="text-xs md:text-sm">Solicitação de Saque</p>
                        </div>
                      </div>
                      <div class="grid grid-cols-3 md:grid-cols-5">
                            <div class="w-full my-2">
                            <div class="flex w-24 p-1 gap-2 justify-between items-center border border-[var(--sub-text-color)] rounded-md relative">
                            <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent :src="`/storage/rox/pix.jpg`" width="25" class="rounded-md"/>
                            <p class="text-center text-xs text-white pr-4">PIX</p>
                            <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="true" class="img @mousedown.prevent @contextmenu.prevent @dragstart.prevent-checked absolute bottom-0 right-0" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                            </div>
                        </div>
                        <div class="w-full my-2">
                            <div class="flex w-24 p-1 gap-2 justify-between items-center border border-[var(--sub-text-color)] rounded-md relative">
                            <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent :src="`/storage/rox/flagbrl.png`" width="25" class="rounded-md"/>
                            <p class="text-center text-xs text-white pr-4">BRL</p>
                            <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="true" class="img @mousedown.prevent @contextmenu.prevent @dragstart.prevent-checked absolute bottom-0 right-0" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                            </div>
                        </div>
                      </div>
                     
                      <div class="w-full flex justify-start items-center border-b border-[var(--ci-secundary-color)]"></div>
                       
                        <div class="mt-5">
                            <div class=" mb-3" style="color:var(--ci-gray-light)">
                                <label for="" class="text-xs">Nome do titular da conta</label>
                                <input v-model="withdraw.name" type="text" class="input2 hover:border-[var(--ci-secundary-color)] focus:border-[var(--ci-secundary-color)]" placeholder="Digite o nome do titular da conta" required >
                            </div>

                            <!-- <input type="hidden" name="type_document" value="document"/> -->
                            

                            <div class=" mb-3" style="color:var(--ci-gray-light)">
                                <label for="" class="text-xs">Tipo de Chave</label>
                                <select v-model="withdraw.pix_type" name="type_document" class="select2" required style="color:var(--ci-gray-light); background-color: var(--ci-primary-color);  border: 1px solid var(--ci-secundary-color);">
                                    <option value="" style="color:var(--ci-gray-light); background-color: var(--ci-primary-color);">Selecione uma chave</option>
                                    <option value="document" style="color:var(--ci-gray-light); background-color: var(--ci-primary-color);">CPF/CNPJ</option>
                                    <!-- <option value="email" style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);">E-mail</option> -->
                                    <option value="phoneNumber" style="color:var(--ci-gray-light); background-color: var(--ci-primary-color);">Telefone</option>
                                    <!-- <option value="randomKey" style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color); ">Chave Aleatória</option> -->
                                </select>
                            </div>

                            <div class=" mb-3" style="color:var(--ci-gray-light)">
                                <label for="" class="text-xs text-[var(--sub-text-color)]">Chave PIX</label>
                                <input v-model="withdraw.pix_key" type="text" class="input2 hover:border-[var(--ci-secundary-color)] focus:border-[var(--ci-secundary-color)]" v-maska="'###.###.###-##'" placeholder="Digite sua chave PIX" required >
                            </div>

                           

                            <div class="" style="color:var(--ci-gray-medium)">
                                <div class="flex justify-between text-xs mb-1" style="color:var(--ci-gray-light)">
                                    <p>Valor: ({{ parseFloat(setting.min_withdrawal).toFixed(2)}} ~ {{ parseFloat(setting.max_withdrawal).toFixed(2)}}) </p>
                                    <p class="text-[var(--sub-text-color)]">Saldo Disponível: {{ state.currencyFormat(parseFloat(wallet.balance_withdrawal), wallet.currency) }}</p>
                                </div>
                                <div class="flex hover:border-[var(--ci-secundary-color)] focus:border-[var(--ci-secundary-color)]">
                                    <input type="text"
                                           class="input2 rounded hover:border-[var(--ci-secundary-color)] focus:border-[var(--ci-secundary-color)]"
                                           v-model="withdraw.amount"
                                           :min="setting.min_withdrawal"
                                           :max="setting.max_withdrawal"
                                           placeholder="Digite o valor de retirada"
                                           required>
                                    
                                </div>
                                <!-- <div class="flex justify-between mt-2" style="color:var(--ci-gray-medium)">
                                    <p>Saldo Disponível: {{ state.currencyFormat(parseFloat(wallet.balance_withdrawal), wallet.currency) }} {{ wallet.currency }}</p>
                                </div> -->
                            </div>

                            <div class="mb-1 mt-1">
                                <div class="flex items-center mb-4">
                                    <input id="accept_terms_checkbox" v-model="withdraw.accept_terms"
                                           type="hidden"
                                           value="true"
                                           class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded ">
                                    <label for="accept_terms_checkbox" class="ms-2 text-sm font-medium " style=" display: none; color:var(--ci-gray-light)">
                                        Concordo com os termos de transferência
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-white"><input type="checkbox" value="true" class="text-green-500 mr-2" checked/>Aceito os termos de transferência</p>
                        <div class="mt-5 w-full flex items-center justify-center rounded">
                            <button type="submit" class="ui-button-blue w-full rounded">
                                <span class="text-sm rounded-lg">Solicitar Saque</span>
                            </button>
                        </div>
                    </form>
                </div>
      
      
      
      
   
    </div>
  
</div>
<BottomNavComponent/>
  

   
</template>

<script>

import {RouterLink, useRouter} from "vue-router";
import BaseLayout from "@/Layouts/BaseLayout.vue";
import WalletSideMenu from "@/Pages/Profile/Components/WalletSideMenu.vue";
import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";
import {useSettingStore} from "@/Stores/SettingStore.js";



export default {
    props: [],
    components: {WalletSideMenu, RouterLink},
    data() {
        return {
            isLoading: false,
            setting: null,
            wallet: null,
            withdraw: {
                name: '',
                pix_key: '',
                pix_type: '',
                amount: '',
                type: 'pix',
                currency: '',
                symbol: '',
                accept_terms: true
            },
            withdraw_deposit: {
                name: '',
                bank_info: '',
                amount: '',
                type: 'bank',
                currency: '',
                symbol: '',
                accept_terms: true
            },
        }
    },
    setup(props) {
        const router = useRouter();
        return {
            router
        };
    },
    computed: {},
    mounted() {
        const float1 = document.getElementById('float1');
        const float2 = document.getElementById('float2');
        const closeBtn = document.querySelector('.close-btn');
        const closeBtn2 = document.querySelector('.close-btn2');
        float1.style.display = 'none';
        float2.style.display = 'none';
        closeBtn.style.display = 'none';
        closeBtn2.style.display = 'none';
    }, beforeUnmount() {
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
        setMinAmount: function() {
            this.withdraw.amount = this.setting.min_withdrawal;
        },
        setMaxAmount: function() {
            this.withdraw.amount = this.setting.max_withdrawal;
        },
        setPercentAmount: function(percent) {
            this.withdraw.amount = ( percent / 100 ) * this.wallet.balance_withdrawal;
        },
        getWallet: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingWallet = true;

            HttpApi.get('profile/wallet')
                .then(response => {
                    _this.wallet = response.data.wallet;

                    _this.withdraw.currency = response.data.wallet.currency;
                    _this.withdraw.symbol = response.data.wallet.symbol;

                    _this.withdraw_deposit.currency = response.data.wallet.currency;
                    _this.withdraw_deposit.symbol = response.data.wallet.symbol;

                    _this.isLoadingWallet = false;
                })
                .catch(error => {
                    const _this = this;
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingWallet = false;
                });
        },
        getSetting: function() {
            const _this = this;
            const settingStore = useSettingStore();
            const settingData = settingStore.setting;

            if(settingData) {
                _this.setting                   = settingData;
                _this.withdraw.amount           = settingData.min_withdrawal;
                _this.withdraw_deposit.amount   = settingData.min_withdrawal;
            }

            _this.isLoading                 = false;
        },
        submitWithdrawBank: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.post('wallet/withdraw/request', _this.withdraw_deposit).then(response => {
                _this.isLoading = false;
                _this.withdraw_deposit = {
                    name: '',
                    bank_info: '',
                    amount: '',
                    type: '',
                    accept_terms: false
                }

                _this.router.push({ name: 'profileTransactions' });
                _toast.success(response.data.message);
            }).catch(error => {
                Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
                _this.isLoading = false;
            });
        },
        submitWithdraw: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoading = true;

            HttpApi.post('wallet/withdraw/request', _this.withdraw).then(response => {
                _this.isLoading = false;
                _this.withdraw = {
                    name: '',
                    pix_key: '',
                    pix_type: '',
                    amount: '',
                    type: '',
                    accept_terms: false
                }

                _this.router.push('/');
                _toast.success(response.data.message);
            }).catch(error => {
                Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
                _this.isLoading = false;
            });
        }
    },
    created() {
        this.getWallet();
        this.getSetting();

    },
    watch: {},
};
</script>

<style scoped>

</style>
