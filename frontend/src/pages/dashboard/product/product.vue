<template>
  <div>
    <form>
      <div>
        <label>Name:</label>
        <input type="text" v-model="product.name" placeholder="enter name">
      </div>
      <div>
        <label>Price:</label>
        <input type="number" v-model="product.price" placeholder="enter price">
      </div>
      <div>
        <label>Upc:</label>
        <input type="text" v-model="product.upc" placeholder="enter upc">
      </div>
      <div>
        <label>Status</label>
        <input type="radio" v-bind:value="'available'" v-model="product.status">available
        <input type="radio" v-bind:value="'not-available'" v-model="product.status">not available
      </div>
      <div>
        <label>Status</label>
        <input type="file" accept="image/*" v-on:change="getFileFromInput">
        <img v-bind:src="getImage()" alt=""/>
      </div>
      <button type="button" v-on:click="submit">submit</button>
    </form>
  </div>
</template>


<script>
import Joi from "joi";
import * as toastr from "toastr";
import {createProduct, updateProduct, getProduct} from "../../../api/product";

const getEmptyProduct = () => ({
  id: null,
  name: "",
  price: "",
  upc: "",
  status: "",
  image: ""
});

export default {
  name: "product",
  data() {
    return {
      product: getEmptyProduct(),
    }
  },
  mounted() {
    if (this.$route.params.productId) {
      this.fetchProduct();
    }
  },
  methods: {
    getFileFromInput(event) {
      const file = event.target.files[0];
      this.product.image = file ? file : "";
    },
    submit() {
      if (!this.validateProduct())
        return;

      const formDataOfProduct = this.getFormDataOfProduct();
      const saveProduct = this.$route.params.productId ? updateProduct(formDataOfProduct, this.$route.params.productId) : createProduct(formDataOfProduct);
      saveProduct
        .then(_ => {
          toastr.success("Product saved successfully");
        });
    },
    validateProduct() {
      const schema = Joi.object({
        "name": Joi.string()
          .min(1)
          .max(30)
          .required()
          .messages({
            "string.base": "Name is required",
            "string.empty": "Name is required"
          }),
        "price": Joi.number()
          .required()
          .messages({
            "string.base": "Price is required",
            "string.empty": "Price is required"
          }),
        "upc": Joi.string()
          .min(1)
          .max(30)
          .required()
          .messages({
            "string.base": "Upc is required",
            "string.empty": "Upc is required"
          }),
        "status": Joi.string().valid('available', 'not-available').required()
          .messages({
            "any.only": "Please select Status"
          }),
        "image": Joi.any().custom((value, helper) => {
          if (typeof value === "string") {
            if (!value.length)
              return helper.message("Please select image for product");
            return true;
          }
          if (!value.name) {
            return helper.message("Please select image for product");
          } else {
            return true
          }
        })
      }).unknown(true);

      const {error} = schema.validate(this.product);

      if (error) {
        toastr.error(error);
        return false;
      }
      return true;
    },
    fetchProduct() {
      getProduct(this.$route.params.productId)
        .then((product) => {
          this.product = product.data;
        });
    },
    getFormDataOfProduct() {
      const formData = new FormData();
      for (const key in this.product) {
        formData.append(key, this.product[key]);
      }
      this.$route.params.productId && formData.append("_method", "PUT");
      return formData;
    },
    getImage() {
      if (typeof this.product.image === "object") {
        return URL.createObjectURL(this.product.image);
      } else {
        return `https://3747-39-42-99-236.ngrok.io/storage/uploads/${this.product.image}`;
      }
    }
  },
  watch: {
    "$route.params.productId"(currVal) {
      if (currVal)
        this.fetchProduct();
    }
  }
}
</script>

<style scoped>
img {
  width: 50px;
}
</style>
