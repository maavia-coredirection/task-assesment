import product from "../pages/dashboard/product/product";
import productListing from "../pages/dashboard/product/product-listing";
import signup from "../pages/registration/signup";
import login from "../pages/registration/login";
import forgotPassword from "../pages/registration/forgot-password";
import dashboard from "../pages/dashboard";
import updatePassword from "../pages/registration/update-password"
const routes = [
  {
    path: "/",
    meta: {
      auth: false
    },
    beforeEnter: (to, from, next) => {
      next("/login");
    },
  },
  {
    path: "/login",
    component: login,
    meta: {
      auth: false
    }
  },
  {
    path: "/sign-up",
    component: signup,
    meta: {
      auth: false
    }
  },
  {
    path: "/forgot-password",
    component: forgotPassword,
    meta: {
      auth: false
    }
  },
  {
    path: "/update-password/:token",
    component: updatePassword,
    meta: {
      auth: false
    }
  },
  {
    path: "/dashboard",
    meta: {
      auth: true
    },
    component: dashboard,
    beforeEnter(to, from, next) {
      if (to.path === "/dashboard") {
        next("/dashboard/product");
      } else {
        next();
      }
    },
    children: [
      {
        path: "/dashboard/product",
        component: product,
        meta: {
          auth: true
        }
      },
      {
        path: "/dashboard/product/:productId",
        component: product,
        meta: {
          auth: true
        }
      },
      {
        path: "/dashboard/product-listing",
        component: productListing,
        meta: {
          auth: true
        }
      }
    ]
  }
];

export default routes;
