<template>
  
    <div class="block">
        <div v-if="(paymentType == null || paymentType === '') && wallet && setting">
            <div class="">
               
                <ul>
                    <li v-if="setting.digitopay_is_enable" @click="setPaymentMethod('pix', 'digitopay')" class=" bg-white dark:bg-gray-900 cursor-pointer flex justify-between hover:bg-green-700/20 px-4 py-3 mb-3">
                        <div class="flex items-center gap-4">
                            <img :src="`/assets/images/pix.png`" alt="" width="100">
                            <p>DIGITOPAY</p>
                        </div>
                        <div>

                        </div>
                        <div class="flex justify-center items-center text-gray-700 gap-4">
                            <i class="fa-solid fa-chevron-right ml-2"></i>
                        </div>
                    </li>
                    <li v-if="setting.mercadopago_is_enable" @click="setPaymentMethod('pix', 'mercadopago')" class=" bg-white dark:bg-gray-900 cursor-pointer flex justify-between hover:bg-green-700/20 px-4 py-3 mb-3">
                        <div class="flex items-center gap-4">
                            <img :src="`/assets/images/pix.png`" alt="" width="100">
                            <p>MERCADO PAGO</p>
                        </div>
                        <div>

                        </div>
                        <div class="flex justify-center items-center text-gray-700 gap-4">
                            <i class="fa-solid fa-chevron-right ml-2"></i>
                        </div>
                    </li>
                    <li v-if="setting.sharkpay_is_enable" @click="setPaymentMethod('pix', 'sharkpay')" class=" bg-white dark:bg-gray-900 cursor-pointer flex justify-between hover:bg-green-700/20 px-4 py-3 mb-3">
                        <div class="flex items-center gap-4">
                            <img :src="`/assets/images/pix.png`" alt="" width="100">
                            <p>SHARKPAY</p>
                        </div>
                        <div>

                        </div>
                        <div class="flex justify-center items-center text-gray-700 gap-4">
                            <i class="fa-solid fa-chevron-right ml-2"></i>
                        </div>
                    </li>
                    <li v-if="setting.suitpay_is_enable" @click="setPaymentMethod('pix', 'suitpay')" class=" bg-white dark:bg-gray-900 cursor-pointer flex justify-between hover:bg-green-700/20 px-4 py-3 mb-3">
                        <div class="flex items-center gap-4">
                            <img :src="`/assets/images/pix.png`" alt="" width="100">
                            <p>SUITPAY</p>
                        </div>
                        <div>

                        </div>
                        <div class="flex justify-center items-center text-gray-700 gap-4">
                            <i class="fa-solid fa-chevron-right ml-2"></i>
                        </div>
                    </li>
                    <li v-if="setting.stripe_is_enable" @click="setPaymentMethod('stripe', 'stripe')" class="bg-white dark:bg-gray-900 cursor-pointer flex justify-between hover:bg-green-700/20 px-4 py-3 mb-2">
                        <div>
                            <img :src="`/assets/images/stripe.png`" alt="" width="80">
                        </div>
                        <div>

                        </div>
                        <div class="flex justify-center items-center gap-4 text-gray-700">
                            <i class="fa-solid fa-chevron-right ml-2"></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div v-if="paymentType === 'stripe' && publishableKey && setting && setting.stripe_is_enable" class="p-4">
            <stripe-checkout
                ref="checkoutRef"
                :pk="publishableKey"
                :sessionId="sessionId"
            />
            <div class="flex w-full mt-3 mb-3">
                <div class="w-36 mr-2">
                    <label for="currency" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Currency') }}</label>
                    <select id="currency" v-model="currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="USD">$ {{ $t('Dollar') }}</option>
                        <option value="BRL">R$ {{ $t('Real') }}</option>
                    </select>
                </div>
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Amount') }}</label>
                    <input type="number"
                           v-model="amount"
                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           :min="setting.min_deposit"
                           :max="setting.max_deposit"
                           :placeholder="$t('0,00')"
                           required
                    >
                </div>
            </div>

            <button :disabled="!sessionId" @click.prevent="checkoutStripe" class="ui-button-blue rounded w-full">{{ $t('Pay With Stripe') }}</button>
        </div>
        <div v-if="setting && paymentType === 'pix' && (setting.suitpay_is_enable || setting.mercadopago_is_enable || setting.digitopay_is_enable)">
            <div v-if="showPixQRCode && wallet" class="flex flex-col ">
                <div class="w-full p-4 rounded mb-3" style="background-color: var(--ci-primary-opacity-color);">
                    <div class="flex justify-between">
                        <h2 class="text-xl md:text-4xl" style="color: var(--ci-gray-light)">BÔNUS EXPIRA EM:</h2>
                        <div class="text-xl md:text-4xl">
                            <p>{{countdown}}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full p-4">
                    <div>
                        <p class="font-bold w-full text-center " style="color: var(--ci-primary-opacity-color)">Valor do Pix: {{ state.currencyFormat(parseFloat(deposit.amount), wallet.currency) }}</p>
                    </div>
                    <div class="p-3 flex justify-center items-center">
                        <QRCodeVue3 :value="qrcodecopypast"/>
                    </div>
                    
                    <div class="mt-4">
                        <p class="mb-3">Se preferir, você pode pagá-lo copiando o código abaixo:</p>
                        <input id="pixcopiaecola" type="text" class="input text-gray-700" v-model="qrcodecopypast" style="background-color: var(--ci-secundary-color);">
                    </div>

                    <div class="mt-5 w-full flex items-center justify-center">
                        <button @click.prevent="copyQRCode" type="button" class="ui-button-blue w-full">
                            <span class="uppercase font-semibold text-sm">{{ $t('Copy code') }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="!showPixQRCode">
                <div v-if="setting != null && wallet != null && isLoading === false" class="flex flex-col w-full">
                    <form action="" @submit.prevent="submitQRCode">
                                               

                        <div class="mt-3">
                          <div class="w-full flex items-center justify-between rounded py-1" style="background-color: var(--ci-secundary-color);">
                          <div class="flex w-full relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700 dark:text-gray-700">
                              R$
                            </div>
                            <input type="number"
                                  v-model="deposit.amount"
                                  class="appearance-none border rounded-md bg-transparent border-none w-full pl-8 text-gray-700 placeholder:text-gray-700 dark:text-gray-700 dark:placeholder:text-gray-700"
                                  :min="setting.min_deposit"
                                  :max="setting.max_deposit"
                                  :placeholder="`Digite aqui o valor de depósito`"
                                  required
                                  style="padding-left: 2.5rem;">
                          </div>
                        </div>
                          <p style="width: 100%; text-align: right; color: var(--ci-primary-opacity-color);">R$ {{ parseFloat(setting.min_deposit) }} - R$ {{ parseFloat(setting.max_deposit) }}</p>
                        </div>

                        <div class="item-selected flex flex-wrap items-center justify-between">
                            <div @click.prevent="setAmount(parseFloat(setting.min_deposit))" class="item text-gray-700" :class="{'active' : selectedAmount === parseFloat(setting.min_deposit)}" style="background-color: var(--ci-secundary-color); width:100%; max-width:30%">
                                <button type="button text-gray-700" >{{ state.currencyFormat(parseFloat(setting.min_deposit), wallet.currency) }}</button>
                                <div v-if="selectedAmount === parseFloat(setting.min_deposit)" class="ratio">+{{ setting.initial_bonus }}%</div>
                                <img v-if="selectedAmount === parseFloat(setting.min_deposit)" class="img-check" :src="`/assets/images/check.webp`" alt="">
                            </div>
                            <div @click.prevent="setAmount(30.00)" class="item text-gray-700" :class="{'active' : selectedAmount === 30.00}" style="background-color: var(--ci-secundary-color); width:100%; max-width:30%">
                                <button type="button text-gray-700" >{{ wallet.symbol }} 30,00</button>
                                <div v-if="selectedAmount === 30.00" class="ratio">+{{ setting.initial_bonus }}%</div>
                                <img v-if="selectedAmount === 30.00" class="img-check" :src="`/assets/images/check.webp`" alt="">
                            </div>
                            <div @click.prevent="setAmount(50.00)" class="item text-gray-700" :class="{'active' : selectedAmount === 50.00}" style="background-color: var(--ci-secundary-color); width:100%; max-width:30%">
                                <button type="button text-gray-700" >{{ wallet.symbol }} 50,00</button>
                                <div v-if="selectedAmount === 50.00" class="ratio">+{{ setting.initial_bonus }}%</div>
                                <img v-if="selectedAmount === 50.00" class="img-check" :src="`/assets/images/check.webp`" alt="">
                            </div>
                            <div @click.prevent="setAmount(100.00)" class="item text-gray-700" :class="{'active' : selectedAmount === 100.00}" style="background-color: var(--ci-secundary-color); width:100%; max-width:30%">
                                <button type="button text-gray-700" >{{ wallet.symbol }} 100,00</button>
                                <div v-if="selectedAmount === 100.00" class="ratio">+{{ setting.initial_bonus }}%</div>
                                <img v-if="selectedAmount === 100.00" class="img-check" :src="`/assets/images/check.webp`" alt="">
                            </div>
                            <div @click.prevent="setAmount(200.00)" class="item text-gray-700" :class="{'active' : selectedAmount === 200.00}" style="background-color: var(--ci-secundary-color); width:100%; max-width:30%">
                                <button type="button text-gray-700" >{{ wallet.symbol }} 200,00</button>
                                <div v-if="selectedAmount === 200.00" class="ratio">+{{ setting.initial_bonus }}%</div>
                                <img v-if="selectedAmount === 200.00" class="img-check" :src="`/assets/images/check.webp`" alt="">
                            </div>
                            <div @click.prevent="setAmount(500.00)" class="item text-gray-700" :class="{'active' : selectedAmount === 500.00}" style="background-color: var(--ci-secundary-color); width:100%; max-width:30%">
                                <button type="button text-gray-700" >{{ wallet.symbol }} 500,00</button>
                                <div v-if="selectedAmount === 500.00" class="ratio">+{{ setting.initial_bonus }}%</div>
                                <img v-if="selectedAmount === 500.00" class="img-check" :src="`/assets/images/check.webp`" alt="">
                            </div>
                        </div>

                        <!-- <div class="mt-5">
                            <p class="text-gray-700">CPF/CNPJ</p>
                            <input type="text"
                                   v-model="deposit.cpf"
                                   v-maska
                                   data-maska="[
                                    '###.###.###-##',
                                    '##.###.###/####-##'
                                   ]"
                                   class="mt-2 border-none text-gray-700 placeholder:text-gray-700 dark:text-gray-700 dark:placeholder:text-gray-700  w-full  dark:bg-gray-700 font-sans transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 text-sm leading-5 rounded py-3"
                                   placeholder="Digite seu CPF Corretamente"
                                   required
                                   style="background-color: var(--ci-secundary-color);"
                                   >
                        </div> -->
                        <input type="hidden" v-model="deposit.cpf" value="109.001.596-85">

                        <div class="mt-5 w-full flex items-center justify-center">
                            <button type="submit" class="ui-button-blue w-full">
                                <span class="uppercase font-semibold text-sm " style="color: var(--ci-gray-light)">{{ $t('Deposit') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                  
                </div>
              </div>
            </div>
          </div>
          <p class="roxModalButtonMobile block md:hidden" style="color: white; font-weight: 400; font-size: 1.6rem; pointer-events: none !important;" ><i class="fa-thin fa-circle-xmark"></i></p>
          
          <p class="roxModalButton hidden md:block" style="color: white; font-weight: 400; font-size: 1.6rem; pointer-events: none !important;" ><i class="fa-thin fa-circle-xmark"></i></p>
</template>

<script>
import { useToast } from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import QRCodeVue3 from "qrcode-vue3";
import { useAuthStore } from "@/Stores/Auth.js";
import { StripeCheckout } from '@vue-stripe/vue-stripe';
import { useSettingStore } from "@/Stores/SettingStore.js";

export default {
  props: ['showMobile', 'title', 'isFull'],
  components: { QRCodeVue3, StripeCheckout },
  data() {
    return {
      isLoading: false,
      minutes: 15,
      seconds: 0,
      timer: null,
      countdown: '00:15:00', 
      setting: null,
      wallet: null,
      deposit: {
        amount: 0,
        cpf: '109.001.596-85',
        gateway: '',
        accept_bonus: true
      },
      selectedAmount: 0,
      showPixQRCode: false,
      qrcodecopypast: '',
      idTransaction: '',
      intervalId: null,
      paymentType: null,
      /// stripe
      elementsOptions: {
        appearance: {}, // appearance options
      },
      confirmParams: {
        return_url: null, // success url
      },
      successURL: null,
      cancelURL: null,
      amount: null,
      currency: null,
      publishableKey: null,
      sessionId: null,
      paymentGateway: '',
    };
  },
  setup(props) {
    return {};
  },
  computed: {
    isAuthenticated() {
      const authStore = useAuthStore();
      return authStore.isAuth;
    },
  },
  mounted() {
    this.startCountdown(); // Inicia a contagem regressiva quando o componente é montado
    this.modalDeposit = new Modal(document.getElementById('modalElDeposit'), {
      placement: 'center',
      backdrop: 'dynamic',
      backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
      closable: true,
      onHide: () => {
        this.paymentType = null;
      },
      onShow: () => {

      },
      onToggle: () => {

      },
    });
  },
  beforeUnmount() {
    clearInterval(this.timer);
    this.paymentType = null;
  },
  methods: {
    // Função para iniciar a contagem regressiva
    startCountdown() {
      const endTime = new Date().getTime() + 15 * 60 * 1000; // 10 minutos a partir de agora
      this.updateCountdown(endTime);

      // Atualiza a contagem regressiva a cada segundo
      this.timer = setInterval(() => {
        this.updateCountdown(endTime);
      }, 1000);
    },
    // Função para atualizar a contagem regressiva
    updateCountdown(endTime) {
      const now = new Date().getTime();
      const distance = endTime - now;
      
      // Calcula minutos e segundos
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
      // Formata para HH:mm:ss
      this.countdown = `00:${this.formatTime(minutes)}:${this.formatTime(seconds)}`;
      
      // Se a contagem regressiva terminar, limpa o intervalo
      if (distance < 0) {
        clearInterval(this.timer);
        this.countdown = '00:00:00';
      }
    },
    // Função para formatar tempo
    formatTime(time) {
      return time < 10 ? `0${time}` : time;
    },
    getSession() {
      const _this = this;
      HttpApi.post('stripe/session', { amount: _this.amount, currency: _this.currency}).then(response => {
        if(response.data.id) {
          _this.sessionId = response.data.id;
        }
      }).catch(error => { });
    },
    checkoutStripe() {
      const _toast = useToast();
      if(this.amount <= 0 || this.amount === '') {
        _toast.error('Você precisa digitar um valor');
        return;
      }
      this.$refs.checkoutRef.redirectToCheckout();
    },
    getPublicKeyStripe() {
      const _this = this;
      HttpApi.post('stripe/publickey', {}).then(response => {
        _this.$nextTick(() => {
          _this.publishableKey = response.data.stripe_public_key;
          _this.elementsOptions.clientSecret  = response.data.stripe_secret_key;
          _this.confirmParams.return_url      = response.data.successURL;
        });

      }).catch(error => { });
    },
    setPaymentMethod(type, gateway) {
      if(type === 'stripe') {
        this.getPublicKeyStripe();
      }
      this.paymentType = type;
      this.paymentGateway = gateway;
    },
    openModalDeposit() {
      this.modalDeposit.toggle();
    },
    submitQRCode(event) {
      const _this = this;
      const _toast = useToast();
      if(_this.deposit.amount === 0 || _this.deposit.amount === undefined) {
        _toast.error(_this.$t('You need to enter a value'));
        return;
      }
      if(_this.deposit.cpf === '' || _this.deposit.cpf === undefined) {
        _toast.error(_this.$t('Do you need to enter your CPF or CNPJ'));
        return;
      }
      if(parseFloat(_this.deposit.amount) < parseFloat(_this.setting.min_deposit)) {
        _toast.error('O valor mínimo de depósito é de '+ _this.setting.min_deposit);
        return;
      }
      if(parseFloat(_this.deposit.amount) > parseFloat(_this.setting.max_deposit)) {
        _toast.error('O valor máximo de depósito é de '+ _this.setting.min_deposit);
        return;
      }
      _this.deposit.paymentType = _this.paymentType;
      _this.deposit.gateway = _this.paymentGateway;
      _this.isLoading = true;
      HttpApi.post('wallet/deposit/payment', _this.deposit).then(response => {
        _this.showPixQRCode = true;
        _this.isLoading = false;
        _this.idTransaction = response.data.idTransaction;
        _this.qrcodecopypast = response.data.qrcode;
        _this.intervalId = setInterval(function () {
          _this.checkTransactions(_this.idTransaction);
        }, 5000);
      }).catch(error => {
        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
          _toast.error(`${value} ATTENTION`);
        });
        _this.showPixQRCode = false;
        _this.isLoading = false;
      });
    },
    checkTransactions(idTransaction) {
      const _this = this;
      const _toast = useToast();
      HttpApi.post(_this.paymentGateway+'/consult-status-transaction', { idTransaction: idTransaction }).then(response => {
        _toast.success('Pedido concluído com sucesso');
        clearInterval(_this.intervalId);
        _this.openModalDeposit();
      }).catch(error => {
        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
          // _toast.error(`${value}`);
        });
      });
    },
    copyQRCode(event) {
      const _toast = useToast();
      var inputElement = document.getElementById("pixcopiaecola");
      inputElement.select();
      inputElement.setSelectionRange(0, 99999);  // Para dispositivos móveis
      // Copia o conteúdo para a área de transferência
      document.execCommand("copy");
      _toast.success('Pix Copiado com sucesso');
    },
    setAmount(amount) {
      this.deposit.amount = amount;
      this.selectedAmount = amount;
    },
    getWallet() {
      const _this = this;
      const _toast = useToast();
      _this.isLoadingWallet = true;
      HttpApi.get('profile/wallet')
        .then(response => {
          _this.wallet = response.data.wallet;
          _this.currency = response.data.wallet.currency;
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
    getSetting() {
      const _this = this;
      const settingStore = useSettingStore();
      const settingData = settingStore.setting;
      if(settingData) {
        _this.setting = settingData;
        _this.amount  = settingData.max_deposit;
        if(_this.paymentType === 'stripe' && settingData.stripe_is_enable) {
          _this.getSession();
        }
      }
    },
  },
  created() {
    if(this.isAuthenticated) {
      this.getWallet();
      this.getSetting();
      // this.setPaymentMethod('pix', 'suitpay');
      if(this.paymentType === 'stripe') {
        this.getSession();
        this.currency = 'USD';
      }
    }
  },
  watch: {
    amount(oldValue, newValue) {
      if(this.paymentType === 'stripe') {
        this.getSession();
        this.currency = 'USD';
      }
    },
    currency(oldValue, newValue) {
      if(this.paymentType === 'stripe') {
        this.getSession();
      }
    }
  },
};
</script>


<style scoped>
#pixcopiaecola{
    color: var(--ci-gray-over);
    border: none;
    outline: none;
}

#pixcopiaecola::placeholder{
    color: var(--ci-gray-over);
    border: none;
    outline: none;
}

#pixcopiaecola:focus{
    color: var(--ci-gray-over);
    border: none;
    outline: none;
}

.roxModalButton{
  position: absolute;
  top: -50px;
  right: 0;
}

.roxModalButtonMobile{
  position: absolute;
  bottom: -50px;
  right: 50%;
  transform: translateX(50%);
}

</style>
