<template>

  </template>
  
  <script>
  export default {
    data() {
      return {
        gains: [
          
        ]
      };
    }
  };
  </script>
  
 
<style scoped>
.container {
  display: flex;
  justify-content: center;
}

.gains-slider-container {
  width: 100%;
  max-width: 1200px; /* Defina a largura máxima do container */
  height: auto;
  display: flex;
  justify-content: space-between;
}

.gains-section {
  width: 300px;
  height: 100px;
  background: linear-gradient(90deg, rgba(255, 172, 75, 0.25) 0%, rgba(255, 172, 75, 0) 100%);
  z-index: 10;
  display: flex;
  align-items: center;
  gap: 15px;
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
}

.icon-trofeu img {
  width: 90px;
}

.title-gains h1 {
  color: #fff;
  font-weight: 800;
  font-size: 25px;
}

.gains-con {
  width: calc(100% - 300px);
  overflow: hidden;
}

.gains-slider {
  overflow: hidden;
  padding-left: 300px;
  white-space: nowrap;
  position: relative;
  display: flex;
}

.gains-slider:before,
.gains-slider:after {
  position: absolute;
  top: 0;
  width: 250px;
  height: 100%;
  content: "";
  z-index: 2;
}

.gains-slider:before {
  left: 0;
}

.gains-slider:after {
  right: 0;
}

.gains-slider:hover .logos-slide {
  animation-play-state: paused;
}

.logos-slide {
  display: flex;
  animation: slide 35s infinite linear;
}

.slide-gains {
  background-color: #1e2024;
  margin-right: 15px;
  width: 200px;
  overflow: hidden;
  border-radius: 6px;
  display: flex;
  align-items: center;
  gap: 10px;
  height: 100%;
}

.slide-gains .player {
  font-family: Arial, sans-serif;
  color: #fff;
  font-weight: 500;
  font-size: 12px;
}

.slide-gains .game {
  font-family: Arial, sans-serif;
  color: #fff;
  font-size: 10px;
  margin: 0;
}

.slide-gains img {
  height: 100%;
  border-radius: 6px;
}

.slide-gains .valor {
  font-size: 15px;
  color: #ff0;
}

.logos-slide img {
  height: 100px;
}

@keyframes slide {
  0% {
    transform: translate(0);
  }
  to {
    transform: translate(-100%);
  }
}

@media only screen and (max-width: 600px) {
  .gains-section {
    width: 170px;
    height: 85px;
  }

  .icon-trofeu img {
    width: 60px;
  }

  .title-gains h1 {
    font-size: 14px;
  }

  .gains-slider {
    padding-left: 170px;
  }

  .slide-gains {
    height: 85px;
  }

  .gains-con {
    width: calc(100% - 170px);
    overflow: hidden;
  }
}
</style>
  