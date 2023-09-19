/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');
module.exports = {
   content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js"
   ],
   theme: {
      extend: {
         colors: {
            black: colors.black,
            white: colors.white,
            gray: colors.slate,
            green: colors.emerald,
            purple: colors.violet,
            yellow: colors.amber,
            pink: colors.fuchsia
         }
      }
   },
   plugins: []
}
