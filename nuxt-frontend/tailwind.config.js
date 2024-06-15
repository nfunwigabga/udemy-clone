const defaultTheme = require("tailwindcss/defaultTheme")
const colors = require("tailwindcss/colors")

/** @type {import("tailwindcss").Config} */
module.exports = {
  important: true,
  safelist: [
    {
      pattern:
        /bg-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(100|200|300|400|500|600|700|800|900)/,
    },
    {
      pattern:
        /border-b-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(100|200|300|400|500|600|700|800|900)/,
    },
    {
      pattern:
        /border-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(100|200|300|400|500|600|700|800|900)/,
    },
    {
      pattern:
        /text-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(100|200|300|400|500|600|700|800|900)/,
    },
  ],

  theme: {
    container: {
      center: true,
    },
    extend: {
      colors: {
        primary: colors.blue,
        danger: colors.red,
        secondary: "#151b26",
        warning: colors.orange,
        zinc: colors.zinc,
        link: colors.blue,
        rose: colors.rose,
        cyan: colors.cyan,
        dark: colors.slate,
      },
      scale: {
        101: "1.01",
        102: "1.02",
      },
      fontFamily: {
        sans: [
          "Roboto",
          "Nunito",
          "Helvetica",
          "Proxima Nova",
          ...defaultTheme.fontFamily.sans,
        ],
        poppins: ["Poppins", "sans-serif"],
        safira: ["SAFIRA", "Poppins", "Proxima Nova"],
      },
      fontSize: {
        xxs: ["0.65rem", { lineHeight: "1.1rem" }],
      },
    },
  },

  plugins: [
    // require("@tailwindcss/forms"),
    // require("@tailwindcss/aspect-ratio"),
  ],
}
