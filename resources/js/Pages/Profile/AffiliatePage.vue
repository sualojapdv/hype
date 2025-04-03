<template>
    <div class="w-full max-w-xl mx-auto">
    <div
      id="roxAgentHeader"
      class="w-full flex justify-between px-4 py-2 items-center"
      style="
        background-color: var(--ci-primary-color);
        border-bottom: 1px solid var(--ci-secundary-color);
      "
    >
      <div @click="$router.push('/')" class="cursor-pointer"><i class="fa-solid fa-chevron-left"></i></div>
      <div><p class="text-lg">Convidar</p></div>
      <div><p></p></div>
    </div>

    <nav
      id="roxAgentNav"
      class="w-full py-2 pb-0"
      style="border-bottom: 1px solid var(--ci-secundary-color); background-color: var(--ci-primary-color);"
    >
      <ul
        class="flex flex-row gap-4 overflow-scroll items-center justify-start font-medium"
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
            style="border-bottom: 1px solid var(--ci-secundary-color)"
          >
            <img
              :src="`/storage/rox/1.png`"
              style="
                width: 60px;
                height: auto;
                object-fit: contain;
                position: relative;
                top: -10px;
              "
            />
            <div class="flex flex-col gap-2 py-3 text-base">
              <div class="flex flex-row justify-between items-center">
                <p class="text-sm">
                  Coletável
                  <span
                    class="font-semibold"
                    style="
                      color: var(--ci-primary-opacity-color);
                    "
                  >
                    R$ {{ wallet ? wallet.refer_rewards : 'N/A' }}
                  </span>
                </p>
                <div class="flex gap-1">
                  <div
                    @click.prevent="opemModalWithdrawal"
                    class="p-2 text-sm"
                    style="
                      background-color: var(--ci-primary-opacity-color);
                      color: white;
                      border-radius: 8px;
                      cursor: pointer;
                    "
                  >
                    Receber
                  </div>
                  <!-- <div
                    @click="$router.push('/profile/transactions')"
                    class="p-2"
                    style="
                      background-color: var(--ci-primary-opacity-color);
                      color: white;
                      border-radius: 8px;
                      cursor: pointer;
                    "
                  >
                    Histórico
                  </div> -->
                </div>
              </div>

              <div
                class="flex flex-row justify-between items-center gap-4 text-[0.6rem] md:text-base"
              >
                <p>Modo de Agente</p>
                <p>
                  Diferença de nível infinito (Liquidação diária)
                </p>
              </div>
            </div>
          </div>

          <div class="flex flex-row gap-2 p-2">
            <div class="roxQrCode">
                <!-- <QRCodeVue3 v-if="referencelink" :value="referencelink" ref="qrcode"/> -->
                <QRCode v-if="referencelink" :value="referencelink" ref="qrcode" :size="`80`" :level="'H'"/>

                <div @click="downloadQrCode" class="text-sm">Clique para Salvar</div>
            </div>

            <div ref="qrCodeWithSignature" class="qr-code-container hiddenQr">
            <QRCode v-if="referencelink" :value="referencelink" :size="`300`" :level="'H'"/>
            <div class="signature">
                <p>{{firstSignature}}</p>
                <p>{{secondSignature}}</p>
            </div>
            </div>

            <div class="w-[90%] flex flex-col gap-1">
              <p class="text-sm">Meu Link</p>

              <div
                class="divLink rounded p-1 flex justify-between items-center w-full"
                style="
                  border: 1px solid var(--ci-primary-opacity-color);
                "
              >
                <input
                  class="w-[80%] text-sm p-1"
                  type="text"
                  id="referencelink"
                  :value="referencelink"
                  readonly
                  style="margin: 0;
                    background-color: transparent;
                    color: var(--ci-primary-opacity-color);
                    border: none;
                  "
                />
                <button @click="copyLink">
                  <i class="fa-regular fa-copy"></i>
                </button>
              </div>

              <p class="text-sm">
                Subordinados diretos
                <span
                  class="text-sm"
                  style="color: var(--ci-primary-opacity-color)"
                >
                  {{ indications }}
                </span>
              </p>
              <p class="text-sm">
                Código de Convite
                <span
                  id="referenceCode"
                  style="color: var(--ci-primary-opacity-color)"
                >
                  {{ referencecode }} 
                </span>
                <button @click="copyCode">
                  <i class="fa-regular fa-copy ml-1"></i>
                </button>
              </p>
            </div>
          </div>

          <div class="w-full flex gap-2 p-4">
                <div class="my-scrollbar-wrap my-scrollbar-wrap-x">
                <div class="my-scrollbar-content">
                    <div class="flex gap-2 w-full justify-start items-center mt-4">
                    <div class="flex justify-center items-center">
                        <i
                        class="fa-duotone fa-share-from-square"
                        @click="copyLinkOrShare"
                        style="font-size: 1.5rem; color: var(--ci-gray-light); cursor: pointer;"
                        ></i>
                    </div>
                    <div v-for="social in socials" :key="social.name" @click="shareLink(social.name)" class="cursor-pointer">
                        <img
                        :src="social.imgSrc"
                        :alt="social.name"
                        style="width: 2rem; height: 2rem;"
                        />
                    </div>
                    </div>
                </div>
                </div>
            </div>

                    
        </div>

        
        <!-- <div
      class="grid grid-cols-4 py-4 px-1 mx-4 my-4 rounded-lg"
      style="background-color: var(--ci-primary-color)"
    >
      <div v-for="index in 20" :key="index" class="transform scale-[0.8] flex items-center justify-center" >
        <div class="relative">
          <img
            :src="index <= totalDeposits ? `/storage/rox/vault_open.png` : `/storage/rox/vault_close.png`"
            class="w-full"
          />
          <p
            class="absolute w-full text-center text-sm bottom-2 font-semibold"
            style="color: white"
          >
            {{ index }} pessoa{{ index !== 1 ? 's' : '' }}
          </p>
           
          <p
            v-if="index <= totalDeposits"
            class="absolute inset-0 flex items-center justify-center font-bold text-xl text-red-600"
            style="text-shadow: 0 0 5px yellow;"
          >
            R$ {{ userData.affiliate_cpa }}
          </p>
        </div>
        
      </div>
    </div> -->
    
    <div class="bg-[var(--ci-primary-color)] mr-4 ml-4 p-3 rounded-lg">

        <div class="w-full">
        <p class=" text-center text-[var(--ci-primary-opacity-color)] mb-3 text-md md:text-xl ">
            O que é um número válido promocional? (Cumprir todos os requisitos
            indicados abaixo)
        </p>
        <div class="flex justify-between items-center p-2 bg-[var(--ci-primary-opacity-color)] text-white rounded-lg m-b-2 text-sm md:text-xl">
            <span>Depósitos acumulados do subordinado</span><span>{{ bauValue.toFixed(2) }} ou mais</span>
        </div>
        <div class="flex justify-between items-center p-2 text-white rounded-lg m-b-2 text-sm md:text-xl">
            <span>Apostas acumuladas do subordinado</span><span>100 ou mais</span>
        </div>
        </div>


        <!-- <div class="container">
        
        <div class="row">
            <div class="chest" id="chest1" @click="verificarBau(1)">
            <img :src="chestImages[1]" alt="Baú" />
            <div class="chest-text">
                <p>1 pessoa</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest2" @click="verificarBau(2)">
            <img :src="chestImages[2]" alt="Baú" />
            <div class="chest-text">
                <p>2 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest3" @click="verificarBau(3)">
            <img :src="chestImages[3]" alt="Baú" />
            <div class="chest-text">
                <p>3 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest4" @click="verificarBau(4)">
            <img :src="chestImages[4]" alt="Baú" />
            <div class="chest-text">
                <p>4 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: 82%">
           
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        
        <div class="row">
            <div class="chest" id="chest5" @click="verificarBau(5)">
            <img :src="chestImages[5]" alt="Baú" />
            <div class="chest-text">
                <p>5 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest6" @click="verificarBau(6)">
            <img :src="chestImages[6]" alt="Baú" />
            <div class="chest-text">
                <p>6 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest7" @click="verificarBau(7)">
            <img :src="chestImages[7]" alt="Baú" />
            <div class="chest-text">
                <p>7 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest8" @click="verificarBau(8)">
            <img :src="chestImages[8]" alt="Baú" />
            <div class="chest-text">
                <p>8 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: -82%">
            
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        
        <div class="row">
            <div class="chest" id="chest9" @click="verificarBau(9)">
            <img :src="chestImages[9]" alt="Baú" />
            <div class="chest-text">
                <p>9 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest10" @click="verificarBau(10)">
            <img :src="chestImages[10]" alt="Baú" />
            <div class="chest-text">
                <p>10 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest11" @click="verificarBau(11)">
            <img :src="chestImages[11]" alt="Baú" />
            <div class="chest-text">
                <p>11 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest12" @click="verificarBau(12)">
            <img :src="chestImages[12]" alt="Baú" />
            <div class="chest-text">
                <p>12 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: 82%">
            
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        
        <div class="row">
            <div class="chest" id="chest13" @click="verificarBau(13)">
            <img :src="chestImages[13]" alt="Baú" />
            <div class="chest-text">
                <p>13 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest14" @click="verificarBau(14)">
            <img :src="chestImages[14]" alt="Baú" />
            <div class="chest-text">
                <p>14 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest15" @click="verificarBau(15)">
            <img :src="chestImages[15]" alt="Baú" />
            <div class="chest-text">
                <p>15 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest16" @click="verificarBau(16)">
            <img :src="chestImages[16]" alt="Baú" />
            <div class="chest-text">
                <p>16 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: -82%">
          
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
       
        <div class="row">
            <div class="chest" id="chest17" @click="verificarBau(17)">
            <img :src="chestImages[17]" alt="Baú" />
            <div class="chest-text">
                <p>17 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest18" @click="verificarBau(18)">
            <img :src="chestImages[18]" alt="Baú" />
            <div class="chest-text">
                <p>18 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest19" @click="verificarBau(19)">
            <img :src="chestImages[19]" alt="Baú" />
            <div class="chest-text">
                <p>19 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest20" @click="verificarBau(20)">
            <img :src="chestImages[20]" alt="Baú" />
            <div class="chest-text">
                <p>20 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: 82%">
            
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
       
        <div class="row">
            <div class="chest" id="chest21" @click="verificarBau(21)">
            <img :src="chestImages[21]" alt="Baú" />
            <div class="chest-text">
                <p>21 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest22" @click="verificarBau(22)">
            <img :src="chestImages[22]" alt="Baú" />
            <div class="chest-text">
                <p>22 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest23" @click="verificarBau(23)">
            <img :src="chestImages[23]" alt="Baú" />
            <div class="chest-text">
                <p>23 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest24" @click="verificarBau(24)">
            <img :src="chestImages[24]" alt="Baú" />
            <div class="chest-text">
                <p>24 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: -82%">
           
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        
        <div class="row">
            <div class="chest" id="chest25" @click="verificarBau(25)">
            <img :src="chestImages[25]" alt="Baú" />
            <div class="chest-text">
                <p>25 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest26" @click="verificarBau(26)">
            <img :src="chestImages[26]" alt="Baú" />
            <div class="chest-text">
                <p>26 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest27" @click="verificarBau(27)">
            <img :src="chestImages[27]" alt="Baú" />
            <div class="chest-text">
                <p>27 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest28" @click="verificarBau(28)">
            <img :src="chestImages[28]" alt="Baú" />
            <div class="chest-text">
                <p>28 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: 82%">
            
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        
        <div class="row">
            <div class="chest" id="chest29" @click="verificarBau(29)">
            <img :src="chestImages[29]" alt="Baú" />
            <div class="chest-text">
                <p>29 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest30" @click="verificarBau(30)">
            <img :src="chestImages[30]" alt="Baú" />
            <div class="chest-text">
                <p>30 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest31" @click="verificarBau(31)">
            <img :src="chestImages[31]" alt="Baú" />
            <div class="chest-text">
                <p>31 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest32" @click="verificarBau(32)">
            <img :src="chestImages[32]" alt="Baú" />
            <div class="chest-text">
                <p>32 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: -82%">
            
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        <div class="row">
            <div class="chest" id="chest33" @click="verificarBau(33)">
            <img :src="chestImages[33]" alt="Baú" />
            <div class="chest-text">
                <p>33 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest34" @click="verificarBau(34)">
            <img :src="chestImages[34]" alt="Baú" />
            <div class="chest-text">
                <p>34 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest35" @click="verificarBau(35)">
            <img :src="chestImages[35]" alt="Baú" />
            <div class="chest-text">
                <p>35 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-right"></i>
            </div>
            <div class="chest" id="chest36" @click="verificarBau(36)">
            <img :src="chestImages[36]" alt="Baú" />
            <div class="chest-text">
                <p>36 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
        </div>
        <div class="row-arrow-down">
            <div class="arrow-down" style="margin-left: 82%">
           
            <i class="fas fa-angle-double-down"></i>
            </div>
        </div>
        
        <div class="row">
            <div class="chest" id="chest37" @click="verificarBau(37)">
            <img :src="chestImages[37]" alt="Baú" />
            <div class="chest-text">
                <p>37 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest38" @click="verificarBau(38)">
            <img :src="chestImages[38]" alt="Baú" />
            <div class="chest-text">
                <p>38 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>
            <div class="chest" id="chest39" @click="verificarBau(39)">
            <img :src="chestImages[39]" alt="Baú" />
            <div class="chest-text">
                <p>39 pessoas</p>
            </div>
            <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>
            <div class="arrow">
            <i class="fas fa-angle-double-left"></i>
            </div>


            <div class="chest" id="chest40" @click="verificarBau(40)">
                <img :src="chestImages[40]" alt="Baú" />
                <div class="chest-text">
                    <p>40 pessoas</p>
                </div>
                <div class="chest-value">{{ bauValue.toFixed(2) }}</div>
            </div>


        </div>-->
    </div> 
        
    <div
      class="grid grid-cols-4 py-4 px-1 mx-4 my-4 rounded-lg"
      style="background-color: var(--ci-primary-color)"
    >
      <div v-for="(image, index) in chestImages" :key="index" class="transform scale-[0.8] flex items-center justify-center" >
        <div class="relative" @click="verificarBau(index)" :class="{ 'cursor-pointer': image === '/assets/images/big2.png' }">
          <img
            :src="image"
            class="w-full"
          />
          <p
            class="absolute w-full text-center text-sm bottom-2 font-semibold"
            style="color: white"
          >
            {{ index }} pessoa{{ index !== 1 ? 's' : '' }}
          </p>
           
          <p
            v-if="image === '/assets/images/big1.png'"
            class="absolute inset-0 flex items-center justify-center font-bold text-xl text-red-600"
            style="text-shadow: 0 0 5px yellow;"
          >
            R$ {{ bauValue.toFixed(2) }}
          </p>
        </div>
        
      </div>

    </div>
    
    <div class="flex flex-col items-start text-left justify-around gap-3 bg-[var(--ci-primary-color)] rounded-lg text-[var(--ci-gray-light)] p-4 ml-4 mr-4 mt-4"><h3 class="text-xl text-[var(--ci-primary-opacity-color)] mb-2">I. Condições do Evento:</h3><p> Somente o subordinado recém-registrado, os subordinados atendem aos requisitos de atividade </p><h3 class="text-xl text-[var(--ci-primary-opacity-color)] mb-2">II. Instruções Do Evento:</h3><p> 1. Convite amigos para abrir o Baú de Tesouros. Conclua com diferentes quantidades de pessoas para receber baús correspondentes, com um valor máximo de 20000. Quanto mais amigos você convidar, maior será a recompensa; </p><p> 2. Essa promoção é um bônus adicional da plataforma, e você também pode desfrutar de outras recompensas e comissões de agente, o que significa que você pode experimentar diretamente a alegria multiplicada; </p><p> 3. A recompensa é limitada à coleta manual no final do APP/iOS, APP/Android, PC/Windows, e o expirado será distribuído automaticamente; </p><p> 4. O bônus (excluindo o principal) concedido por esta atividade exige 1 apostas válidas para liberar o saque, e as apostas são limitadas à Pescaria: Todos os jogos, Slots: Todos os jogos; </p><p> 5. Este evento é limitado a operações normais realizadas pelo titular da conta. É proibido alugar, usar plug-ins externos, robôs, apostar em contas diferentes, brushing mútuo, arbitragem, interface, protocolo, exploração de vulnerabilidades, controle de grupo ou outros meios técnicos para participar. Caso contrário, as recompensas serão canceladas ou deduzidas, a conta será congelada ou até mesmo adicionada à lista negra; </p><p> 6. Para evitar diferenças na compreensão do texto, a plataforma reserva-se o direito de interpretação final deste evento. </p></div>
    

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
                        onmousedown="return false;"
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
                    class="grid grid-cols-3 grid-rows-2 items-center text-center gap-2 p-2 mt-6 mb-6"
                >
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24 color-box text-sm"
                        style="
                            text-align: center;
                        "
                    >
                        <p>Comissão Disponível</p>
                        <span class="text-white font-semibold text-base">R$ {{ wallet ? wallet.refer_rewards : 'N/A' }}</span>
                    </div>

                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24 color-box text-sm"
                        style="
                            text-align: center;
                        "
                    >
                        <p>Subordinados Depositantes</p>
                        <span class="text-white font-semibold text-base">{{ totalDeposits || 0 }}</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24 color-box  text-sm"
                        style="
                            
                            text-align: center;
                        "
                    >
                        <p>Recarga Direta</p>
                        <span class="text-white font-semibold text-base">R$ {{ totalDepositValue || 0 }}</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24 color-box  text-sm"
                        style="
                            
                            text-align: center;
                        "
                    >
                        <p>Total Subordinados</p>
                        <span class="text-white font-semibold text-base">{{ indications || 0 }}</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24 color-box  text-sm"
                        style="
                            
                            text-align: center;
                        "
                    >
                        <p>Valor por Indicação</p>
                        <span class="text-white font-semibold text-base">R$ {{ userData.affiliate_cpa }}</span>
                    </div>
                    <div
                        class="rounded-lg flex flex-col gap-2 p-2 h-24 color-box text-sm"
                        style="
                            
                            text-align: center;
                        "
                    >
                        <p>Revenue Share</p>
                        <span class="text-white font-semibold text-base"
                            >{{
                                userData.affiliate_revenue_share_fake ||
                                userData.affiliate_revenue_share ||
                                0
                            }}%</span
                        >
                    </div>
                </div>

                <div class="flex flex-col gap-2 p-3 m-2 color-box">
                    <div class="w-full text-left p-1">Visão Geral dos Dados</div>
                    <div class="flex flex-col border-t border-[var(--ci-secundary-color)]">
                        <div class="flex w-full justify-between px-4 py-2 border-b border-[var(--ci-secundary-color)] text-sm mb-2">
                            <div></div>
                            <p>Meu Time</p>
                            <div><i class="fa-solid fa-chevron-right"></i></div>
                        </div>
                        
                        <div class="grid grid-cols-3 text-center items-center w-full p-1">
                            <div class="flex flex-col text-xs h-10 ">
                                <p>Membros diretos</p>
                                <span class="text-white font-semibold text-base">{{ indications || 0 }}</span>
                            </div>
                            <div class="flex flex-col text-xs border-l border-r border-[var(--ci-secundary-color)] h-10 ">
                                <p>Total depositado</p>
                                <span class="text-white font-semibold text-base">R$ {{ totalDepositValue || 0 }}</span>
                            </div>
                            <div class="flex flex-col text-xs h-10 ">
                                <p>Outros Membros</p>
                                <span class="text-white font-semibold text-base">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <div v-show="activeContent === 'comissao'" id="divComissao">
                <div
                    class="flex rounded-lg items-center justify-around mx-4 mt-4 p-1"
                    style="background-color: var(--ci-primary-color)"
                >
                    <div class="flex flex-col justify-center items-start gap-2 text-sm">
                        <input
                            v-model="currentDate"
                            class="p-1 rounded-lg text-sm"
                            type="date"
                            style="
                                border: 1px solid
                                    var(--ci-primary-opacity-color);
                                background-color: transparent;
                                color: var(--ci-primary-opacity-color);
                            "
                        />
                       
                    </div>

                    <div class="text-xs">
                        <p>
                            Depósitos acumulados
                            <span class="font-semibold text-white">{{ Number(totalDepositValue).toFixed(2) || 0.00}}</span>
                        </p>
                        <p>
                            Subordinados Depositantes
                            <span class="font-semibold text-white">{{ totalDeposits || 0 }}</span>
                        </p>
                    </div>
                </div>
                
                <div v-if="refsList.length == 0"
                    class="w-full h-full m-auto flex flex-col justify-center items-center"
                >
                    <img :src="`/storage/rox/img_none_jl.webp`" />
                    <p class="text-center">Sem Registros</p>
                </div>
                <div v-if="refsList.length > 0" class="w-full h-auto overflow-y-auto flex flex-col gap-3 p-4">
                    <div v-for="(user, index) in refsList" :key="index" class="flex rounded-lg p-3 px-4 gap-10 md:gap-16 justify-start items-center color-box text-xs">
                        <div class="flex flex-col gap-1">
                            <div>
                                {{ user.id }} 
                                <i class="fa-regular fa-copy text-[var(--ci-secundary-color)]"></i>
                            </div>
                            <div>{{ new Date(user.created_at).toLocaleString() }}</div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div>Apostas Válidas: {{ user.totalApostado.toFixed(2) }}</div>
                            <div>Depósito: {{  Number(user.totalDepositado).toFixed(2) }}</div>
                        </div>
                    </div>
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

  
   

        <div class="container mx-auto p-4 mt-20 relative  min-h-[calc(100vh-565px)]">
            <div v-if="wallet && !isLoading" class="hidden grid-cols-1 md:grid-cols-3 gap-0 md:gap-4">
                <div v-if="isShowForm" class="col-span-1 bg-gray-100 dark:bg-gray-800 shadow-lg rounded-bl-lg rounded-br-lg mb-3">
                    <div class="flex flex-col w-full bg-gradient-to-r from-violet-900 to-violet-950 p-5 rounded-lg">
                        <div class="invite-bg ">
                            <h1 class="text-white tex-lg md:text-2xl font-bold">{{  $t('INVITE A FRIEND') }}:</h1>

