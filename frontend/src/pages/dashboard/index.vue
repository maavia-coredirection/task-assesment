<template>
  <div>
    <button v-on:click="logout">logout</button>
    <ul>
      <li v-for="link in links">
        <router-link v-bind:to="link.to">{{ link.text }}</router-link>
      </li>
    </ul>
    <div>
      <router-view name="default"></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: "dashboard",
  data() {
    return {
      links: [{
        to: "/dashboard/product",
        text: "product"
      }, {
        to: "/dashboard/product-listing",
        text: "product listing"
      }]
    }
  },
  methods: {
    logout() {
      this.$store.dispatch("auth/removeAuthTokenAction")
        .then(() => {
          this.$router.go("/login");
        });
    }
  }
}
</script>

<style scoped>
.router-link-active {
  color: red
}
</style>
