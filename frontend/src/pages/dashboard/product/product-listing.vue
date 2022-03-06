<template>
  <div>
    <table>
      <thead>
      <tr>
        <td>
          Sr#
        </td>
        <td>
          name
        </td>
        <td>
          price
        </td>
        <td>
          upc
        </td>
        <td>
          status
        </td>
        <td>
          image
        </td>
        <td>
          update
        </td>
        <td>
          delete all: <input type="checkbox" v-model="checkAllProductsToDelete" v-on:change="deleteAllProductOnChange"/>
        </td>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(product, index) in products">
        <td>
          {{ index + 1 }}
        </td>
        <td>
          {{ product.name }}
        </td>
        <td>
          {{ product.price }}
        </td>
        <td>
          {{ product.upc }}
        </td>
        <td>
          {{ product.status }}
        </td>
        <td>
          <img v-bind:src="`https://3747-39-42-99-236.ngrok.io/storage/uploads/${product.image}`" alt="">
        </td>
        <td>
          <button v-on:click="updateProduct(product)">edit</button>
        </td>
        <td>
          <input type="checkbox" v-bind:value="product.id" v-model="productIdsToDelete"/>
        </td>
      </tr>
      </tbody>
    </table>
    <button v-if="productIdsToDelete.length" v-on:click="deleteSelectedProducts">delete selected product(s)</button>
  </div>
</template>

<script>
import * as toastr from "toastr";
import {deleteProducts, getProducts} from "../../../api/product";

export default {
  name: "listing",
  data() {
    return {
      products: [],
      productIdsToDelete: [],
      checkAllProductsToDelete: false
    }
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      return getProducts()
        .then((products) => {
          this.products = products.data;
        });
    },
    updateProduct(product) {
      this.$router.push(`/dashboard/product/${product.id}`);
    },
    deleteAllProductOnChange() {
      if (this.checkAllProductsToDelete) {
        this.productIdsToDelete = this.products.map(product => product.id);
      } else {
        this.productIdsToDelete = [];
      }
    },
    deleteSelectedProducts() {
      return deleteProducts(this.productIdsToDelete)
        .then(() => {
          return this.fetchProducts();
        }).then(() => {
          this.productIdsToDelete = [];
          this.checkAllProductsToDelete = false;
          toastr.error("Product deleted successfully");
        });
    }
  },
  watch: {
    productIdsToDelete(_, __) {
      this.checkAllProductsToDelete = this.products.length > 0 && this.productIdsToDelete.length === this.products.length;
    }
  }
}
</script>


<style scoped>
img{
  width: 50px;
}
</style>
