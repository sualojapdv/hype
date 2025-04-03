<template>
  <div class="item-game-container">
    <RouterLink :to="{ name: 'casinoPlayPage', params: { id: game.id, slug: game.game_code }}" class="item-game text-gray-700 w-full h-auto mr-4 cursor-pointer" @mouseover="showIcon = true" @mouseleave="showIcon = false">
      <div class="relative w-full h-full">
        <img :src="game.distribution === 'kagaming' ? game.cover : `/storage/`+game.cover" alt="" class="w-full" style="border-radius: 15px;">
        <div v-if="showIcon" class="bdc">
          <i class="fa-solid fa-circle-play"></i>
        </div>
      </div>
    </RouterLink>
  </div>
</template>

<script>
import { RouterLink } from "vue-router";

export default {
  props: ['index', 'game'],
  components: { RouterLink },
  data() {
    return {
      showIcon: false
    }
  },
  methods: {},
  mounted() {}
};
</script>

<style scoped>
.item-game-container {
  display: flex;
  flex-direction: column;
  align-items: flex-start; 
}

.item-game {
  position: relative;
  border-radius: 15px !important;
  background-color: var(--ci-primary-color) !important;
}

.bdc {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.45); /* Fundo semitransparente */
  border-radius: 15px; /* Mesma borda arredondada que o card */
  display: flex;
  align-items: center;
  justify-content: center;
}

.bdc i {
  font-size: 3rem; /* Ajuste o tamanho conforme necessário */
  color: var(--ci-primary-color);
  z-index: 1; /* Garante que o ícone esteja acima do backdrop */
}

.item-game img {
  display: block;
  border-radius: 15px;
}
</style>
