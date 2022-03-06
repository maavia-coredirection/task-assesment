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
      <div>
        <label>Confirm Password:</label>
        <input type="password" v-model="user.confirmPassword" placeholder="enter password again">
      </div>
      <button type="button" v-on:click="Signup">Signup</button>
    </form>
    <button v-on:click="$router.push('/login')">login ?</button>
  </div>
</template>

<script>

import Joi from "joi";
import * as toastr from "toastr";
import {createUserAccount} from "../../api/registration";
import {performAfterAuthSteps} from "../../helpers/general-helper";

export default {
  name: "signup",
  data() {
    return {
      user: {
        email: "",
        name: "Maavia",
        password: "",
        confirmPassword: ""
      }
    }
  },
  methods: {
    Signup() {
      if (!this.validateUser())
        return;
      this.createUser();
    },
    validateUser() {
      const schema = Joi.object({
        "email": Joi.string().email({tlds: {allow: false}}).required(),
        "password": Joi.string().pattern(new RegExp('^[a-zA-Z0-9]{3,30}$'))
          .message({
            "string.pattern.base": "Password must have length between 3 to 30 characters and contain both numbers and alphabets"
          }),
        "confirmPassword": Joi.any().valid(Joi.ref('password')).required().messages({
          "any.only": "Confirm password must match password"
        }),
      }).unknown(true);

      const {error} = schema.validate(this.user);

      if (error) {
        toastr.error(error);
        return false;
      }
      return true;
    },
    createUser() {
      createUserAccount(this.user)
        .then((response) => {
          this.$router.push('/login')
        });
    }
  }
}
</script>
