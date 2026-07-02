/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./node_modules/preline/dist/*.js",
    "./views/**/*.php",
    "./assets/**/*.js",
  ],
  theme: {
    fontFamily: {
      minecraft: ["Minecraft", "sans-serif"],
      sans: [
        "Lexend",
        "sans-serif",
        "ui-sans-serif",
        "system-ui",
        "-apple-system",
        "BlinkMacSystemFont",
        "Segoe UI",
        "Roboto",
        "Helvetica Neue",
        "Arial",
        "Noto Sans",
        "sans-serif",
        "Apple Color Emoji",
        "Segoe UI Emoji",
        "Segoe UI Symbol",
        "Noto Color Emoji",
      ],
    },
    extend: {
      colors: {
        primary: "#FFA100",
        danger: "#ef4444",
        success: "#1cbb8c",
        warning: "#ffab00",
        purple: "#B798FF",
        info: "#06b6d4",
        steel: {
          50: "#868EA0",
          100: "#4E5462",
          200: "#333740",
          300: "#0F1217",
          400: "#21242A",
          500: "#13171E",
        },
      },
    },
  },
  plugins: [
    require("@tailwindcss/typography"),
    require("@tailwindcss/forms")({
      strategy: 'class',
    }),
    require("@tailwindcss/aspect-ratio"),
    require('@tailwindcss/container-queries'),
    require("tailwind-capitalize-first-letter"),
    require("preline/plugin"),
  ],
};