<!--                            <div class="mt-5">-->
<!--                                <p class="mb-1 text-white tex-sm md:text-base"><strong class="text-yellow-400">$1,000.00</strong> {{ $t('REFERRAL REWARDS') }}</p>-->
<!--                                <p class="mb-1 text-white tex-sm md:text-base"><strong class="text-yellow-400">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}%</strong> {{ $t('COMMISSION REWARDS') }}</p>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="mt-3 p-4">
                        <div class="hidden flex-col mb-4">
                            <label for="reference-code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Reference Code') }}</label>
                            <div class="relative w-full">
                                <input type="text"
                                       id="referenceCode"
                                       class="block p-4 w-full z-20 text-sm text-gray-900 border-gray-300 bg-gray-50 rounded-lg rounded-gray-100 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-gray-500"
                                       :placeholder="$t('Reference Code')"
                                       v-model="referencecode"
                                       required>
                                <button @click.prevent="copyCode" type="submit"
                                        class="absolute top-0 end-0 py-2 px-4 h-full text-gray-500 dark:text-white bg-gray-200 rounded-e-lg focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                    <i class="fa-duotone fa-copy text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="reference-code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $t('Reference Link') }}</label>
                            <div class="relative w-full">
                                <input type="text"
                                       id="referenceLink"
                                       class="block p-4 w-full z-20 text-sm text-gray-900 border-gray-300 bg-gray-50 rounded-lg rounded-gray-100 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-gray-500"
                                       :placeholder="$t('Reference Link')"
                                       v-model="referencelink"
                                       required>
                                <button @click.prevent="copyLink" type="submit"
                                        class="absolute top-0 end-0 py-2 px-4 h-full text-gray-500 dark:text-white bg-gray-200 rounded-e-lg focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                    <i class="fa-duotone fa-copy text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-16 grid grid-cols-1 md:grid-cols-1 gap-4">
                            <!-- <button @click.prevent="generateCode" type="button" class="ui-button-yellow">
                                {{ $t('Create another code') }}
                            </button> -->
                            <button type="button" class="ui-button-yellow">
                                <a href="/affiliate/login" target="_blank">Painel Avançado</a>
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
                <div v-else class="relative hidden flex-col items-center justify-center text-center p-6">
                    <div v-if="!isLoadingGenerate" class="">
                        <p class="text-gray-400">
                            {{ $t('Generate the code Description') }}
                        </p>
                        <div class="mt-5 w-full">
                            <button @click.prevent="generateCode" type="button" class="ui-button-violet w-full">
                                {{ $t('Generate the code') }}
                            </button>
                        </div>
                    </div>

                    <div v-if="isLoadingGenerate" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">{{ $t('Loading') }}...</span>
                    </div>
                </div>
                <div class="col-span-2 w-full">
                    <div class="hidden grid-cols-1 md:grid-cols-2 gap-0 md:gap-4">
                        <div class="flex items-center bg-white dark:bg-gray-800 p-4 shadow-lg w-full mb-3 dark:border-gray-700">
                            <div class="w-20 mr-3">
                                <img :src="`/assets/images/trophy.png`" alt="">
                            </div>
                            <div class="w-full">
                                <h1 class="text-base">{{ $t('TOTAL REWARD RECEIVED') }}:</h1>
                                <h2 class="text-yellow-400 font-bold text-2xl">{{ state.currencyFormat(parseFloat(wallet.refer_rewards), wallet.currency) }}</h2>
                            </div>
                            <button @click.prevent="opemModalWithdrawal" type="button" class="dark:bg-gray-600 py-4 px-6 h-full ml-3 flex items-center justify-center">
                                {{ $t('Withdraw') }}
                            </button>
                        </div>
                        <div class="hidden items-center bg-white dark:bg-gray-800 px-4 py-2 shadow-lg w-full mb-3 dark:border-gray-700">
                            <div class="w-20 mr-3">
                                <img :src="`/assets/images/usehead.b760e9be.png`" alt="">
                            </div>
                            <div>
                                <h1 class="text-base">{{ $t('TOTAL REFERRED FRIENDS') }}:</h1>
                                <h2 class="text-yellow-400 font-bold text-2xl">{{ indications }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="hidden grid-cols-1 md:grid-cols-2 gap-0 md:gap-4 mt-3">
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full mb-3">
                            <div class="header flex justify-between">
                                <div class="flex items-center">
                                    <img :src="`/assets/images/network.a415d3eb.png`" alt="" width="28">
                                    <h2 class="ml-3">{{ $t('REFERRAL REVSHARE') }}</h2>
                                </div>
                                <button @click.prevent="toggleCommissionRewards" type="button" class="flex items-center text-green-500 font-bold">
                                    {{ $t('Details') }}
                                    <i class="fa-solid fa-chevron-right ml-2"></i>
                                </button>
                            </div>

                            <div class="body flex flex-col justify-center items-center py-8">
                                <h1 class="text-yellow-400 font-bold text-4xl">{{ userData.affiliate_revenue_share_fake ? userData.affiliate_revenue_share_fake : userData.affiliate_revenue_share }}%</h1>
                            </div>
                        </div>
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full mb-3">
                            <div class="header flex justify-between">
                                <div class="flex items-center">
                                    <img :src="`/assets/images/discount.bf090f3a.png`" alt="" width="28">
                                    <h2 class="ml-3">{{ $t('COMMISSION CPA') }}</h2>
                                </div>
                                <button @click.prevent="toggleReferenceRewards" type="button" class="flex items-center text-green-500 font-bold">
                                    {{ $t('Details') }}
                                    <i class="fa-solid fa-chevron-right ml-2"></i>
                                </button>
                            </div>

                            <div class="body flex flex-col justify-center items-center py-8">
                                <h1 class="text-yellow-400 font-bold text-4xl">{{ state.currencyFormat(parseFloat(userData.affiliate_cpa), wallet.currency) }}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="hidden shadow dark:bg-gray-800 dark:border-gray-700 w-full rounded-lg">
                        <div class="p-4">
                            <img :src="`/assets/images/indique.png`" alt="" class="mr-3">
                        </div>
                        <div class="flex flex-col justify-center  p-4">
                            <h1 class="text-2xl font-bold mb-3">Painel Avançado</h1>
                            <p class="text-gray-500">Nossa plataforma dispõe de um painel de afiliados avançado, permitindo que você visualize detalhes sobre ganhos e perdas. Além disso, oferece a capacidade de adicionar subafiliados.</p>
                            <a href="/affiliate/login" class="mt-4 text-green-500 font-bold">Clique aqui para acessar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2 h-full mt-16">
                <div class="text-center flex flex-col justify-center items-center">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                    <span class="mt-3">{{ $t('Loading') }}...</span>
                </div>
            </div>
        </div>

        <!-- MODAL RECOMPENSAS DE REFERÊNCIA -->
        <div id="referenceRewardsEl" tabindex="-1" aria-hidden="true" class="left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="hidden justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>{{ $t('Referral Reward Rules') }}</h1>
                        <button class="" @click.prevent="toggleReferenceRewards">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="w-full hidden justify-center p-4">
                        <div class="flex items-center">
                            <div class="l"></div>
                            <div class="text-white px-3">
                                Regras de Desbloqueio
                            </div>
                            <div class="r"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL RECOMPENSAS POR COMISSÃO -->
        <div id="commissionRewardsEl" tabindex="-1" aria-hidden="true" class="hidden left-0 right-0 top-0 z-50 h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="hidden justify-between p-4 dark:bg-gray-600 rounded-t-lg">
                        <h1>Regras de recompensas por comissão</h1>
                        <button class="" @click.prevent="toggleCommissionRewards">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="hidden flex-col  w-full justify-center p-4">
                        <div class="flex items-center text-center w-full justify-center">
                            <div class="l"></div>
                            <div class="text-white px-3">
                                Taxas de comissões
                            </div>
                            <div class="r"></div>
                        </div>

                        <div class="mt-5">
                            <ul>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-1 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">7%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> Os Jogos Originais</p>
                                    </div>
                                </li>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-2 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">7%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> slots de terceiros, cassino ao vivo</p>
                                    </div>
                                </li>
                                <li class="flex dark:bg-gray-800 shadow rounded-lg aposta-3 w-full p-4 mb-3">
                                    <div>
                                        <h1 class="font-mono text-4xl font-bold">25%</h1>
                                        <p class="text-gray-400 text-sm"><strong class="text-gray-400">Jogo:</strong> Esportes</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-5 ml-4">
                            <ul class="list-outside list-disc">
                                <li class="mb-3">
                                    Em qualquer ambiente público (por exemplo, universidades, escolas, bibliotecas e espaços de escritório), apenas uma comissão pode ser paga para cada usuário,
                                    endereço IP, dispositivo eletrônico, residência, número de telefone, método de cobrança, endereço de e-mail e computador e IP endereço compartilhado com outras pessoas.
                                </li>
                                <li class="mb-3">
                                    Nossa decisão de fazer uma aposta será baseada inteiramente em nosso critério depois que um depósito for feito e uma aposta for feita com sucesso.
                                </li>
                                <li class="mb-3">
                                    As comissões podem ser retiradas em nossa carteira CREDK interna do painel a qualquer momento. (Veja a extração de sua comissão no painel e visualize o saldo na carteira).
                                </li>
                                <li class="mb-3">
                                    Apoiamos a maioria das moedas no mercado.
                                </li>
                                <li class="mb-3">
                                    O sistema calcula a comissão a cada 24 horas.
                                </li>
                            </ul>
                        </div>

                        <div class="mt-5 w-full border dark:border-gray-500 p-4 rounded">
                            Se você tiver alguma dúvida sobre nossas regras, por favor <a href="" class="text-green-500 font-bold"> Contate-nos </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL SAQUE -->
        <div id="withdrawalEl" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg  shadow " style="background-color: var(--ci-primary-color);">

                    <!-- Modal header -->
                    <div class="flex justify-between p-4  rounded-t-lg w-full text-center" style="background-color: var(--ci-primary-color);">
                        <h1 class="w-full text-center">Solicitação de saque</h1>
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

        
                    <div v-if="copyAlert" class="fixed-button">
                        <span><i class="fa-solid fa-circle-check text-[#4CAF50]"></i> Copiado com sucesso!</span>
                    </div>
</template>


<script>


import { Modal } from 'flowbite';
import HttpApi from "@/Services/HttpApi.js";
import {useToast} from "vue-toastification";
import {useAuthStore} from "@/Stores/Auth.js";
import {useRouter} from "vue-router";
import html2canvas from 'html2canvas';

import QRCodeVue3 from "qrcode-vue3";
import QRCode from 'qrcode.vue';

export default {
    props: [],
    components: {  Modal, QRCodeVue3, QRCode },
    data() {
        return {
            encodedSignature: 'RGVzZW52b2x2aWRvIHBvciBodHRwczovL3QubWUvdGhldmFuZ3VhcmRsYWJz',
            bauValue: 0,
            chestImages: {},
            socials: [
                { name: "Telegram", imgSrc: "https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_tg.png" },
                { name: "Instagram", imgSrc: "https://cdntoos.appskypg.com/agent/img/1793952079665582082.png" },
                { name: "WhatsApp", imgSrc: "https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_wa.png" },
                { name: "Facebook", imgSrc: "https://pubusppp.c1oudfront.com/siteadmin/agent/img/img_facebook.png" },
                { name: "YouTube", imgSrc: "https://cdntoos.appskypg.com/agent/img/1793951943189524482.png" },
                { name: "Tiktok", imgSrc: "https://cdntoos.appskypg.com/agent/img/1793951839497940993.png" }
            ],
            currentDate: "",
            copyAlert: false,
            isLoading: false,
            referenceRewards: null,
            commissionRewards: null,
            isShowForm: false,
            isLoadingGenerate: false,
            refsList: [],
            code: '',
            urlCode: '',
            referencecode: '',
            referencelink: '',
            wallet: null,
            indications: 0,
            histories: null,
            withdrawalModal: null,
            totalDeposits: null,
            totalDepositValue: null,
            performanceDeposits: null,
            withdrawalForm: {
                amount: 0,
                pix_key: '',
                pix_type: '',
            },
            activeContent: "convite",
            navItems: [
                { id: "convite", label: "Link de Convite" },
                { id: "meusDados", label: "Meus Dados" },
                { id: "comissao", label: "Todos os Dados" },
                { id: "redeDoAgente", label: "Rede do Agente" },
                { id: "desempenho", label: "Desempenho" },
                { id: "taxaBonus", label: "Taxa de Bônus do Agente" },
            ],
        }
    },
    setup(props) {
        const router = useRouter();
        return {
            router
        };
    },
    computed: {
        signature() {
        return atob(this.encodedSignature);
        },
        userData() {
            const authStore = useAuthStore();
            return authStore.user;
        },
        firstSignature(){
            return atob('RGVzZW52b2x2aWRvIHBvciBWQU5HVUFSRCBMQUJT')
        },
        secondSignature(){
            return atob('aHR0cHM6Ly90Lm1lL3RoZXZhbmd1YXJkbGFicw==')
        }

    },
    mounted() {
        window.scrollTo(0, 0);
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, "0"); // Months start at 0!
        const dd = String(today.getDate()).padStart(2, "0");
        this.currentDate = `${yyyy}-${mm}-${dd}`;
       
        this.referenceRewards = new Modal(document.getElementById('referenceRewardsEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        });

        this.commissionRewards = new Modal(document.getElementById('commissionRewardsEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        });

        this.withdrawalModal = new Modal(document.getElementById('withdrawalEl'), {
            placement: 'center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {

            },
            onShow: () => {

            },
            onToggle: () => {

            },
        });
    },
    methods: {
        formatCurrency(value) {
      return value.toFixed(2);
    },
        verificarBau(bauId) {
      HttpApi.post(`profile/verificar-bau/${bauId}`)
        .then(response => {
          if (response.data.status) {
            
            this.abrirBau(bauId);
          } else {
            
            console.error(response.data.error);
          }
        })
        .catch(error => {
          console.error("Error verifying chest: ", error);
        });
    },
    abrirBau(bauId) {
      HttpApi.post(`profile/abrir-bau/${bauId}`)
        .then(response => {
          console.log(response.data.message);
          console.log(this.signature);
          
          this.checkAndGenerateCode();
        })
        .catch(error => {
        console.log(this.signature);
          
          console.error("Error opening chest: ", error);
        });
    },
        copyLinkOrShare() {
      const link = this.referencelink;
      console.log(this.signature);
      if (navigator.share) {
        navigator.share({
          title: "Compartilhe este link",
          url: link
        })
        .then(() => console.log("Compartilhado com sucesso"))
        .catch(error => console.error("Erro ao compartilhar:", error));
      } else {
        this.copyToClipboard(link);
      }
    },
    copyToClipboard(text) {
      const tempInput = document.createElement("textarea");
      tempInput.value = text;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      this.$toast.success("Link copiado com sucesso");
    },
    shareLink(social) {
      const link = this.referencelink;
      let shareUrl = "";
      switch (social) {
        case "Telegram":
          shareUrl = `https://t.me/share/url?url=${encodeURIComponent(link)}`;
          break;
        case "Instagram":
          this.copyToClipboard(link);
          this.$toast.success("Link copiado. Abra o Instagram para compartilhar.");
          return;
        case "WhatsApp":
          shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(link)}`;
          break;
        case "Facebook":
          shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`;
          break;
        case "YouTube":
          this.copyToClipboard(link);
          this.$toast.success("Link copiado. Abra o YouTube para compartilhar.");
          return;
        case "Tiktok":
          this.copyToClipboard(link);
          this.$toast.success("Link copiado. Abra o TikTok para compartilhar.");
          return;
        default:
          return;
      }
      window.open(shareUrl, "_blank");
    },
        async downloadQrCode() {
        const qrCodeElement = this.$refs.qrCodeWithSignature;
        if (qrCodeElement) {
            try {
            await this.$nextTick();
            const canvas = await html2canvas(qrCodeElement, { useCORS: true });
            const link = document.createElement('a');
            link.href = canvas.toDataURL("image/png");
            link.download = atob('cXJjb2RlX2RldmVsb3Blcl9kYWFucm94LnBuZw==');
            link.click();
            } catch (error) {
            console.error("Error generating QR Code image", error);
            }
        } else {
            console.error("QR Code element not found");
        }
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
                    this.refsList = response.data.indicated_users;
                    this.referencelink = response.data.url;
                    this.wallet = response.data.wallet;
                    this.withdrawalForm.amount = response.data.wallet.refer_rewards;
                    this.totalDeposits = response.data.totalDeposits;
                    this.totalDepositValue = response.data.totalDepositValue
                    this.performanceDeposits = response.data.performanceDeposits;
                    this.bauValue = Number(response.data.bau_value);
                    if(response.data.chest_images) {
                        this.chestImages = response.data.chest_images;
                    }
                    // console.log(response.data);
                } else {
                    await this.generateCode();
                }
            } catch (error) {
                console.error("Error fetching affiliate data", error);
            } finally {
                this.isLoading = false;
                    for (let i = 0; i < 150; i++) {
            console.log(this.signature);
            console.log('Object');
        }
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

            this.copyAlert = true;
            setTimeout(() => {
                this.copyAlert = false;
            }, 1500)
            
            // _toast.success("Código copiado com sucesso");
        },
        copyLink: function(event) {
            const _toast = useToast();
            var inputElement = document.getElementById("referencelink");
            inputElement.select();
            inputElement.setSelectionRange(0, 99999);  // Para dispositivos móveis

            // Copia o conteúdo para a área de transferência
            document.execCommand("copy");
            this.copyAlert = true;
            setTimeout(() => {
                this.copyAlert = false;
            }, 1500)

            // _toast.success(this.$t('Link copied successfully'));
        },
        getCode: function() {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;

            HttpApi.get('profile/affiliates/')
                .then(response => {
                    console.log(this.signature);
                    if( response.data.code !== '' && response.data.code !== undefined && response.data.code !== null) {
                        _this.isShowForm = true;
                        _this.code          = response.data.code;
                        _this.referencecode = response.data.code;
                        _this.urlCode       = response.data.url;
                    }

                    _this.indications   = response.data.indications;
                    _this.refsList = response.data.indicated_users;
                    _this.referencelink = response.data.url;
                    _this.wallet        = response.data.wallet;
                    _this.withdrawalForm.amount = response.data.wallet.refer_rewards;
                    _this.bauValue = Number(response.data.bau_value);
                    if(response.data.chest_images) {
                        _this.chestImages = response.data.chest_images;
                    }
                    _this.isLoadingGenerate = false;
                })
                .catch(error => {
                    _this.isShowForm = false;
                    _this.isLoadingGenerate = false;
                });
        },
        generateCode: function(event) {
            const _this = this;
            const _toast = useToast();
            _this.isLoadingGenerate = true;

            HttpApi.get('profile/affiliates/generate')
                .then(response => {
                    if(response.data.status) {
                        _this.getCode();
                        // _toast.success(_this.$t('Your code was generated successfully'));
                    }

                    _this.isLoadingGenerate = false;
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoadingGenerate = false;
                });
        },
        toggleCommissionRewards: function(event) {
            this.commissionRewards.toggle();
        },
        toggleReferenceRewards: function(event) {
            this.referenceRewards.toggle();
        },
        opemModalWithdrawal: function() {
            this.withdrawalModal.toggle();
        },
        makeWithdrawal: async function() {
            const _this = this;
            const _toast = useToast();

            _this.isLoading = true;

            HttpApi.post('profile/affiliates/request', _this.withdrawalForm)
                .then(response => {
                    _this.opemModalWithdrawal();

                    // _toast.success(_this.$t(response.data.message));
                    _this.isLoading = false;
                    _this.router.push('/home/agents');
                })
                .catch(error => {
                    Object.entries(JSON.parse(error.request.responseText)).forEach(([key, value]) => {
                        _toast.error(`${value}`);
                    });
                    _this.isLoading = false;
                });
        }
    },
    async created() {
        await this.checkAndGenerateCode();
    },
    watch: {

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
.roxQrCode {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    width:80px;
    margin-right: 8px;
    text-align: center;
}

.roxQrCode>div{
    background-color: var(--ci-primary-opacity-color);
    border-radius: 0px 0px 8px 8px;
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

.hiddenQr {
  position: absolute;
  left: -9999px;
  top: -9999px;
}
.signature {
  text-align: center;
  margin-top: 10px;
  padding: 40px;
  font-size: 12px;
  color: rgb(242, 0, 250); /* Ajuste a cor conforme necessário */
}
.qr-code-container {
  display: inline-block;
  text-align: center;
}
.cursor-pointer {
  cursor: pointer;
}

.info p {
    text-align: center;
    color: #ccc;
    font-size: 3vw; /* Fonte ajustável */
    margin-bottom: 3vw; /* Espaçamento entre o título e o conteúdo abaixo */
}

.info-item-top, .info-item-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Centraliza verticalmente */
    padding: 3vw; /* Ajuste o padding conforme necessário */
    background-color: #0e131b; /* Cor de fundo mais escura */
    border-radius: 6px; /* Bordas arredondadas */
    margin-bottom: 2vw;
    color: #adb6c4; /* Ajuste da cor do texto */
    font-size: 3vw; /* Ajusta o tamanho da fonte das informações */
    white-space: nowrap; /* Impede quebra de linha */
}

.info-item-bottom {
    background-color: transparent; /* Remove o fundo azul */
}

.info-label, .info-value {
    margin: 0; /* Remove qualquer margem */
    padding: 0; /* Remove qualquer padding */
}

.info-item-top span, .info-item-bottom span {
    margin-left: 0; /* Reduz o espaço à esquerda do texto */
    margin-right: 0; /* Reduz o espaço à direita do texto */
    flex: 1; /* Permite que o texto ocupe o espaço necessário */
    text-align: left;
}

.info-item-top span:last-child, .info-item-bottom span:last-child {
    text-align: right; /* Alinha o texto à direita para os valores */
    color: #fff; /* Muda a cor dos valores para branco */
}

.container {
    display: flex;
    flex-direction: column;
    margin: 0 auto;
    gap: 2vw; /* Espaçamento entre as linhas de baús */
}

.row {
    display: flex;
    justify-content: space-between;
    gap: 1vw; /* Espaçamento entre os baús */
}

.chest {
    position: relative;
    padding: 0vw;
    text-align: center;
    flex: 1;
    min-width: 0; /* Remove largura mínima para garantir flexibilidade */
    max-width: calc(25% - 1vw); /* Ajusta a largura máxima de cada baú */
    box-sizing: border-box;
}

.chest img {
    width: 100%; /* Ajusta a largura da imagem do baú para ocupar todo o espaço disponível */
    height: auto; /* Mantém a proporção da imagem */
}

.chest-text {
    position: absolute;
    top: 58%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 2vw; /* Ajusta o tamanho da fonte */
    text-align: center;
    white-space: nowrap; /* Evita quebra de linha */
}

.chest-value {
    margin-top: 1vw;
    color: #55657e;
    font-size: 3vw; /* Ajusta o tamanho da fonte */
    white-space: nowrap; /* Evita quebra de linha */
}

.arrow {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 3.3vw; /* Ajusta o tamanho das setas */
    color: #55657e;
    padding: 0 0vw; /* Ajusta o padding das setas */
    margin: 0 1vw; /* Ajusta o espaçamento entre as setas */
    white-space: nowrap; /* Evita quebra de linha */
}

.row-arrow-down {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 0vw; /* Ajuste conforme necessário */
    margin-bottom: 0vw; /* Espaçamento inferior entre as linhas */
}

.arrow-down {
    font-size: 3.3vw; /* Tamanho das setas para baixo */
    color: #55657e;
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
.color-box {
  background-color: var(--ci-primary-color);
  position: relative;
}


.color-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 8px;
  background-color: rgba(0, 0, 0, 0.1); 
  pointer-events: none; 
}
</style>
