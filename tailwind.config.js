/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*/.{php,js}"],
  theme: {
    fontFamily: {
      display: ['Inter']
    },
    colors: {
      blue:{
        links: '#0081F9',
      },
      green: {
        header: '#94C676',
        true_btn: '#CAEDA7',
        button: '#39A325',
        filter: '#66B95A',
        text_bg: '#83AF68',
        shutter: '#66B95A',
        1 : '#15751E',
        2 : '#39A325',
        3 : '#69B254',
        shutter: '#66B95A',
        1 : '#15751E',
        2 : '#39A325',
        3 : '#69B254',
      },
      secondary: {
        white: '#F4F2EE',
        true_white: '#FFFFFF',
        login_bg: '#F4F2EE',
        true_white: '#FFFFFF',
        login_bg: '#F4F2EE',
        grey : '#B9B9B9',
        filter_grey: '#CBCBCB',
        footer_grey: '#A4A4A4', 
        footer_grey: '#A4A4A4', 
        beige: '#EDE5A6',
        arrow_header: '#C9C9C9',
        pp_grey: '#929292',
        scroll_bar_grey: '#7B7B7B',
        left_bg_grey: '#D9D9D9',
        footer_black: '#252525', 
        true_black: "#000000",
        transparent: 'transparent',
        arrow_header: '#C9C9C9',
        pp_grey: '#929292',
        scroll_bar_grey: '#7B7B7B',
        left_bg_grey: '#D9D9D9',
        footer_black: '#252525', 
        true_black: "#000000",
        transparent: 'transparent',
      },
    },
    screens:{
      'sm' : '500px',
      'md' : '768px',
      'ml' : '850px',
      'lg' : '1024px',
      'xl' : '1280px',
      '2xl' : '1536px',
    },
    extend:{
      backgroundImage:{
        'login': "url('../../Assets/Background/login.gif')"
      }
    }
  },
  plugins: [
    require('tailwindcss'),
    require('autoprefixer'),
  ],
}

