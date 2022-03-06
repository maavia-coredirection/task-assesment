import store from "../../store/store";

const hook = (to, from, next) => {

  const authRequiredAndTokenNotAvailable = to.meta.auth && !store.getters["auth/getAuthToken"];
  const authNotRequiredAndTokenAvailable = !to.meta.auth && store.getters["auth/getAuthToken"];

  if (authRequiredAndTokenNotAvailable) {
    next("/login");
  } else if (authNotRequiredAndTokenAvailable) {
    next("/dashboard/product");
  } else {
    next();
  }

};

export default hook;
