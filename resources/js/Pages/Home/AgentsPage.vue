<template>
   
        <div id="roxAgentHeader" class="w-full flex justify-between p-4 items-center" style="background-color: var(--ci-primary-color); border-bottom: 1px solid var(--ci-secundary-color);">
            <div><i class="fa-solid fa-chevron-left cursor-pointer"></i></div>
            <div><p class="text-2xl">Convidar</p></div>
            <div><p></p></div>
        </div>

        <nav id="roxAgentNav" class="w-full py-4 pb-0" style="border-bottom: 1px solid var(--ci-secundary-color);">
            <ul class="flex flex-row gap-4 overflow-scroll items-center justify-start font-medium">
                <li v-for="item in navItems" :key="item.id" :class="[isActive(item.id) ? 'active' : 'desactive', 'w-fit whitespace-nowrap pb-2 px-2']" @click="activateNav(item.id)">
                    {{ item.label }}
                </li>
            </ul>
        </nav>

        <div>
            <div class="flex flex-col gap-2" v-show="activeContent === 'convite'" id="divConvite">
                
            
                <div class="mx-4 my-4 flex flex-col rounded-lg" style="background-color: var(--ci-primary-color);">
                    <div class="w-full px-4 pb-4 flex justify-around align-top" style="border-bottom: 1px solid var(--ci-secundary-color);">
                        <img :src="`/storage/rox/1.png`" style="width: 80px; height: auto; object-fit: contain; position: relative; top: -20px;">
                        <div class="flex flex-col gap-2 py-4 text-base">
                            <div class="flex flex-row justify-between items-center">
                                <p>Coletável <span class="text-lg font-semibold" style="color: var(--ci-primary-opacity-color)">{{ wallet.refer_rewards }}</span></p>
                                <div class="flex gap-2">
                                    <div @click.prevent="opemModalWithdrawal" class="p-2" style="background-color: var(--ci-primary-opacity-color); color: white; border-radius: 8px; cursor:pointer;">Receber</div>
                                    <div class="p-2" style="background-color: var(--ci-primary-opacity-color); color: white; border-radius: 8px; cursor:pointer;">Histórico</div>
                                </div>
                            </div>
                            
                            <div class="flex flex-row justify-between items-center gap-4">
                                <p>Modo de Agente</p>
                                <p>Diferença de nível infinito (Liquidação diária)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row gap-2 p-2">
                        <div class="roxQrCode">
                            <div class="roxQr" ref="qrCodeContainer"></div>
                            <div @click="downloadQrCode">Clique para Salvar</div>
                        </div>

                        <div class="w-[90%] flex flex-col gap-1">
                            <p>Meu Link</p>
                            <div class="divLink rounded p-2 flex justify-between items-center w-full" style="border: 1px solid var(--ci-primary-opacity-color);">
                                <input class="w-[80%]" type="text" id="referencelink" :value="referencelink" readonly style="background-color: transparent; color: var(--ci-primary-opacity-color); border: none"/>
                                <button @click="copyLink"><i class="fa-regular fa-copy"></i></button>
                            </div>
                            <p>Subordinados diretos <span class="text-lg" style="color: var(--ci-primary-opacity-color)">{{ indications }}</span></p>
                            <p>Código de Convite <span id="referenceCode" style="color: var(--ci-primary-opacity-color)">{{ referencecode }}</span> <button @click="copyCode"><i class="fa-regular fa-copy"></i></button></p>
                        </div>
                    </div>


                    <div class="w-full flex gap-2 p-4">
                        <div class="my-scrollbar-wrap my-scrollbar-wrap-x">
                                <div class="my-scrollbar-content">
                                    
                                    <div
                                        class="flex gap-3 w-full justify-start items-center mt-4"
                                    >
                                        <div
                                            class="flex justify-center items-center"
                                        >
                                            <i
                                                class="fa-duotone fa-share-from-square"
                                                style="
                                                    font-size: 1.8rem;
                                                    color: var(--ci-gray-light);
                                                "
                                            ></i>
                                        </div>
                                        <div>
                                            <img
                                                data-groups-id="my-img-0027d45d-9ba0-440f-903d-3173d590fcf3"
                                                data-src-render="https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_tg.png"
                                                src="https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_tg.png"
                                                alt="Telegram"
                                                data-blur="0"
                                                data-status="loaded"
                                                class="goDRiiBsuEuXD3W1NphN"
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                "
                                            />
                                        </div>
                                        <div>
                                            <img
                                                data-groups-id="my-img-9d1154d7-a079-4ec5-b659-c5f6f62efb23"
                                                data-src-render="https://cdntoos.appskypg.com/agent/img/1793952079665582082.png"
                                                src="https://cdntoos.appskypg.com/agent/img/1793952079665582082.png"
                                                alt="Instagram"
                                                data-blur="0"
                                                data-status="loaded"
                                                class="goDRiiBsuEuXD3W1NphN"
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                "
                                            />
                                        </div>
                                        <div>
                                            <img
                                                data-groups-id="my-img-a54923ba-8d30-4b67-830b-338c3838b7d1"
                                                data-src-render="https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_wa.png"
                                                src="https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_wa.png"
                                                alt="WhatsApp"
                                                data-blur="0"
                                                data-status="loaded"
                                                class="goDRiiBsuEuXD3W1NphN"
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                "
                                            />
                                        </div>
                                        <div>
                                            <img
                                                data-groups-id="my-img-a8fc7b23-1136-4549-9820-9e54c4a82229"
                                                data-src-render="https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_facebook.png"
                                                src="https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_facebook.png"
                                                alt="Facebook"
                                                data-blur="0"
                                                data-status="loaded"
                                                class="goDRiiBsuEuXD3W1NphN"
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                "
                                            />
                                        </div>
                                        <div>
                                            <img
                                                data-groups-id="my-img-4eea860f-bf2c-4cce-8e9b-20e2f4474126"
                                                data-src-render="https://cdntoos.appskypg.com/agent/img/1793951943189524482.png"
                                                src="https://cdntoos.appskypg.com/agent/img/1793951943189524482.png"
                                                alt="youtube"
                                                data-blur="0"
                                                data-status="loaded"
                                                class="goDRiiBsuEuXD3W1NphN"
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                "
                                            />
                                        </div>
                                        <div>
                                            <img
                                                data-groups-id="my-img-8603ec5d-e94b-4981-bfc5-d7b8acc823ec"
                                                data-src-render="https://cdntoos.appskypg.com/agent/img/1793951839497940993.png"
                                                src="https://cdntoos.appskypg.com/agent/img/1793951839497940993.png"
                                                alt="Tiktok"
                                                data-blur="0"
                                                data-status="loaded"
                                                class="goDRiiBsuEuXD3W1NphN"
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div style="background-color: var(--ci-primary-color);">

                    <div style="background-color: var(--ci-primary-color);">
                        <img :src="`/storage/rox/agent_affiliate-preview.png`" class="w-full max-w-2xl p-2">
                    </div>
                    
                    <div class="flex flex-col justify-center p-6" style="">
                        <h1><strong>Um exemplo é o seguinte:</strong></h1>
                        <p>
                            Suponha que as apostas efetivas atuais de 0 a
                            10.000 receberão uma comissão de 100 (ou seja,
                            1%) para cada 10.000, e o apostas efetivas acima
                            de 10.000 receberão uma comissão de 300 para
                            cada 10.000. (ou seja, 3%), A foi o primeiro a
                                descobrir oportunidades de negócios neste site e
                                imediatamente desenvolveu B1, B2 e B3. B1
                                desenvolveu ainda mais C1 e C2. B2 desenvolveu
                                sem subordinados, e a B3 desenvolveu o
                                relativamente poderoso C3. No segundo dia, a
                                aposta efetiva de B1 é 500, a aposta efetiva de
                                B2 é 3.000, a aposta efetiva de B3 é 2.000, a
                                aposta efetiva de C1 é 1.000, a aposta efetiva
                                de C2 é 2.000 e a aposta efetiva de C3 é de até
                                20.000.
                            </p>
                            <span
                            >Então o método de cálculo da renda entre eles é
                            o seguinte:
                        </span>
                        <ul>
                            <li>
                                <strong>1. Comissão de B1</strong>
                                (contribuições diretas de C1 e C2) = (1000 +
                                2000) * 1% = <em>30</em>
                            </li>
                            <li>
                                <strong>2. Comissão de B2</strong> (sem
                                subordinados) = (0+0) * 1% = <em> 0</em>
                            </li>
                            <li>
                                <strong>3. Comissão B3</strong>
                                (contribuição direta de C3) = 20.000 * 3% =
                                <em>600</em>
                            </li>
                            <li>
                                <strong
                                >4. Além das contribuições dos
                                subordinados diretos B1, B2 e B3, a
                                comissão de A também advém das
                                contribuições dos demais subordinados
                                C1, C2 e C3, conforme segue:
                            </strong>
                            <ul>
                                        <li>
                                            <strong
                                                >( 1 )Comissão direta de
                                                A</strong
                                                >(contribuições diretas de B1, B2 e
                                                B3) = (500+3000+2000) * 3% =
                                                <em>165</em>
                                            </li>
                                            <li>
                                            <strong
                                            >( 2) Outras comissões de
                                            A</strong
                                            >(das contribuições C1,
                                            C2)=(1000+2000) * 2%= <em>60</em>
                                        </li>
                                        <li>
                                            <strong
                                            >(3)Comissão total de A </strong
                                            >(direto + outro) = 165+60 =
                                            <em>225</em>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <strong>5. Resumo: </strong>
                                    <ul>
                                        <li>
                                            <strong>(1) Equipe direta</strong>:
                                            refere-se aos subordinados
                                            desenvolvidos diretamente por A, ou
                                            seja, o primeiro nível de
                                            relacionamento com A, denominados
                                            coletivamente como equipe direta.
                                        </li>
                                        <li>
                                            <strong>(2) Outras equipes</strong>:
                                            Refere-se àquelas que são
                                            desenvolvidas por subordinados de A.
                                            Possuem relacionamento de segundo
                                            nível com A ou superior, ou seja,
                                            subordinados de subordinados , e os
                                            subordinados dos subordinados..
                                            etc., coletivamente referidos como
                                            outras equipes; como esse modelo de
                                            agência pode desenvolver
                                            subordinados ilimitados, para
                                            conveniência da explicação, este
                                            artigo toma apenas a estrutura de 2
                                            níveis como exemplo.
                                        </li>
                                        <li>
                                            <strong>(3) Descrição de A</strong>:
                                            O desempenho direto de A é 5.500 e o
                                            outro desempenho é 20.000 (devido ao
                                            poder de C3). O desempenho total é
                                            28.500 e a comissão correspondente a
                                            taxa é de 3%. Como B1 tem um
                                            desempenho total de 3.000 e desfruta
                                            de um desconto de apenas 1%,
                                            enquanto A tem um desempenho total
                                            de 28.500 e desfruta de uma taxa de
                                            desconto de 3%, então haverá uma
                                            diferença de desconto entre A e B1.
                                            A diferença é: 3% -1% =2%, essa
                                            diferença é a parte contribuída por
                                            C1 e C2 para A, então C1 e C2
                                            contribuem para A: (1000+2000)*
                                            2%=60, não há diferença extrema
                                            entre A e B3, então C3 contribui
                                            para A A comissão de contribuição é
                                            0.
                                        </li>
                                        <li>
                                            <strong>(4) Descrição de B1</strong
                                            >: B1 tem subordinados C1 e C2. Como
                                            o desempenho direto é 3.000, o
                                            índice de desconto correspondente é
                                            de 1%.
                                        </li>
                                        <li>
                                            <strong>(5) Explicação B2 </strong>:
                                            B2 pode ser preguiçoso e não se
                                            beneficiará se não desenvolver seus
                                            subordinados.
                                        </li>
                                        <li>
                                            <strong>(6) Explicação B3</strong>:
                                            Embora B3 tenha aderido
                                            relativamente tarde e seja
                                            subordinado de A, seu subordinado C3
                                            é muito poderoso e tem um desempenho
                                            direto de 20.000, permitindo que B3
                                            diretamente desfrutar de comissões
                                            mais elevadas.A proporção é de 3%.
                                        </li>
                                        <li>
                                            <strong
                                            >(7) Resumo das regras</strong
                                            >: Não importa quando você ingressa,
                                            de quem você é subordinado, não
                                            importa em que nível você está, sua
                                            renda nunca será afetada e você não
                                            sofre mais as perdas dos
                                            subordinados dos outros., o
                                            desenvolvimento não é restrito. Este
                                            é um modelo de agência absolutamente
                                            justo e imparcial, e ninguém estará
                                            sempre por baixo só porque entrou
                                            tarde.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                        
                    <div id="withdrawalEl" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg  shadow " style="background-color: var(--ci-primary-color);">

                    <!-- Modal header -->
                    <div class="flex justify-between p-4  rounded-t-lg w-full text-center" style="background-color: var(--ci-primary-opacity-color);">
                        <h1>Solicitação de saque</h1>
                        <!-- <button class="" @click.prevent="opemModalWithdrawal">
                            <i class="fa-solid fa-xmark"></i>
                        </button> -->
                    </div>

                    <!-- Modal body -->
                    <div class="flex flex-col  w-full justify-center p-4">
                        <form action="" @submit.prevent="makeWithdrawal">
                            <div class="mb-3" style="color: var(--ci-gray-dark)">
                                <label for="">Valor do Saque</label>
                                <input v-model="withdrawalForm.amount" type="number" class="input" placeholder="Valor do saque" required style="background-color: var(--ci-secundary-color); color: var(--ci-gray-dark)">
                                <span v-if="wallet" class="text-sm italic" style="color: var(--ci-primary-opacity-color);">Saldo: {{ state.currencyFormat(parseFloat(wallet?.refer_rewards), wallet?.currency) }}</span>
                            </div>

                            <div class=" mb-3" style="color: var(--ci-gray-dark)">
                                <label for="">Chave Pix</label>
                                <input v-model="withdrawalForm.pix_key" type="text" class="input" placeholder="Digite a sua Chave pix" required style="background-color: var(--ci-secundary-color); color: var(--ci-gray-dark)">
                            </div>

                            <div class=" mb-3" style="color: var(--ci-gray-dark)">
                                <label for="">Tipo de Chave</label>
                                <select v-model="withdrawalForm.pix_type" name="type_document" class="input" required style="background-color: var(--ci-secundary-color); color: var(--ci-gray-dark)">
                                    <option value="">Selecione uma chave</option>
                                    <option value="document">CPF/CNPJ</option>
                                    <option value="email">E-mail</option>
                                    <option value="phoneNumber">Telefone</option>
                                    <option value="randomKey">Chave Aleatória</option>
                                </select>
                            </div>

                            <button type="submit" class="mt-5 w-full text-white px-4 py-2 transition duration-700" style="background-color: var(--ci-primary-opacity-color);">
                                Solicitar agora
                            </button>
                            <p class="roxSaqueButtonMobile block md:hidden" @click.prevent="opemModalWithdrawal" style="color: white; font-weight: 400; font-size: 1.6rem; " ><i class="fa-thin fa-circle-xmark"></i></p>
          
                        <p class="roxSaqueButton hidden md:block" @click.prevent="opemModalWithdrawal" style="color: white; font-weight: 400; font-size: 1.6rem;" ><i class="fa-thin fa-circle-xmark"></i></p>

                        </form>
                    </div>
                </div>
            </div>
                    </div>
            </div>
            <div v-show="activeContent === 'recompensas'" id="divRecompensas">Conteúdo de Recompensas</div>
            <div v-show="activeContent === 'meusDados'" id="divMeusDados">Conteúdo de Meus Dados</div>
            <div v-show="activeContent === 'comissao'" id="divComissao">Conteúdo de Comissão</div>
            <div v-show="activeContent === 'desempenho'" id="divDesempenho">Conteúdo de Desempenho</div>
            <div v-show="activeContent === 'taxaBonus'" id="divTaxaBonus">Conteúdo de Taxa de Bônus do Agente</div>
        </div>
    
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { Modal } from "flowbite";
import HttpApi from "@/Services/HttpApi.js";
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/Stores/Auth.js";
import { useRouter } from "vue-router";


