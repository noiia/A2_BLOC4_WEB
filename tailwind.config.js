/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*/.{php,js}"],
  theme: {
    fontFamily: {
      display: ['Inter']
    },
    colors: {
      green: {
        header: '#94C676',
        true_btn: '#CAEDA7',
        button: '#39A325',
        filter: '#66B95A',
        text_bg: '#83AF68',
      },
      secondary: {
        white: '#F4F2EE',
        grey : '#B9B9B9',
        filter_grey: '#CBCBCB',
        beige: '#EDE5A6',
        black: "#000000",
      },
    },
  },
  plugins: [],
}

