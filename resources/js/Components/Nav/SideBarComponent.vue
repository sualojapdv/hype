<template>
  <div class="sidebar">
    <ul>
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/settings">Configurações</a></li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "SideBarComponent",
};
</script>

<style scoped>
.sidebar {
  width: 200px;
  background-color: #f4f4f4;
  padding: 20px;
}

.sidebar ul {
  list-style-type: none;
  padding: 0;
}

.sidebar li {
  margin: 10px 0;
}

.sidebar a {
  text-decoration: none;
  color: #333;
}
</style>