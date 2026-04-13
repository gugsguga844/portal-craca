/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./template-parts/**/*.php",
    "./inc/**/*.php",
    "./js/**/*.js",
    "./assets/**/*.{html,js}",
  ],
  theme: {
    extend: {
      colors: {
        // Brand palette
        'craca-green': '#15230d',
        'craca-dark': '#0e110e',
        'craca-orange': '#ff6625',
        'craca-cream': '#f3fad5',
        'craca-pink': '#ff76ce',

        // Category colors
        'cat-documentarios': '#ff6625',
        'cat-cidade': '#ff76ce',
        'cat-entretenimento': '#f3fad5',
        'cat-esportes': '#00b4d8',
        'cat-denuncia': '#ef233c',
        'cat-coisas': '#b185db',
        'cat-politica': '#80ed99',
      },
      fontFamily: {
        'squidboy': ['"SquidBoy"', 'cursive', 'sans-serif'],
        'squidboy-bold': ['"SquidBoy Bold"', 'cursive', 'sans-serif'],
        'squidboy-thin': ['"SquidBoy Thin"', 'cursive', 'sans-serif'],
        'anaktoria': ['"Anaktoria"', 'serif'],
        'body': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      backgroundImage: {
        'texture-grid': "url('../assets/img/texture-dark-grid.png')",
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
