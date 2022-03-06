<template>
  <div>
    <form>
      <div>
        <label>email:</label>
        <input type="text" v-model="user.email" placeholder="enter email">
      </div>
      <div>
        <label>Password:</label>
        <input type="password" v-model="user.password" placeholder="enter password">
      </div>
      <button type="button" v-on:click="login">Login</button>
    </form>
    <button v-on:click="$router.push('/sign-up')">sign-up ?</button>
    <button v-on:click="$router.push('/forgot-password')">forgot password ?</button>
  </div>
</template>

<script>

import {loginUser} from "../../api/registration";
import {performAfterAuthSteps} from "../../helpers/general-helper";

export default {
  name: "login",
  data() {
    return {
      user: {
        email: "maavia@yahoo.com",
        password: "123456"
      }
    }
  },
  methods: {
    login() {
      loginUser(this.user)
        .then((response) => {
          performAfterAuthSteps(this.$store, this.$router, response.access_token)
        });
    }
  }
}
</script>
