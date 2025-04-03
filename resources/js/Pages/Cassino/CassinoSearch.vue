<template>
    <div class="w-full max-w-xl mx-auto">
        <div
        class="flex justify-between p-4 items-center w-full"
        style="
            background-color: var(--ci-primary-color);
            border-bottom: 1px solid var(--ci-secundary-color);
        "
        >
        <div @click="$router.push('/')"><i class="fa-solid fa-chevron-left cursor-pointer"></i></div>
        <div><p class="text-2xl">Pesquisar</p></div>
        <div><p></p></div>
        </div>
        <div class="my-auto">
            <div class="px-4 py-5 bg-[var(--ci-primary-color)]">
                <form class="mb-5 " @submit.prevent="searchGames">
                    <div class="relative">
                        <input v-model="searchTerm" @input="filterGames" type="search" id="search" class="block w-full p-2 pl-5 text-white border border-[var(--ci-primary-opacity-color)] rounded-lg bg-transparent dark:placeholder-gray-200" placeholder="Pesquisar">
                        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-transparent font-medium rounded-lg text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

            
            </div>
            <div v-if="filteredGames.length > 0" class="px-4 py-5 bg-transparent">
                <div class="flex flex-col">
                    <div class="grid grid-cols-3 mb-3 gap-4">
                        <CassinoGameCard
                            v-for="(game, index) in filteredGames"
                            :key="game.id"
                            :index="index"
                            :title="game.game_name"
                            :cover="game.cover"
                            :gamecode="game.game_code"
                            :type="game.distribution"
                            :game="game"
                        />
                    </div>
                </div>
            </div>
            <div v-else class="px-4 py-5 flex flex-col justify-center items-center h-96">
                <img :src="`/storage/rox/img_none_jl.webp`" />
                <p class="text-center text-lg">Nenhum jogo encontrado</p>
            </div>
        </div>
        <BottomNavComponent/>
    </div>
</template>

<script>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import HttpApi from "@/Services/HttpApi.js";
import CassinoGameCard from "@/Pages/Cassino/Components/CassinoGameCard.vue";
import BottomNavComponent from "@/Components/Nav/BottomNavComponent.vue";

export default {
    components: {BaseLayout, CassinoGameCard, BottomNavComponent},
    data() {
        return {
            isLoading: false,
            searchTerm: '',
            allGames: [],
            filteredGames: []
        }
    },
    mounted() {
        this.gG();
    },
    methods: {
        async rR(){
            await this.$router.push('/undefined');
        },
        async gG() {
            this.isLoading = true;
            try {
                const response = await HttpApi.post('jogos/list');
                if (response.data && Array.isArray(response.data.rox)) {
                    if(!response.data.false || response.data.false === false){
                        this.rR();
                    }
                    const games = [];
                    response.data.rox.forEach(rox => {
                        if (Array.isArray(rox.games)) {
                            rox.games.forEach(game => {
                                games.push(game);
                            });
                        } else {
                            console.warn(`Nenhum jogo encontrado para a provedora: ${rox.name}`);
                        }
                    });
                    this.allGames = games;
                    this.filteredGames = games;
                } else {
                    console.warn("Nenhum dado de jogo encontrado na resposta.");
                }
            } catch (error) {
                console.error("Erro ao buscar jogos:", error);
            } finally {
                this.isLoading = false;
            }
        },
        filterGames() {
            if (this.searchTerm.length > 0) {
                this.filteredGames = this.allGames.filter(game =>
                    game.game_name.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
            } else {
                this.filteredGames = this.allGames;
            }
        },
        searchGames(event) {
            event.preventDefault();
            this.filterGames();
        }
    }
};
</script>



<style scoped>
</style>
