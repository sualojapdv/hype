<template>
    <div class="w-full max-w-xl mx-auto">
        <div
            id="roxAgentHeader"
            class="w-full flex justify-between p-4 items-center"
            style="
                background-color: var(--ci-primary-color);
                border-bottom: 1px solid var(--ci-secundary-color);
            "
        >
            <div @click="$router.push('/')">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div><p class="text-2xl">Convidar</p></div>
            <div><p></p></div>
        </div>

        <nav
            id="roxAgentNav"
            class="w-full py-4 pb-0"
            style="border-bottom: 1px solid var(--ci-secundary-color)"
        >
            <ul
                class="flex flex-row gap-4 overflow-scroll items-center justify-start font-medium"
            >
                <li
                    v-for="item in navItems"
                    :key="item.id"
                    :class="[
                        isActive(item.id) ? 'active' : 'desactive',
                        'w-fit whitespace-nowrap pb-2 px-2',
                    ]"
                    @click="activateNav(item.id)"
                >
                    {{ item.label }}
                </li>
            </ul>
        </nav>

        <div>
            <div
                class="flex flex-col gap-2"
                v-show="activeContent === 'convite'"
                id="divConvite"
            >
                <div
                    class="mx-4 my-4 flex flex-col rounded-lg"
                    style="background-color: var(--ci-primary-color)"
                >
                    <div
                        class="w-full px-4 pb-4 flex justify-around align-top"
                        style="
                            border-bottom: 1px solid var(--ci-secundary-color);
                        "
                    >
                        <img
                            :src="`/storage/rox/1.png`"
                            style="
                                width: 80px;
                                height: auto;
                                object-fit: contain;
                                position: relative;
                                top: -20px;
                            "
                        />
                        <div class="flex flex-col gap-2 py-4 text-base">
                            <div
                                class="flex flex-row justify-between items-center"
                            >
                                <p>
                                    Coletável
                                    <span
                                        class="text-lg font-semibold"
                                        style="
                                            color: var(
                                                --ci-primary-opacity-color
                                            );
                                        "
                                    >
                                        {{
                                            wallet
                                                ? wallet.refer_rewards
                                                : "N/A"
                                        }}
                                    </span>
                                </p>
                                <div class="flex gap-2">
                                    <div
                                        @click.prevent="opemModalWithdrawal"
                                        class="p-2"
                                        style="
                                            background-color: var(
                                                --ci-primary-opacity-color
                                            );
                                            color: white;
                                            border-radius: 8px;
                                            cursor: pointer;
                                        "
                                    >
                                        Receber
                                    </div>
                                    <div
                                        class="p-2"
                                        style="
                                            background-color: var(
                                                --ci-primary-opacity-color
                                            );
                                            color: white;
                                            border-radius: 8px;
                                            cursor: pointer;
                                        "
                                    >
                                        Histórico
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex flex-row justify-between items-center gap-4"
                            >
                                <p>Modo de Agente</p>
                                <p>
                                    Diferença de nível infinito (Liquidação
                                    diária)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row gap-2 p-2">
                        <div class="roxQrCode">
                            <div class="roxQr" ref="qrCodeContainer"></div>
                            <div class="text-center" >
                                Clique para Salvar
                            </div>
                        </div>

                        <div class="w-[90%] flex flex-col gap-1">
                            <p>Meu Link</p>
                            <div
                                class="divLink rounded p-2 flex justify-between items-center w-full"
                                style="
                                    border: 1px solid
                                        var(--ci-primary-opacity-color);
                                "
                            >
                                <input
                                    class="w-[80%]"
                                    type="text"
                                    id="referencelink"
                                    :value="referencelink"
                                    readonly
                                    style="
                                        background-color: transparent;
                                        color: var(--ci-primary-opacity-color);
                                        border: none;
                                    "
                                />
                                <button @click="copyLink">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                            <p>
                                Subordinados diretos
                                <span
                                    class="text-lg"
                                    style="
                                        color: var(--ci-primary-opacity-color);
                                    "
                                >
                                    {{ indications }}
                                </span>
                            </p>
                            <p class="flex gap-2">
                                Código de Convite
                                <span
                                    id="referenceCode"
                                    style="
                                        color: var(--ci-primary-opacity-color);
                                    "
                                >
                                    {{ referencecode }}
                                </span>
                                <button @click="copyCode">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </p>
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

                <div
                    class="grid grid-cols-3 py-4 px-2 mx-4 my-4 rounded-lg"
                    style="background-color: var(--ci-primary-color)"
                >
                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                1 pessoa
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                2 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                3 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                4 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                5 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                6 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                7 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                8 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                9 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                10 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                11 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                12 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                13 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                14 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>

                    <div class="p-4">
                        <div class="relative">
                            <img
                                :src="`/storage/rox/vault_close.png`"
                                class="w-full"
                            />
                            <p
                                class="absolute w-full text-center text-sm bottom-2 font-semibold"
                                style="color: white"
                            >
                                15 pessoas
                            </p>
                        </div>
                        <p class="w-full text-center">
                            {{
                                state.currencyFormat(
                                    parseFloat(userData.affiliate_cpa),
                                    wallet.currency
                                )
                            }}
                        </p>
                    </div>
                </div>
            </div>
            <div v-show="activeContent === 'redeDoAgente'" id="divRedeDoAgente">
                <div
                    style="
                        background-color: var(--ci-primary-color);
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                    "
                >
                    <img
                        :src="`/storage/rox/agent_affiliate-preview.png`"
                        class="w-full max-w-2xl p-2"
                    />
                </div>

                <div
                    class="flex flex-col justify-center p-6"
                    style="width: 100%; max-width: 600px; margin: 0 auto"
                >
                    <h1><strong>Um exemplo é o seguinte:</strong></h1>
                    <p>
                        Suponha que as apostas efetivas atuais de 0 a 10.000
                        receberão uma comissão de 100 (ou seja, 1%) para cada
                        10.000, e o apostas efetivas acima de 10.000 receberão
                        uma comissão de 300 para cada 10.000. (ou seja, 3%), A
                        foi o primeiro a descobrir oportunidades de negócios
                        neste site e imediatamente desenvolveu B1, B2 e B3. B1
                        desenvolveu ainda mais C1 e C2. B2 desenvolveu sem
                        subordinados, e a B3 desenvolveu o relativamente
                        poderoso C3. No segundo dia, a aposta efetiva de B1 é
                        500, a aposta efetiva de B2 é 3.000, a aposta efetiva de
                        B3 é 2.000, a aposta efetiva de C1 é 1.000, a aposta
                        efetiva de C2 é 2.000 e a aposta efetiva de C3 é de até
                        20.000.
                    </p>
                    <span
                        >Então o método de cálculo da renda entre eles é o
                        seguinte:
                    </span>
                    <ul>
                        <li>
                            <strong>1. Comissão de B1</strong>
                            (contribuições diretas de C1 e C2) = (1000 + 2000) *
                            1% = <em>30</em>
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
                                >4. Além das contribuições dos subordinados
                                diretos B1, B2 e B3, a comissão de A também
                                advém das contribuições dos demais subordinados
                                C1, C2 e C3, conforme segue:
                            </strong>
                            <ul>
                                <li>
                                    <strong>( 1 )Comissão direta de A</strong
                                    >(contribuições diretas de B1, B2 e B3) =
                                    (500+3000+2000) * 3% =
                                    <em>165</em>
                                </li>
                                <li>
                                    <strong>( 2) Outras comissões de A</strong
                                    >(das contribuições C1, C2)=(1000+2000) *
                                    2%= <em>60</em>
                                </li>
                                <li>
                                    <strong>(3)Comissão total de A </strong
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
                                    refere-se aos subordinados desenvolvidos
                                    diretamente por A, ou seja, o primeiro nível
                                    de relacionamento com A, denominados
                                    coletivamente como equipe direta.
                                </li>
                                <li>
                                    <strong>(2) Outras equipes</strong>:
                                    Refere-se àquelas que são desenvolvidas por
                                    subordinados de A. Possuem relacionamento de
                                    segundo nível com A ou superior, ou seja,
                                    subordinados de subordinados , e os
                                    subordinados dos subordinados.. etc.,
                                    coletivamente referidos como outras equipes;
                                    como esse modelo de agência pode desenvolver
                                    subordinados ilimitados, para conveniência
                                    da explicação, este artigo toma apenas a
                                    estrutura de 2 níveis como exemplo.
                                </li>
                                <li>
                                    <strong>(3) Descrição de A</strong>: O
                                    desempenho direto de A é 5.500 e o outro
                                    desempenho é 20.000 (devido ao poder de C3).
                                    O desempenho total é 28.500 e a comissão
                                    correspondente a taxa é de 3%. Como B1 tem
                                    um desempenho total de 3.000 e desfruta de
                                    um desconto de apenas 1%, enquanto A tem um
                                    desempenho total de 28.500 e desfruta de uma
                                    taxa de desconto de 3%, então haverá uma
                                    diferença de desconto entre A e B1. A
                                    diferença é: 3% -1% =2%, essa diferença é a
                                    parte contribuída por C1 e C2 para A, então
                                    C1 e C2 contribuem para A: (1000+2000)*
                                    2%=60, não há diferença extrema entre A e
                                    B3, então C3 contribui para A A comissão de
                                    contribuição é 0.
                                </li>
                                <li>
                                    <strong>(4) Descrição de B1</strong>: B1 tem
                                    subordinados C1 e C2. Como o desempenho
                                    direto é 3.000, o índice de desconto
                                    correspondente é de 1%.
                                </li>
                                <li>
                                    <strong>(5) Explicação B2 </strong>: B2 pode
                                    ser preguiçoso e não se beneficiará se não
                                    desenvolver seus subordinados.
                                </li>
                                <li>
                                    <strong>(6) Explicação B3</strong>: Embora
                                    B3 tenha aderido relativamente tarde e seja
                                    subordinado de A, seu subordinado C3 é muito
                                    poderoso e tem um desempenho direto de
                                    20.000, permitindo que B3 diretamente
                                    desfrutar de comissões mais elevadas.A
                                    proporção é de 3%.
                                </li>
                                <li>
                                    <strong>(7) Resumo das regras</strong>: Não
                                    importa quando você ingressa, de quem você é
                                    subordinado, não importa em que nível você
                                    está, sua renda nunca será afetada e você
                                    não sofre mais as perdas dos subordinados
                                    dos outros., o desenvolvimento não é
                                    restrito. Este é um modelo de agência
                                    absolutamente justo e imparcial, e ninguém
                                    estará sempre por baixo só porque entrou
                                    tarde.
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-show="activeContent === 'meusDados'" id="divMeusDados">
                <div
                    class="grid grid-cols-3 grid-rows-2 items-center text-center gap-2 p-2"
                >
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24"
                        style="
                            background-color: var(--ci-primary-color);
                            text-align: center;
                        "
                    >
                        <p>Comissão</p>
                        <span>{{
                            state.currencyFormat(
                                parseFloat(wallet.refer_rewards),
                                wallet.currency
                            )
                        }}</span>
                    </div>

                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24"
                        style="
                            background-color: var(--ci-primary-color);
                            text-align: center;
                        "
                    >
                        <p>Depósitos</p>
                        <span>0</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24"
                        style="
                            background-color: var(--ci-primary-color);
                            text-align: center;
                        "
                    >
                        <p>Desempenho</p>
                        <span>0</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24"
                        style="
                            background-color: var(--ci-primary-color);
                            text-align: center;
                        "
                    >
                        <p>Total Subordinados</p>
                        <span>{{ indications }}</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24"
                        style="
                            background-color: var(--ci-primary-color);
                            text-align: center;
                        "
                    >
                        <p>Valor por Indicação</p>
                        <span>{{
                            state.currencyFormat(
                                parseFloat(userData.affiliate_cpa),
                                wallet.currency
                            )
                        }}</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24"
                        style="
                            background-color: var(--ci-primary-color);
                            text-align: center;
                        "
                    >
                        <p>Comissão Revenue Share</p>
                        <span
                            >{{
                                userData.affiliate_revenue_share_fake ||
                                userData.affiliate_revenue_share ||
                                0
                            }}%</span
                        >
                    </div>
                </div>
            </div>
            <div v-show="activeContent === 'comissao'" id="divComissao">
                <div
                    class="flex rounded-lg items-center justify-around mx-4 my-4 p-2"
                    style="background-color: var(--ci-primary-color)"
                >
                    <div class="flex flex-col justify-center items-start gap-2">
                        <input
                            v-model="currentDate"
                            class="p-1 rounded-lg"
                            type="date"
                            style="
                                border: 1px solid
                                    var(--ci-primary-opacity-color);
                                background-color: transparent;
                                color: var(--ci-primary-opacity-color);
                            "
                        />
                        <p>
                            Comissão Direta
                            <span class="font-semibold text-white">0,00</span>
                        </p>
                    </div>

                    <div>
                        <p>
                            Comissões Totais
                            <span class="font-semibold text-white">0,00</span>
                        </p>
                        <p>
                            Outra Comissão
                            <span class="font-semibold text-white">0,00</span>
                        </p>
                    </div>
                </div>

                <div
                    class="w-full h-full m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Registros</p>
                </div>
            </div>
            <div v-show="activeContent === 'desempenho'" id="divDesempenho">
                <div
                    class="flex rounded-lg items-center justify-around mx-4 my-4 p-2"
                    style="background-color: var(--ci-primary-color)"
                >
                    <div class="flex flex-col justify-center items-start gap-2">
                        <input
                            v-model="currentDate"
                            class="p-1 rounded-lg"
                            type="date"
                            style="
                                border: 1px solid
                                    var(--ci-primary-opacity-color);
                                background-color: transparent;
                                color: var(--ci-primary-opacity-color);
                            "
                        />
                        <p>
                            D. Direto
                            <span class="font-semibold text-white">0,00</span>
                        </p>
                    </div>

                    <div>
                        <p>
                            Rendimento Total
                            <span class="font-semibold text-white">0,00</span>
                        </p>
                        <p>
                            D. dos Outros
                            <span class="font-semibold text-white">0,00</span>
                        </p>
                    </div>
                </div>

                <div
                    class="w-full h-full m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Registros</p>
                </div>
            </div>
            <div v-show="activeContent === 'taxaBonus'" id="divTaxaBonus">
                <table class="w-full" style="text-align: center">
                    <tr
                        style="
                            background-color: var(--ci-primary-color);
                            height: 30px;
                            text-align: center;
                        "
                    >
                        <th>Nível</th>
                        <th>Desempenho</th>
                        <th>Taxa de Bônus</th>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>10.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.1%
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>2,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.2%
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>4,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.3%
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>8,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.4%
                        </td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>16,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.5%
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>32,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.6%
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>64,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.7%
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>120,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.8%
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>240,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            0.9%
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>500,000.00+</td>
                        <td
                            style="
                                color: var(--ci-primary-opacity-color);
                                font-weight: 600;
                            "
                        >
                            1.0%
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4 mt-20 relative min-h-[calc(100vh-565px)]">
        <div
            v-if="wallet && !isLoading"
            class="hidden grid-cols-1 md:grid-cols-3 gap-0 md:gap-4"
        >
            <div
                v-if="isShowForm"
                class="col-span-1 bg-gray-100 dark:bg-gray-800 shadow-lg rounded-bl-lg rounded-br-lg mb-3"
            >
                <div
                    class="flex flex-col w-full bg-gradient-to-r from-violet-900 to-violet-950 p-5 rounded-lg"
                >
                    <div class="invite-bg">
                        <h1 class="text-white tex-lg md:text-2xl font-bold">
                            {{ $t("INVITE A FRIEND") }}:
                        </h1>

                        <!--                            <div class="mt-5">-->
                        <!--                                <p class="mb-1 text-white tex-sm md:text-base"><strong class="text-yellow-400">$1,000.00</strong> {{ $t('REFERRAL REWARDS') }}</p>-->
                        <!--                                <p class="mb-1 text-white tex-sm md:text-base"><strong class="text-yellow-400">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}%</strong> {{ $t('COMMISSION REWARDS') }}</p>-->
                        <!--                            </div>-->
                    </div>
                </div>
                <div class="mt-3 p-4">
                    <div class="hidden flex-col mb-4">
                        <label
                            for="reference-code"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >{{ $t("Reference Code") }}</label
                        >
                        <div class="relative w-full">
                            <input
                                type="text"
                                id="referenceCode"
                                class="block p-4 w-full z-20 text-sm text-gray-900 border-gray-300 bg-gray-50 rounded-lg rounded-gray-100 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-gray-500"
                                :placeholder="$t('Reference Code')"
                                v-model="referencecode"
                                required
                            />
                            <button
                                @click.prevent="copyCode"
                                type="submit"
                                class="absolute top-0 end-0 py-2 px-4 h-full text-gray-500 dark:text-white bg-gray-200 rounded-e-lg focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                            >
                                <i class="fa-duotone fa-copy text-2xl"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label
                            for="reference-code"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >{{ $t("Reference Link") }}</label
                        >
                        <div class="relative w-full">
                            <input
                                type="text"
                                id="referenceLink"
                                class="block p-4 w-full z-20 text-sm text-gray-900 border-gray-300 bg-gray-50 rounded-lg rounded-gray-100 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-gray-500"
                                :placeholder="$t('Reference Link')"
                                v-model="referencelink"
                                required
                            />
                            <button
                                @click.prevent="copyLink"
                                type="submit"
                                class="absolute top-0 end-0 py-2 px-4 h-full text-gray-500 dark:text-white bg-gray-200 rounded-e-lg focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                            >
                                <i class="fa-duotone fa-copy text-2xl"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-16 grid grid-cols-1 md:grid-cols-1 gap-4">
                        <!-- <button @click.prevent="generateCode" type="button" class="ui-button-yellow">
                                {{ $t('Create another code') }}
                            </button> -->
                        <button type="button" class="ui-button-yellow">
                            <a href="/affiliate/login" target="_blank"
                                >Painel Avançado</a
                            >
                            <!-- {{ $t('Share on social media') }} -->
                        </button>
                    </div>

                    <!-- <div class="mt-5 flex justify-end items-end">
                            <button @click="$router.push('/terms-conditions/reference')" type="button" class="text-gray-500 hover:text-gray-600 dark:text-gray-300 hover:dark:text-gray-400">
                                {{ $t('Terms and Conditions of Reference') }} <i class="fa-regular fa-arrow-right ml-2"></i>
                            </button>
                        </div> -->
                </div>
            </div>
            <div
                v-else
                class="relative hidden flex-col items-center justify-center text-center p-6"
            >
                <div v-if="!isLoadingGenerate" class="">
                    <p class="text-gray-400">
                        {{ $t("Generate the code Description") }}
                    </p>
                    <div class="mt-5 w-full">
                        <button
                            @click.prevent="generateCode"
                            type="button"
                            class="ui-button-violet w-full"
                        >
                            {{ $t("Generate the code") }}
                        </button>
                    </div>
                </div>

                <div
                    v-if="isLoadingGenerate"
                    role="status"
                    class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2"
                >
                    <svg
                        aria-hidden="true"
                        class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"
                        />
                    </svg>
                    <span class="sr-only">{{ $t("Loading") }}...</span>
                </div>
            </div>
            <div class="col-span-2 w-full">
                <div class="hidden grid-cols-1 md:grid-cols-2 gap-0 md:gap-4">
                    <div
                        class="flex items-center bg-white dark:bg-gray-800 p-4 shadow-lg w-full mb-3 dark:border-gray-700"
                    >
                        <div class="w-20 mr-3">
                            <img :src="`/assets/images/trophy.png`" alt="" />
                        </div>
                        <div class="w-full">
                            <h1 class="text-base">
                                {{ $t("TOTAL REWARD RECEIVED") }}:
                            </h1>
                            <h2 class="text-yellow-400 font-bold text-2xl">
                                {{
                                    state.currencyFormat(
                                        parseFloat(wallet.refer_rewards),
                                        wallet.currency
                                    )
                                }}
                            </h2>
                        </div>
                        <button
                            @click.prevent="opemModalWithdrawal"
                            type="button"
                            class="dark:bg-gray-600 py-4 px-6 h-full ml-3 flex items-center justify-center"
                        >
                            {{ $t("Withdraw") }}
                        </button>
                    </div>
                    <div
                        class="hidden items-center bg-white dark:bg-gray-800 px-4 py-2 shadow-lg w-full mb-3 dark:border-gray-700"
                    >
                        <div class="w-20 mr-3">
                            <img
                                :src="`/assets/images/usehead.b760e9be.png`"
                                alt=""
                            />
                        </div>
                        <div>
                            <h1 class="text-base">
                                {{ $t("TOTAL REFERRED FRIENDS") }}:
                            </h1>
                            <h2 class="text-yellow-400 font-bold text-2xl">
                                {{ indications }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div
                    class="hidden grid-cols-1 md:grid-cols-2 gap-0 md:gap-4 mt-3"
                >
                    <div
                        class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full mb-3"
                    >
                        <div class="header flex justify-between">
                            <div class="flex items-center">
                                <img
                                    :src="`/assets/images/network.a415d3eb.png`"
                                    alt=""
                                    width="28"
                                />
                                <h2 class="ml-3">
                                    {{ $t("REFERRAL REVSHARE") }}
                                </h2>
                            </div>
                            <button
                                @click.prevent="toggleCommissionRewards"
                                type="button"
                                class="flex items-center text-green-500 font-bold"
                            >
                                {{ $t("Details") }}
                                <i class="fa-solid fa-chevron-right ml-2"></i>
                            </button>
                        </div>

                        <div
                            class="body flex flex-col justify-center items-center py-8"
                        >
                            <h1 class="text-yellow-400 font-bold text-4xl">
                                {{
                                    userData.affiliate_revenue_share_fake
                                        ? userData.affiliate_revenue_share_fake
                                        : userData.affiliate_revenue_share
                                }}%
                            </h1>
                        </div>
                    </div>
                    <div
                        class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full mb-3"
                    >
                        <div class="header flex justify-between">
                            <div class="flex items-center">
                                <img
                                    :src="`/assets/images/discount.bf090f3a.png`"
                                    alt=""
                                    width="28"
                                />
                                <h2 class="ml-3">{{ $t("COMMISSION CPA") }}</h2>
                            </div>
                            <button
                                @click.prevent="toggleReferenceRewards"
                                type="button"
                                class="flex items-center text-green-500 font-bold"
                            >
                                {{ $t("Details") }}
                                <i class="fa-solid fa-chevron-right ml-2"></i>
                            </button>
                        </div>

                        <div
                            class="body flex flex-col justify-center items-center py-8"
                        >
                            <h1 class="text-yellow-400 font-bold text-4xl">
                                {{
                                    state.currencyFormat(
                                        parseFloat(userData.affiliate_cpa),
                                        wallet.currency
                                    )
                                }}
                            </h1>
                        </div>
                    </div>
                </div>

                <div
                    class="hidden shadow dark:bg-gray-800 dark:border-gray-700 w-full rounded-lg"
                >
                    <div class="p-4">
                        <img
                            :src="`/assets/images/indique.png`"
                            alt=""
                            class="mr-3"
                        />
                    </div>
                    <div class="flex flex-col justify-center p-4">
                        <h1 class="text-2xl font-bold mb-3">Painel Avançado</h1>
                        <p class="text-gray-500">
                            Nossa plataforma dispõe de um painel de afiliados
                            avançado, permitindo que você visualize detalhes
                            sobre ganhos e perdas. Além disso, oferece a
                            capacidade de adicionar subafiliados.
                        </p>
                        <a
                            href="/affiliate/login"
                            class="mt-4 text-green-500 font-bold"
                            >Clique aqui para acessar</a
                        >
                    </div>
                </div>
            </div>
        </div>
        <div
            v-else
            role="status"
            class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2 h-full mt-16"
        >
            <div class="text-center flex flex-col justify-center items-center">
                <svg
                    aria-hidden="true"
                    class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600"
                    viewBox="0 0 100 101"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor"
                    />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill"
                    />
                </svg>
                <span class="mt-3">{{ $t("Loading") }}...</span>
            </div>
        </div>
    </div>

    <!-- MODAL RECOMPENSAS DE REFERÊNCIA -->
    <div
        id="referenceRewardsEl"
        tabindex="-1"
        aria-hidden="true"
        class="hidden left-0 right-0 top-0 z-50 h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0"
    >
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="hidden justify-between p-4 dark:bg-gray-600 rounded-t-lg"
                >
                    <h1>{{ $t("Referral Reward Rules") }}</h1>
                    <button class="" @click.prevent="toggleReferenceRewards">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="w-full hidden justify-center p-4">
                    <div class="flex items-center">
                        <div class="l"></div>
                        <div class="text-white px-3">Regras de Desbloqueio</div>
                        <div class="r"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL RECOMPENSAS POR COMISSÃO -->
    <div
        id="commissionRewardsEl"
        tabindex="-1"
        aria-hidden="true"
        class="hidden left-0 right-0 top-0 z-50 h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0"
    >
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="hidden justify-between p-4 dark:bg-gray-600 rounded-t-lg"
                >
                    <h1>Regras de recompensas por comissão</h1>
                    <button class="" @click.prevent="toggleCommissionRewards">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="hidden flex-col w-full justify-center p-4">
                    <div
                        class="flex items-center text-center w-full justify-center"
                    >
                        <div class="l"></div>
                        <div class="text-white px-3">Taxas de comissões</div>
                        <div class="r"></div>
                    </div>

                    <div class="mt-5">
                        <ul>
                            <li
                                class="flex dark:bg-gray-800 shadow rounded-lg aposta-1 w-full p-4 mb-3"
                            >
                                <div>
                                    <h1 class="font-mono text-4xl font-bold">
                                        7%
                                    </h1>
                                    <p class="text-gray-400 text-sm">
                                        <strong class="text-gray-400"
                                            >Jogo:</strong
                                        >
                                        Os Jogos Originais
                                    </p>
                                </div>
                            </li>
                            <li
                                class="flex dark:bg-gray-800 shadow rounded-lg aposta-2 w-full p-4 mb-3"
                            >
                                <div>
                                    <h1 class="font-mono text-4xl font-bold">
                                        7%
                                    </h1>
                                    <p class="text-gray-400 text-sm">
                                        <strong class="text-gray-400"
                                            >Jogo:</strong
                                        >
                                        slots de terceiros, cassino ao vivo
                                    </p>
                                </div>
                            </li>
                            <li
                                class="flex dark:bg-gray-800 shadow rounded-lg aposta-3 w-full p-4 mb-3"
                            >
                                <div>
                                    <h1 class="font-mono text-4xl font-bold">
                                        25%
                                    </h1>
                                    <p class="text-gray-400 text-sm">
                                        <strong class="text-gray-400"
                                            >Jogo:</strong
                                        >
                                        Esportes
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-5 ml-4">
                        <ul class="list-outside list-disc">
                            <li class="mb-3">
                                Em qualquer ambiente público (por exemplo,
                                universidades, escolas, bibliotecas e espaços de
                                escritório), apenas uma comissão pode ser paga
                                para cada usuário, endereço IP, dispositivo
                                eletrônico, residência, número de telefone,
                                método de cobrança, endereço de e-mail e
                                computador e IP endereço compartilhado com
                                outras pessoas.
                            </li>
                            <li class="mb-3">
                                Nossa decisão de fazer uma aposta será baseada
                                inteiramente em nosso critério depois que um
                                depósito for feito e uma aposta for feita com
                                sucesso.
                            </li>
                            <li class="mb-3">
                                As comissões podem ser retiradas em nossa
                                carteira CREDK interna do painel a qualquer
                                momento. (Veja a extração de sua comissão no
                                painel e visualize o saldo na carteira).
                            </li>
                            <li class="mb-3">
                                Apoiamos a maioria das moedas no mercado.
                            </li>
                            <li class="mb-3">
                                O sistema calcula a comissão a cada 24 horas.
                            </li>
                        </ul>
                    </div>

                    <div
                        class="mt-5 w-full border dark:border-gray-500 p-4 rounded"
                    >
                        Se você tiver alguma dúvida sobre nossas regras, por
                        favor
                        <a href="" class="text-green-500 font-bold">
                            Contate-nos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL SAQUE -->
    <div
        id="withdrawalEl"
        aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0"
    >
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div
                class="relative rounded-lg shadow"
                style="background-color: var(--ci-primary-color)"
            >
                <!-- Modal header -->
                <div
                    class="flex justify-between p-4 rounded-t-lg w-full text-center"
                    style="background-color: var(--ci-primary-color)"
                >
                    <h1 class="w-full text-center">Solicitação de saque</h1>
                    <!-- <button class="" @click.prevent="opemModalWithdrawal">
                            <i class="fa-solid fa-xmark"></i>
                        </button> -->
                </div>

                <!-- Modal body -->
                <div class="flex flex-col w-full justify-center p-4">
                    <form action="" @submit.prevent="makeWithdrawal">
                        <div class="mb-3" style="color: var(--ci-gray-dark)">
                            <label for="">Valor do Saque</label>
                            <input
                                v-model="withdrawalForm.amount"
                                type="number"
                                class="input"
                                placeholder="Valor do saque"
                                required
                                style="
                                    background-color: var(--ci-secundary-color);
                                    color: var(--ci-gray-dark);
                                "
                            />
                            <span
                                v-if="wallet"
                                class="text-sm italic"
                                style="color: var(--ci-primary-opacity-color)"
                                >Saldo:
                                {{
                                    state.currencyFormat(
                                        parseFloat(wallet?.refer_rewards),
                                        wallet?.currency
                                    )
                                }}</span
                            >
                        </div>

                        <div class="mb-3" style="color: var(--ci-gray-dark)">
                            <label for="">Chave Pix</label>
                            <input
                                v-model="withdrawalForm.pix_key"
                                type="text"
                                class="input"
                                placeholder="Digite a sua Chave pix"
                                required
                                style="
                                    background-color: var(--ci-secundary-color);
                                    color: var(--ci-gray-dark);
                                "
                            />
                        </div>

                        <div class="mb-3" style="color: var(--ci-gray-dark)">
                            <label for="">Tipo de Chave</label>
                            <select
                                v-model="withdrawalForm.pix_type"
                                name="type_document"
                                class="input"
                                required
                                style="
                                    background-color: var(--ci-secundary-color);
                                    color: var(--ci-gray-dark);
                                "
                            >
                                <option value="">Selecione uma chave</option>
                                <option value="document">CPF/CNPJ</option>
                                <option value="email">E-mail</option>
                                <option value="phoneNumber">Telefone</option>
                                <option value="randomKey">
                                    Chave Aleatória
                                </option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="mt-5 w-full text-white px-4 py-2 transition duration-700"
                            style="
                                background-color: var(
                                    --ci-primary-opacity-color
                                );
                            "
                        >
                            Solicitar agora
                        </button>
                        <p
                            class="roxSaqueButtonMobile block md:hidden"
                            @click.prevent="opemModalWithdrawal"
                            style="
                                color: white;
                                font-weight: 400;
                                font-size: 1.6rem;
                            "
                        >
                            <i class="fa-thin fa-circle-xmark"></i>
                        </p>

                        <p
                            class="roxSaqueButton hidden md:block"
                            @click.prevent="opemModalWithdrawal"
                            style="
                                color: white;
                                font-weight: 400;
                                font-size: 1.6rem;
                            "
                        >
                            <i class="fa-thin fa-circle-xmark"></i>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from "flowbite";
import HttpApi from "@/Services/HttpApi.js";
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/Stores/Auth.js";
import { useRouter } from "vue-router";
import html2canvas from "html2canvas";
import jsPDF from "jspdf";

export default {
    props: [],
    components: { Modal },
    data() {
        return {
            completeData: null,
            currentDate: "",
            isLoading: false,
            referenceRewards: null,
            commissionRewards: null,
            isShowForm: false,
            isLoadingGenerate: false,
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
            activeContent: "convite",
            navItems: [
                { id: "convite", label: "Link de Convite" },
                { id: "redeDoAgente", label: "Rede do Agente" },
                { id: "meusDados", label: "Meus Dados" },
                { id: "comissao", label: "Comissão" },
                { id: "desempenho", label: "Desempenho" },
                { id: "taxaBonus", label: "Taxa de Bônus do Agente" },
            ],
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
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, "0"); // Months start at 0!
        const dd = String(today.getDate()).padStart(2, "0");
        this.currentDate = `${yyyy}-${mm}-${dd}`;
        

        this.withdrawalModal = new Modal(
            document.getElementById("withdrawalEl"),
            {
                placement: "center",
                backdrop: "dynamic",
                backdropClasses:
                    "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40",
                closable: false,
                onHide: () => {},
                onShow: () => {},
                onToggle: () => {},
            }
        );
    },
    methods: {
                
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
                    this.withdrawalForm.amount =
                        response.data.wallet.refer_rewards;
                    this.completeData = response.data;

                    console.log(this.completeData);
                } else {
                    await this.generateCode();
                }
            } catch (error) {
                console.error("Error fetching affiliate data", error);
            } finally {
                this.isLoading = false;
            }
        },
        activateNav(id) {
            this.activeContent = id;
        },
        isActive(id) {
            return this.activeContent === id;
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
        copyLink: function (event) {
            const _toast = useToast();
            var inputElement = document.getElementById("referenceLink");
            inputElement.select();
            inputElement.setSelectionRange(0, 99999); // Para dispositivos móveis

            // Copia o conteúdo para a área de transferência
            document.execCommand("copy");
            _toast.success(this.$t("Link copied successfully"));
        },
        getCode: function () {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;

            HttpApi.get("profile/affiliates/")
                .then((response) => {
                    if (
                        response.data.code !== "" &&
                        response.data.code !== undefined &&
                        response.data.code !== null
                    ) {
                        _this.isShowForm = true;
                        _this.code = response.data.code;
                        _this.referencecode = response.data.code;
                        _this.urlCode = response.data.url;
                    }

                    _this.indications = response.data.indications;
                    _this.referencelink = response.data.url;
                    _this.wallet = response.data.wallet;
                    _this.withdrawalForm.amount =
                        response.data.wallet.refer_rewards;

                    _this.isLoadingGenerate = false;
                })
                .catch((error) => {
                    _this.isShowForm = false;
                    _this.isLoadingGenerate = false;
                });
        },
        generateCode: function (event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;

            HttpApi.get("profile/affiliates/generate")
                .then((response) => {
                    if (response.data.status) {
                        _this.getCode();
                        _toast.success(
                            _this.$t("Your code was generated successfully")
                        );
                    }

                    _this.isLoadingGenerate = false;
                })
                .catch((error) => {
                    Object.entries(
                        JSON.parse(error.request.responseText)
                    ).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingGenerate = false;
                });
        },
        toggleCommissionRewards: function (event) {
            this.commissionRewards.toggle();
        },
        toggleReferenceRewards: function (event) {
            this.referenceRewards.toggle();
        },
        opemModalWithdrawal: function () {
            this.withdrawalModal.toggle();
        },
        makeWithdrawal: async function () {
    const _this = this;
    const _toast = useToast();

    _this.isLoading = true;

    HttpApi.post("profile/affiliates/request", _this.withdrawalForm)
        .then((response) => {
            console.log("Success Response:", response);  // Debugging
            _this.opemModalWithdrawal();
            _toast.success(_this.$t(response.data.message));
            _this.isLoading = false;
            _this.router.push({ name: "profileAffiliate" });
        })
        .catch((error) => {
            console.error("Error Response:", error);  // Debugging
            if (error.response && error.response.data) {
                Object.entries(error.response.data).forEach(([key, value]) => {
                    _toast.error(`${value}`);
                });
            } else {
                _toast.error("An unexpected error occurred.");
            }
            _this.isLoading = false;
        });
},
    },
    async created() {
        await this.checkAndGenerateCode();
    },
    watch: {},
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

.roxSaqueButton {
    position: absolute;
    top: -50px;
    right: 0;
}

.roxSaqueButtonMobile {
    position: absolute;
    bottom: -50px;
    right: 50%;
    transform: translateX(50%);
}

th {
    width: 33%;
    max-width: 400px;
}
td {
    width: 33%;
    max-width: 400px;
}
tr {
    height: 32px;
    padding: 4px 0px;
}
.relative {
    position: relative;
}

.absolute {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}
</style>
