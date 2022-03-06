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
        <input type="password" v-model="user.password_confirmation" placeholder="enter password again">
      </div>
      <button type="button" v-on:click="sendEmail">Update Password</button>
      <p>{{message}}</p>
    </form>
  </div>
</template>


<script>
import Joi from "joi";
import * as toastr from "toastr";
import {createUserAccount, forgotPassword, updatePassword} from "../../api/registration";
import {performAfterAuthSteps} from "../../helpers/general-helper";

export default {
  name: "update-password",
  data(){
    return {
      user:{
        email: "",
        password:"",
        password_confirmation:""
      },
      message:""
    }
  },
  methods:{
    sendEmail(){
      if (!this.validateUser())
        return;

      //updatePassword
      this.updatePassword();
    },
    validateUser() {
      const schema = Joi.object({
        "email": Joi.string().email({tlds: {allow: false}}).required(),
        "password": Joi.string().pattern(new RegExp('^[a-zA-Z0-9]{3,30}$'))
          .message({
            "string.pattern.base": "Password must have length between 3 to 30 characters and contain both numbers and alphabets"
          }),
        "password_confirmation": Joi.any().valid(Joi.ref('password')).required().messages({
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
    updatePassword(){
      updatePassword({...this.user,"token":this.$route.params.token})
        .then((response) => {
          this.message = "Password has been updated successfully.";
        });
    }
  }
}
</script>
