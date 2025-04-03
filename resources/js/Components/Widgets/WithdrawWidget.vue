<template>
  <div class="md:w-4/6 2xl:w-4/6 mx-auto p-4 mt-20">
      <div class="w-full max-w-4xl flex justify-center">
          <div class="col-span-2 relative">
              <div class="flex flex-col w-full shadow-lg  p-4 rounded-lg" style="background-color: var(--ci-primary-color);">
                  <form action="" @submit.prevent="submitWithdraw">
                      <h2 style="font-size: 1.3rem; width: 100%; text-align: center;">Saque</h2>
                      <div class="mt-5">
                          <div class=" mb-3" style="color:var(--ci-gray-light)">
                              <label for="">Nome do titular da conta</label>
                              <input v-model="withdraw.name" type="text" class="input" placeholder="Digite o nome do titular da conta" required style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);  border: 1px solid var(--ci-secundary-color);">
                          </div>
                          <div class=" mb-3" style="color:var(--ci-gray-light)">
                              <label for="">Tipo de Chave</label>
                              <select v-model="withdraw.pix_type" name="type_document" class="input" required style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);  border: 1px solid var(--ci-secundary-color);">
                                  <option value="" style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);">Selecione uma chave</option>
                                  <option value="document" style="color: var (--ci-gray-dark); background-color: var(--ci-secundary-color);">CPF/CNPJ</option>
                                  <option value="email" style="color: var (--ci-gray-dark); background-color: var(--ci-secundary-color);">E-mail</option>
                                  <option value="phoneNumber" style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);">Telefone</option>
                                  <option value="randomKey" style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color); ">Chave Aleatória</option>
                              </select>
                          </div>
                          <div class=" mb-3" style="color:var(--ci-gray-light)">
                              <label for="">Chave Pix</label>
                              <input v-model="withdraw.pix_key" type="text" class="input" placeholder="Digite a sua Chave pix" required style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);  border: 1px solid var(--ci-secundary-color);">
                          </div>
                          <div class=" mb-3" style="color:var(--ci-gray-medium)">
                              <div class="flex justify-between mb-3">
                                  <p>Valor mínimo:{{ state.currencyFormat(parseFloat(setting.min_withdrawal), wallet.currency) }} </p>
                                  <!-- <p>Saldo: {{ state.currencyFormat(parseFloat(wallet.balance), wallet.currency) }}</p> -->
                              </div>
                              <div class="flex  " style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color);">
                                  <input type="text"
                                         class="input rounded"
                                         v-model="withdraw.amount"
                                         :min="setting.min_withdrawal"
                                         :max="setting.max_withdrawal"
                                         placeholder=""
                                         required style="color: var(--ci-gray-dark); background-color: var(--ci-secundary-color); border: 1px solid var(--ci-secundary-color);">
                              </div>
                              <div class="flex justify-between mt-2" style="color:var(--ci-gray-medium)">
                                  <p>Saldo Disponível: {{ state.currencyFormat(parseFloat(wallet.balance), wallet.currency) }} {{ wallet.currency }}</p>
                              </div>
                          </div>
                          <div class="mb-3 mt-5">
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
                      <div class="mt-5 w-full flex items-center justify-center rounded">
                          <button type="submit" class="ui-button-blue w-full rounded">
                              <span class="uppercase font-semibold text-sm rounded">Realizar Saque</span>
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import {useRouter} from "vue-router";
import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";
import {useSettingStore} from "@/Stores/SettingStore.js";

export default {
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
  setup() {
      const router = useRouter();
      return { router };
  },
  methods: {
      setMinAmount() {
          this.withdraw.amount = this.setting.min_withdrawal;
      },
      setMaxAmount() {
          this.withdraw.amount = this.setting.max_withdrawal;
      },
      setPercentAmount(percent) {
          this.withdraw.amount = (percent / 100) * this.wallet.balance;
      },
      getWallet() {
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

          if (settingData) {
              _this.setting = settingData;
              _this.withdraw.amount = settingData.min_withdrawal;
              _this.withdraw_deposit.amount = settingData.min_withdrawal;
          }

          _this.isLoading = false;
      },
      submitWithdraw() {
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

              _this.router.push({ name: 'profileTransactions' });
              // _toast.success(response.data.message);
          }).catch(error => {
              Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                  // _toast.error(`${value}`);
              });
              _this.isLoading = false;
          });
      }
  },
  created() {
      this.getWallet();
      this.getSetting();
  }
};
</script>

<style scoped>
/* Adicione estilos necessários aqui */
</style>
