<template>
  
  <div class="block">
   
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

          <button :disabled="!sessionId" @click.prevent="checkoutStripe" class="ui-button-blue rounded w-full">Pagar com Stripe</button>
      </div>

      <div v-if="setting && (setting.suitpay_is_enable || setting.mercadopago_is_enable || setting.digitopay_is_enable)">
          <div v-if="showPixQRCode && wallet" class="flex flex-col ">
              <!-- <div class="w-full p-3 md:p-4 mb-2" style="background-color: var(--ci-primary-opacity-color);">
                  <div class="flex justify-between">
                      <h2 class="text-lg md:text-2xl" style="color: var(--ci-gray-light)">BÔNUS EXPIRA EM:</h2>
                      <div class="text-lg md:text-2xl">
                          <p>{{countdown}}</p>
                      </div>
                  </div>
              </div> -->



              <div class="w-full overflow-y-scroll md:overflow-y-auto h-screen md:h-[50%]">
                  <div>
                      <p class="font-bold w-full text-center text-base mb-1" style="color: var(--ci-gray-light) !important">{{ state.currencyFormat(parseFloat(deposit.amount), wallet.currency) }}</p>
                  </div>
                  <div class="flex justify-center items-center w-full">
                      <!-- <QRCodeVue3 :value="qrcodecopypast"/> -->
                      <div class="bg-white p-4 qrCodePix" @mousedown.prevent @contextmenu.prevent @dragstart.prevent>
                        <div class="qrCodeContainer" @mousedown.prevent @contextmenu.prevent @dragstart.prevent>
                          <QRCode :value="qrcodecopypast" :size="`200`" :level="'H'" :bgColor="'#ffffff'" :fgColor="'var(--ci-primary-opacity-color)'" />
                          <img class="qrCodeLogo" src="https://altenarweb.com/qr.gif" alt="Logo" @mousedown.prevent @contextmenu.prevent @dragstart.prevent>
                        </div>
                      </div>

                  </div>
                  
                  <div class="mt-2">
                    <p class="mb-3 text-sm text-center font-bold">Código válido por 5 minutos.</p>
                      <p class="mb-3 text-sm text-center">Se preferir, você pode pagá-lo copiando o código abaixo:</p>
                      <input id="pixcopiaecola" type="text" class="input2 text-[var(--ci-gray-light)]" v-model="qrcodecopypast" style="background-color: var(--ci-primary-color); color: var(--ci-gray-light); border: 1px solid var(--ci-secundary-color);">
                  </div>

                  <div class="mt-5 w-full flex items-center justify-center">
                      <button @click.prevent="copyQRCode" type="button" class="ui-button-form w-full rounded-lg">
                          <span class="font-semibold text-sm rounded-lg"><i class="fa-light fa-copy"></i> COPIAR CÓDIGO</span>
                      </button>
                  </div>

                  <div class="w-full text-center justify-center items-center mt-2 mb-3">
                    <img :src="`/storage/rox/pix.png`" alt="" width="140" class="m-auto">
                  </div>

                  <ul class="py-4 list-disc px-4 border-t border-[var(--ci-gray-light)] text-sm"><li>Abra seu aplicativo de pagamento e digitalize ou copie e cole o código QR abaixo para concluir sua compra;</li><li>Este código QR só pode ser pago uma vez. Se precisar pagar novamente, volte e recarregue;</li><li class="text-primary">Após o pagamento ser bem-sucedido, você pode retornar ao lobby do jogo e aguardar a adição de pontos!</li></ul>
              </div>
          </div>
          <div v-if="!showPixQRCode">
              <div v-if="setting != null && wallet != null && isLoading === false" class="flex flex-col w-full">
                  <form action="" @submit.prevent="submitQRCode">
                      <div class="w-full flex justify-start items-center border-b border-[var(--ci-secundary-color)]">
                        <div class="flex gap-2 items-center text-[var(--sub-text-color)] pb-1 px-1 border-b-2 border-[var(--ci-primary-opacity-color)] relative bottom-[-2px]">
                          <i class="fa-solid fa-mobile-screen-button"></i>
                          <p class="text-xs md:text-sm">Depósito-online</p>
                        </div>
                      </div>

                      <div class="w-full my-2">
                        <div class="flex w-24 p-1 gap-2 justify-between items-center border border-[var(--sub-text-color)] rounded-md relative">
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent :src="`/storage/rox/pix.jpg`" width="25" class="rounded-md"/>
                          <p class="text-center text-xs text-white pr-4">PIX</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="true" class="img-checked absolute bottom-0 right-0" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>
                      </div>

                      <div class="w-full flex justify-start items-center border-b border-[var(--ci-secundary-color)]"></div>
                      
                      <div class="w-full my-2 grid gap-2 grid-cols-3 md:grid-cols-4">
                        <div 
                          v-if="setting.suitpay_is_enable" 
                          @click="setPaymentMethod('pix', 'suitpay')" 
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': paymentGateway !== 'suitpay',
                            'border-[var(--sub-text-color)]': paymentGateway === 'suitpay'
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">PIX (Quente)</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="paymentGateway === 'suitpay'" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          v-if="setting.digitopay_is_enable" 
                          @click="setPaymentMethod('pix', 'digitopay')" 
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': paymentGateway !== 'digitopay',
                            'border-[var(--sub-text-color)]': paymentGateway === 'digitopay'
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">PIX (Quente)</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="paymentGateway === 'digitopay'" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          v-if="setting.mercadopago_is_enable" 
                          @click="setPaymentMethod('pix', 'mercadopago')" 
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': paymentGateway !== 'mercadopago',
                            'border-[var(--sub-text-color)]': paymentGateway === 'mercadopago'
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">PIX (Quente)</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="paymentGateway === 'mercadopago'" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          v-if="setting.sharkpay_is_enable" 
                          @click="setPaymentMethod('pix', 'sharkpay')" 
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': paymentGateway !== 'sharkpay',
                            'border-[var(--sub-text-color)]': paymentGateway === 'sharkpay'
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">PIX (Quente)</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="paymentGateway === 'sharkpay'" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          v-if="setting.stripe_is_enable" 
                          @click="setPaymentMethod('stripe', 'stripe')" 
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': paymentGateway !== 'stripe',
                            'border-[var(--sub-text-color)]': paymentGateway === 'stripe'
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">STRIPE</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="paymentGateway === 'stripe'" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>
                      </div>

                      <div class="w-full flex justify-start items-center border-b border-[var(--ci-secundary-color)]"></div> 

                      

                      <div class="w-full flex justify-start items-center border-b border-[var(--ci-secundary-color)]"></div> 

                      <span class="text-[var(--ci-secundary-color)] text-left mt-4 text-xs">Depósito</span>
                      <div class="w-full mb-2 grid gap-2 grid-cols-4 md:grid-cols-4">

                        <div 
                          @click.prevent="setAmount(parseFloat(setting.min_deposit))"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== parseFloat(setting.min_deposit),
                            'border-[var(--sub-text-color)]': selectedAmount === parseFloat(setting.min_deposit)
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">{{parseFloat(setting.min_deposit)}}</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === parseFloat(setting.min_deposit)" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          @click.prevent="setAmount(30.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 30.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 30.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">30</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 30.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          @click.prevent="setAmount(50.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 50.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 50.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">50</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 50.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>
                        
                        <div 
                          @click.prevent="setAmount(100.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 100.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 100.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">100</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 100.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          @click.prevent="setAmount(500.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 500.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 500.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">500</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 500.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          @click.prevent="setAmount(1000.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 1000.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 1000.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">1000</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 1000.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          @click.prevent="setAmount(5000.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 5000.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 5000.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">5000</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 5000.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>

                        <div 
                          @click.prevent="setAmount(10000.00)"
                          :class="{
                            'cursor-pointer flex p-2 justify-between items-center border rounded-md relative': true,
                            'border-[var(--ci-secundary-color)]': selectedAmount !== 10000.00,
                            'border-[var(--sub-text-color)]': selectedAmount === 10000.00
                          }"
                        >
                          <p class="w-full text-center text-xs text-white">10000</p>
                          <img @mousedown.prevent @contextmenu.prevent @dragstart.prevent v-if="selectedAmount === 10000.00" class="img-checked absolute bottom-2 right-2" :src="`/assets/images/check.webp`" alt="check" width="20"/>
                        </div>
                         
                      </div>
                      <div class="mt-3">
                        <div class="w-full flex items-center justify-between rounded py-1" style="background-color: transparent; border: 1px solid var(--ci-secundary-color);">
                          
                        <div class="flex w-full relative">
                          <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-white dark:text-white">
                            R$
                          </div>
                          <input type="number"
                                v-model="deposit.amount"
                                class="appearance-none border rounded-md bg-transparent border-none w-[95%] pl-6 ml-2 text-white placeholder:text-[var(--ci-secundary-color)]  dark:placeholder:text-[var(--ci-secundary-color)]"
                                :min="setting.min_deposit"
                                :max="setting.max_deposit"
                                :placeholder="`Mínimo {{parseFloat(setting.min_deposit)}}, Máximo {{parseFloat(setting.max_deposit)}}`"
                                required
                                style="padding-left: 2.5rem;">
                        </div>
                        </div>
                        </div>
                     
                     
                      <input type="hidden" v-model="deposit.cpf" value="412.780.130-16">

                      <div class="mt-5 w-full flex items-center justify-center rounded-lg">
                          <button type="submit" class="ui-button-form w-full">
                              <span class="rounded-lg font-semibold text-sm " style="color: var(--ci-gray-light)">Recarregue Agora</span>
                          </button>
                      </div>
                  </form>
              </div>
              <div v-if="isLoading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                
              </div>
            </div>
          </div>
        </div>
        <!-- <p @click="toggleModalDeposit" class="roxModalButtonMobile block md:hidden" style="color: white; font-weight: 400; font-size: 1.6rem; pointer-events: none !important;" ><i class="fa-thin fa-circle-xmark"></i></p> -->
        
        <div v-if="copyAlert" class="fixed-button">
                        <span><i class="fa-solid fa-circle-check text-[#4CAF50]"></i> Copiado com sucesso!</span>
                    </div>

        <p  @click="toggleModalDeposit" class="roxModalButton hidden md:block" style="color: white; font-weight: 400; font-size: 1.6rem; pointer-events: none !important;" ><i class="fa-thin fa-circle-xmark"></i></p>
