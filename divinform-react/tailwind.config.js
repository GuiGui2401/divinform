/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,jsx}'],
  theme: {
    extend: {
      colors: {
        'blue-dark':  '#0A3D8F',
        'blue-mid':   '#1A6FC4',
        'blue-light': '#2A9FD8',
        'green':      '#27AE60',
        'green-light':'#2ECC71',
        'dark':       '#0D1B2A',
        'dark-2':     '#1C2E3E',
        'off-white':  '#F0F4F8',
        'gray-med':   '#546E7A',
      },
      fontFamily: {
        display: ['Poppins', 'sans-serif'],
        body:    ['Inter', 'sans-serif'],
      },
      boxShadow: {
        'card': '0 2px 8px rgba(10,61,143,0.08)',
        'card-hover': '0 8px 30px rgba(10,61,143,0.14)',
        'lg-blue': '0 20px 60px rgba(10,61,143,0.20)',
      }
    },
  },
  plugins: [],
}
