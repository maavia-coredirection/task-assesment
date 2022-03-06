import api from "./index";

export const createProduct = (data) => {
  const url = "/products";
  return api("post", url, data);
}

export const updateProduct = (data, id) => {
  const url = `/products/${id}`;
  return api("post", url, data);
}


export const deleteProducts = (data) => {
  const url = `/products/${JSON.stringify(data)}`;
  return api("delete", url);
}


export const getProducts = () => {
  const url = "/products";
  return api("get", url);
}

export const getProduct = (productId) => {
  const url = `/products/${productId}`;
  return api("get", url);
}
