<template>
  <footer class="bottom-nav">
    <ul>
      <li><a href="/contact">Contato</a></li>
      <li><a href="/privacy-policy">Política de Privacidade</a></li>
    </ul>
  </footer>
</template>

<script>
export default {
  name: "BottomNavComponent",
};
</script>

<style scoped>
.bottom-nav {
  background-color: #222;
  color: white;
  padding: 10px;
  position: fixed;
  width: 100%;
  bottom: 0;
  left: 0;
}

.bottom-nav ul {
  list-style-type: none;
  padding: 0;
  text-align: center;
}

.bottom-nav li {
  display: inline;
  margin-right: 20px;
}

.bottom-nav a {
  color: white;
  text-decoration: none;
}
</style>