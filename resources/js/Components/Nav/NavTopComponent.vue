<template>
  <nav class="top-nav">
    <ul>
      <li><a href="/">Home</a></li>
      <li><a href="/about">Sobre</a></li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "NavTopComponent",
};
</script>

<style scoped>
.top-nav {
  background-color: #333;
  color: white;
  padding: 10px;
}

.top-nav ul {
  list-style-type: none;
  padding: 0;
}

.top-nav li {
  display: inline;
  margin-right: 20px;
}

.top-nav a {
  color: white;
  text-decoration: none;
}
</style>