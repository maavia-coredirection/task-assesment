<template>
  <div>
    <form>
      <div>
        <label>email:</label>
        <input type="text" v-model="user.email" placeholder="enter email">

      </div>
      <button type="button" v-on:click="sendEmail">send email</button>
      <p>{{message}}</p>
    </form>
  </div>
</template>


<script>
import Joi from "joi";
import * as toastr from "toastr";
import {createUserAccount, forgotPassword} from "../../api/registration";
import {performAfterAuthSteps} from "../../helpers/general-helper";

export default {
  name: "forgot-password",
  data(){
    return {
      user:{
        email: "",
      },
      message:""
    }
  },
  methods:{
    sendEmail(){
      if (!this.validateUser())
        return;

      //forgotPassword
      this.forgotPassword();
    },
    validateUser() {
      const schema = Joi.object({
        "email": Joi.string().email({tlds: {allow: false}}).required()
      }).unknown(true);

      const {error} = schema.validate(this.user);

      if (error) {
        toastr.error(error);
        return false;
      }
      return true;
    },
    forgotPassword(){
      forgotPassword(this.user)
        .then((response) => {
          this.message = response.message;
        });
    }
  }
}
</script>