export default {
    components: { BaseLayout, Modal },
    data() {
        return {
            isLoading: true,
            referenceRewards: null,
            commissionRewards: null,
            isShowForm: false,
            code: "",
            urlCode: "",
            referencecode: "",
            referencelink: "",
            wallet: null,
            indications: 0,
            histories: null,
            withdrawalModal: null,
            withdrawalForm: {
                amount: 0,
                pix_key: "",
                pix_type: "",
            },
            activeContent: 'convite',
            navItems: [
                { id: 'convite', label: 'Link de Convite' },
                { id: 'recompensas', label: 'Recompensas' },
                { id: 'meusDados', label: 'Meus Dados' },
                { id: 'comissao', label: 'Comissão' },
                { id: 'desempenho', label: 'Desempenho' },
                { id: 'taxaBonus', label: 'Taxa de Bônus do Agente' }
            ]
        };
    },
    setup(props) {
        const router = useRouter();
        return {
            router,
        };
    },
    computed: {
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
    },
    mounted() {
        this.initializeModals();
       
    },
    methods: {
    
        initializeModals() {
            // Inicializa o modal de saque
            this.withdrawalModal = new Modal(
                document.getElementById("withdrawalEl"),
                {
                    placement: "center",
                    backdrop: "dynamic",
                    backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40",
                    closable: false,
                    onHide: () => {},
                    onShow: () => {},
                    onToggle: () => {},
                }
            );
        },
        activateNav(id) {
            this.activeContent = id;
        },
        isActive(id) {
            return this.activeContent === id;
        },
        async checkAndGenerateCode() {
            try {
                const response = await HttpApi.get("profile/affiliates/");
                if (response.data.code) {
                    this.isShowForm = true;
                    this.code = response.data.code;
                    this.referencecode = response.data.code;
                    this.urlCode = response.data.url;
                    this.indications = response.data.indications;
                    this.referencelink = response.data.url;
                    this.wallet = response.data.wallet;
                    this.withdrawalForm.amount = response.data.wallet.refer_rewards;
                } else {
                    await this.generateCode();
                }
            } catch (error) {
                console.error("Error fetching affiliate data", error);
            } finally {
                this.isLoading = false;
            }
        },
        async generateCode() {
            const _toast = useToast();
            try {
                const response = await HttpApi.get("profile/affiliates/generate");
                if (response.data.status) {
                    await this.getCode();
                    _toast.success(this.$t("Your code was generated successfully"));
                }
            } catch (error) {
                console.error("Error generating code", error);
                const errorMessage = JSON.parse(error.request.responseText);
                Object.values(errorMessage).forEach((msg) => _toast.error(msg));
            }
        },
        async getCode() {
            try {
                const response = await HttpApi.get("profile/affiliates/");
                if (response.data.code) {
                    this.isShowForm = true;
                    this.code = response.data.code;
                    this.referencecode = response.data.code;
                    this.urlCode = response.data.url;
                    this.indications = response.data.indications;
                    this.referencelink = response.data.url;
                    this.wallet = response.data.wallet;
                    this.withdrawalForm.amount = response.data.wallet.refer_rewards;
                }
            } catch (error) {
                console.error("Error fetching code", error);
            }
        },
        copyCode() {
            const _toast = useToast();
            const spanElement = document.getElementById("referenceCode");
            const codeToCopy = spanElement.textContent;
            
            const tempInput = document.createElement("textarea");
            tempInput.value = codeToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            
            _toast.success("Código copiado com sucesso");
        },
        copyLink() {
            const _toast = useToast();
            const inputElement = document.getElementById("referencelink");
            inputElement.select();
            document.execCommand("copy");
            _toast.success("Link copiado com sucesso");
        },
        
        opemModalWithdrawal() {
                this.withdrawalModal.toggle();
            
        },
        async makeWithdrawal() {
            const _toast = useToast();
            this.isLoading = true;
            try {
                const response = await HttpApi.post("profile/affiliates/request", this.withdrawalForm);
                this.opemModalWithdrawal();
                _toast.success(this.$t(response.data.message));
                this.isLoading = false;
                this.router.push({ name: "profileWallet" });
            } catch (error) {
                console.error("Error making withdrawal", error);
                const errorMessage = JSON.parse(error.request.responseText);
                Object.values(errorMessage).forEach((msg) => _toast.error(msg));
                this.isLoading = false;
            }
        }
    },
    async created() {
        await this.checkAndGenerateCode();
    }
};
</script>

<style scoped>
nav ul{
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
    border-bottom: 3px solid var(--ci-primary-opacity-color);
    color: var(--ci-primary-opacity-color);
}

.desactive {
    border: none;
}
.roxQrCode {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
}

.roxQr {
  margin-bottom: 10px;
}

.roxSaqueButton{
  position: absolute;
  top: -50px;
  right: 0;
}

.roxSaqueButtonMobile{
  position: absolute;
  bottom: -50px;
  right: 50%;
  transform: translateX(50%);
}
</style>
