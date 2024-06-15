// https://nuxt.com/docs/api/configuration/nuxt-config
import { hooks } from "./routes";

export default defineNuxtConfig({
  app: {
    head: {
      title: process.env.SITE_NAME,
      titleTemplate: `%s | ${process.env.SITE_NAME}`,
    },
    pageTransition: { name: "page", mode: "out-in" },
    layoutTransition: { name: "page", mode: "out-in" },
  },
  modules: [
    "@nuxt-alt/auth",
    "@nuxt-alt/http",
    "@pinia/nuxt",
    "@nuxtjs/tailwindcss",
    "nuxt-quasar-ui",
  ],
  hooks: hooks,
  quasar: {
    plugins: ["Dialog", "Notify"],
    // iconSet: 'line-awesome',
    config: {},
    extras: {
      font: null,
      fontIcons: ["material-icons", "line-awesome"],
    },
  },

  http: {
    baseURL: process.env.API_URL,
    browserBaseURL: process.env.API_URL,
    credentials: "include",
  },

  auth: {
    redirect: {
      login: "/login",
      logout: "/",
      home: "/",
      callback: "/",
    },
    localStorage: false,
    sessionStorage: false,
    cookie: {
      prefix: "skillmetr_", // default is auth. All cookie vars will start with this
    },
    strategies: {
      cookie: {
        cookie: {
          name: "XXSRF-TOKEN",
        },
        endpoints: {
          login: {
            url: "/auth/token",
            method: "post",
          },
          logout: {
            url: "/auth/logout",
            method: "post",
          },
          user: {
            url: "/auth/me",
            method: "get",
          },
        },
        user: {
          property: false,
        },
      },
      local: {
        token: {
          property: "token",
          prefix: "_skillmetr_",
          // global: true // whether to include token in all axios calls
        },
        endpoints: {
          login: {
            url: "/auth/token",
            method: "post",
          },
          logout: {
            url: "/auth/logout",
            method: "post",
          },
          user: {
            url: "/auth/me",
            method: "get",
          },
        },
        refreshToken: false,
        user: {
          property: false,
        },
      },
    },
  },

  runtimeConfig: {
    private: {
      stripeSecretKey: process.env.STRIPE_SECRET_KEY,
    },
    public: {
      STRIPE_PUBLISHABLE_KEY: process.env.STRIPE_PUBLISHABLE_KEY,
      siteName: process.env.SITE_NAME,
      baseURL: process.env.API_URL || "http://udemy-api.test/api",
      PUSHER_APP_ID: process.env.PUSHER_APP_ID,
      PUSHER_APP_KEY: process.env.PUSHER_APP_KEY,
      PUSHER_APP_SECRET: process.env.PUSHER_APP_SECRET,
      PUSHER_APP_CLUSTER: process.env.PUSHER_APP_CLUSTER,
      PUSHER_APP_PORT: process.env.PUSHER_APP_PORT,
      PUSHER_APP_SCHEME: process.env.PUSHER_APP_SCHEME,
      PUSHER_APP_HOST: process.env.PUSHER_APP_HOST,
    },
  },
});
