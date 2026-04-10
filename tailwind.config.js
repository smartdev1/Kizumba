/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./app.vue",
  ],
  theme: {
    extend: {
      colors: {
        gold: {
          50:  '#fdf8ec',
          100: '#f9edcc',
          200: '#f2d98a',
          300: '#ecc456',
          400: '#F5D78A', // or clair / hover
          500: '#C9A84C', // or brand principal UKWC
          600: '#A88630',
          700: '#8B6914',
          800: '#6B4F0D',
          900: '#4A3708',
        },
        primary: {
          DEFAULT: '#000000',
          light: '#1a1a1a',
        }
      },
      fontFamily: {
        'heading': ['Montserrat', 'Orbitron', 'sans-serif'],
        'body': ['Poppins', 'Roboto', 'sans-serif'],
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      }
    },
  },
  plugins: [],
}

