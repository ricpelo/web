/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.{html,php}",
    "./src/**/*.{html,php}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
