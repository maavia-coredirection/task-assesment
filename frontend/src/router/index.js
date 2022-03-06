import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import beforeEachHook from "./navigation-guard/before-each";

Vue.use(VueRouter);
const router = new VueRouter({
  routes,
  linkExactActiveClass: "active"
});

router.beforeEach(beforeEachHook);

export default router;
