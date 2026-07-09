/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,jsx}'],
  theme: {
    extend: {
      colors: {
        // Palette « Ferme Divinform » — vert prairie & terre.
        // Les clés gardent leurs anciens noms (blue-*) pour ne pas casser
        // les classes Tailwind utilisées partout ; seules les valeurs changent.
        'blue-dark':  '#2E5A1F', // vert forêt profond (titres, boutons foncés)
        'blue-mid':   '#4A7C2F', // vert prairie (liens, sur-titres)
        'blue-light': '#6BA83A', // vert clair (accents)
        'green':      '#5E9E2E', // vert CTA
        'green-light':'#86C34A', // vert CTA dégradé
        'dark':       '#2B2416', // brun terre foncé (sidebar / footer)
        'dark-2':     '#3E3520', // brun terre (dégradés)
        'off-white':  '#F7F3E8', // crème
        'gray-med':   '#6E6A55', // taupe olive
        'terre':      '#8B5E34', // brun terre (accent)
        'ocre':       '#D9A441', // ocre (accent)
      },
      fontFamily: {
        display: ['Poppins', 'sans-serif'],
        body:    ['Inter', 'sans-serif'],
      },
      boxShadow: {
        'card': '0 2px 8px rgba(46,90,31,0.08)',
        'card-hover': '0 8px 30px rgba(46,90,31,0.14)',
        'lg-blue': '0 20px 60px rgba(46,90,31,0.20)',
      }
    },
  },
  plugins: [],
}