</template>

<script>
import { useToast } from "vue-toastification";
import HttpApi from "@/Services/HttpApi.js";
import QRCodeVue3 from "qrcode-vue3";
import { useAuthStore } from "@/Stores/Auth.js";
import { StripeCheckout } from '@vue-stripe/vue-stripe';
import { useSettingStore } from "@/Stores/SettingStore.js";
import QRCode from 'qrcode.vue';

export default {
  props: ['showMobile', 'title', 'isFull'],
  components: { QRCodeVue3, QRCode, StripeCheckout },
  data() {
    return {
      copyAlert: false,
      isLoading: false,
      minutes: 15,
      seconds: 0,
      timer: null,
      countdown: '00:15:00', 
      setting: null,
      wallet: null,
      deposit: {
        amount: 0,
        cpf: '412.780.130-16',
        gateway: '',
        accept_bonus: true
      },
      selectedAmount: 0,
      showPixQRCode: false,
      qrcodecopypast: '',
      idTransaction: '',
      intervalId: null,
      paymentType: 'pix',
      elementsOptions: {
        appearance: {},
      },
      confirmParams: {
        return_url: null,
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
      onShow: () => {},
      onToggle: () => {},
    });
    if (window.location.href.includes("deposit")) {
      this.openModalDeposit();
    }

    this.checkPaymentGateway();
  },
  beforeUnmount() {
    clearInterval(this.timer);
    this.paymentType = null;
  },
  methods: {
    checkPaymentGateway() {
      if (this.setting) {
        if (this.setting.suitpay_is_enable) {
          this.paymentGateway = 'suitpay';
        } else if (this.setting.digitopay_is_enable) {
          this.paymentGateway = 'digitopay';
        } else if (this.setting.mercadopago_is_enable) {
          this.paymentGateway = 'mercadopago';
        } else if (this.setting.sharkpay_is_enable) {
          this.paymentGateway = 'sharkpay';
        }
      }
    },
    startCountdown() {
      const endTime = new Date().getTime() + 15 * 60 * 1000;
      this.updateCountdown(endTime);

      this.timer = setInterval(() => {
        this.updateCountdown(endTime);
      }, 1000);
    },
    updateCountdown(endTime) {
      const now = new Date().getTime();
      const distance = endTime - now;
      
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
      this.countdown = `00:${this.formatTime(minutes)}:${this.formatTime(seconds)}`;
      
      if (distance < 0) {
        clearInterval(this.timer);
        this.countdown = '00:00:00';
      }
    },
    formatTime(time) {
      return time < 10 ? `0${time}` : time;
    },
    getSession() {
      HttpApi.post('stripe/session', { amount: this.amount, currency: this.currency }).then(response => {
        if(response.data.id) {
          this.sessionId = response.data.id;
        }
      }).catch(error => { });
    },
    checkoutStripe() {
      const _toast = useToast();
      if (this.amount <= 0 || this.amount === '') {
        _toast.error('Você precisa digitar um valor');
        return;
      }
      this.$refs.checkoutRef.redirectToCheckout();
    },
    getPublicKeyStripe() {
      HttpApi.post('stripe/publickey', {}).then(response => {
        this.$nextTick(() => {
          this.publishableKey = response.data.stripe_public_key;
          this.elementsOptions.clientSecret = response.data.stripe_secret_key;
          this.confirmParams.return_url = response.data.successURL;
        });
      }).catch(error => { });
    },
    setPaymentMethod(type, gateway) {
      if (type === 'stripe') {
        this.getPublicKeyStripe();
      }
      this.paymentType = type;
      this.paymentGateway = gateway;
    },
    openModalDeposit() {
      this.modalDeposit.toggle();
    },
    submitQRCode(event) {
      const _toast = useToast();
      if (this.deposit.amount === 0 || this.deposit.amount === undefined) {
        _toast.error(this.$t('You need to enter a value'));
        return;
      }
      if (this.deposit.cpf === '' || this.deposit.cpf === undefined) {
        _toast.error(this.$t('Do you need to enter your CPF or CNPJ'));
        return;
      }
      if (parseFloat(this.deposit.amount) < parseFloat(this.setting.min_deposit)) {
        _toast.error('O valor mínimo de depósito é de ' + this.setting.min_deposit);
        return;
      }
      if (parseFloat(this.deposit.amount) > parseFloat(this.setting.max_deposit)) {
        _toast.error('O valor máximo de depósito é de ' + this.setting.min_deposit);
        return;
      }
      this.deposit.paymentType = this.paymentType;
      this.deposit.gateway = this.paymentGateway;
      this.isLoading = true;
      HttpApi.post('wallet/deposit/payment', this.deposit).then(response => {
        this.showPixQRCode = true;
        this.isLoading = false;
        this.idTransaction = response.data.idTransaction;
        this.qrcodecopypast = response.data.qrcode;
        this.intervalId = setInterval(() => {
          this.checkTransactions(this.idTransaction);
        }, 5000);
      }).catch(error => {
        Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
          _toast.error(`${value} ATTENTION`);
        });
        this.showPixQRCode = false;
        this.isLoading = false;
      });
    },
    checkTransactions(idTransaction) {
      const _toast = useToast();
      HttpApi.post(this.paymentGateway + '/consult-status-transaction', { idTransaction }).then(response => {
        _toast.success('Pedido concluído com sucesso');
        clearInterval(this.intervalId);
        this.openModalDeposit();
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
      inputElement.setSelectionRange(0, 99999);
      document.execCommand("copy");
      this.copyAlert= true;
      setTimeout(() => {
        this.copyAlert = false;
      }
      , 3500);
    },
    setAmount(amount) {
      this.deposit.amount = amount;
      this.selectedAmount = amount;
    },
    getWallet() {
      const _toast = useToast();
      this.isLoadingWallet = true;
      HttpApi.get('profile/wallet')
        .then(response => {
          console.log(response)
          this.wallet = response.data.wallet;
          this.currency = response.data.wallet.currency;
          this.isLoadingWallet = false;
        })
        .catch(error => {
          Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
            _toast.error(`${value}`);
          });
          this.isLoadingWallet = false;
        });
    },
    getSetting() {
      const settingStore = useSettingStore();
      const settingData = settingStore.setting;
      if (settingData) {
        this.setting = settingData;
        this.checkPaymentGateway();
        this.amount = settingData.max_deposit;
        if (this.paymentType === 'stripe' && settingData.stripe_is_enable) {
          this.getSession();
        }
      }
    },
  },
  created() {
    if (this.isAuthenticated) {
      this.getWallet();
      this.getSetting();
      this.checkPaymentGateway();
      if (this.paymentType === 'stripe') {
        this.getSession();
        this.currency = 'USD';
      }
    }
  },
  watch: {
    amount(oldValue, newValue) {
      if (this.paymentType === 'stripe') {
        this.getSession();
        this.currency = 'USD';
      }
    },
    currency(oldValue, newValue) {
      if (this.paymentType === 'stripe') {
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

.img-checked {
    position: absolute;
    right: 0;
    width: 20px;
    bottom: 0;
    border-radius: 0 0 4px 0;
}

.fixed-button {
  position: fixed;
  bottom: 50%;
  left: 50%;
  transform: translateX(-50%);
  width: 80%;
  max-width: 300px;
  padding: 10px 20px;
  text-align: center;
  background-color: #ffffff; /* Cor de fundo do botão */
  border: 1px solid var(--ci-primary-color);
  color: var(--ci-primary-opacity-color); /* Cor do texto */
  border-radius: 5px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.4);
  font-size: 1.1em;
}

.qrCodePix {
  position: relative;
  display: inline-block;
}

.qrCodeContainer {
  position: relative;
  width: 200px; /* Ajuste conforme necessário */
  height: 200px; /* Ajuste conforme necessário */
}

.qrCodeLogo {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 50px; /* Ajuste o tamanho da logo conforme necessário */
  height: 50px; /* Ajuste o tamanho da logo conforme necessário */
  border-radius: 50%; /* Opcional: para bordas arredondadas */
  object-fit: cover; /* Para ajustar o tamanho da imagem */
}
</style>
