<template>
    <div class="w-full max-w-xl mx-auto">
      <div
        class="w-full flex justify-between p-4 items-center"
        style="
          background-color: var(--ci-primary-color);
          border-bottom: 1px solid var(--ci-secundary-color);
        "
      >
        <div @click="goBack"><i class="fa-solid fa-chevron-left cursor-pointer"></i></div>
        <div><p class="text-2xl">Sobre</p></div>
        <div><p></p></div>
      </div>
  
      <div class="flex justify-between my-4 mx-4 rounded-lg">
        <p class="text-center w-full border border-[var(--ci-primary-opacity-color)] p-2 rounded-lg">{{ description }}</p>
      </div>
  
      <BottomNavComponent/>
    </div>
  </template>


<script>
import BottomNavComponent from "@/Components/Nav/BottomNavComponent.vue";
import HttpApi from "@/Services/HttpApi.js";

export default {
  components: { BottomNavComponent },
  data() {
    return {
      isLoading: false,
      description: '',
    };
  },
  mounted() {
    this.getDescription();
  },
  methods: { goBack() {
      this.$router.go(-1);
    },
    getDescription() {
      const setting = JSON.parse(localStorage.getItem('setting'));
      if (setting && setting.software_description) {
        this.description = setting.software_description;
      }
    }
  }
};
</script>

<style scoped>

</style>
