const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    // prettier-ignore
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  media: false, // or 'media' or 'class'
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      red: colors.red,
      orange: colors.orange,
      yellow: colors.yellow,
      green: colors.green,
      gray: colors.slate,
      grayBack: '#333333',
      orangeM5: '#e2250b',
      indigo: {
        100: '#e6e8ff',
        300: '#b2b7ff',
        400: '#7886d7',
        500: '#6574cd',
        600: '#5661b3',
        800: '#2f365f',
        900: '#191e38',
      },
    },
    extend: {
      borderColor: theme => ({
        DEFAULT: theme('colors.red.200', 'currentColor'),
      }),
      fontFamily: {
        sans: ['Cerebri Sans', ...defaultTheme.fontFamily.mono],
      },
      boxShadow: theme => ({
        outline: '0 0 0 2px ' + theme('colors.red.400'),
      }),
      fill: theme => theme('colors'),
      backgroundImage: {
        'gym': "url('/gym.jpeg')",
      },
    },
  },
  variants: {
    extend: {
      fill: ['focus', 'group-hover'],
      backgroundColor: ['disabled'],
    },
  },
  plugins: [],
}
