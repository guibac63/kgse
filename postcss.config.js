import postcss_import from "postcss-import";

let tailwindcss = require("tailwindcss")

module.exports = {
  plugins: [
      tailwindcss('./tailwind.config.js'),
      require('postcss-import'),
      require('autoprefixer')
  ]
}
