module.exports = {
  content: [
      "./assets/**/*.{vue,js,ts,jsx,tsx}",
      "./templates/**/*.{html,twig}"
  ],
  theme: {
      fontFamily:{
        'open-sans':['"Open Sans"','ui-sans-serif'],
        'orbitron':['Orbitron','Arial'],
          'segoe':['"Segoe UI"','Helvetica Neue']
      },
    extend: {
        backgroundImage: {
            'kgse-bg':"url('/public/images/background/BACKGROUND.jpg')",
            'admin' : "url('/public/images/admin/08.jpg')"
        }
    },
  },
  plugins: [],
}
