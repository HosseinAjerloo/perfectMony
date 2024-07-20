/** @type {import('tailwindcss').Config} */
export default {
    content: [ "./resources/**/*.blade.php",],
    theme: {
        extend: {
            fontFamily: {
                'vazir': ['vazir'],
                'iranSans': ['iranSans'],
                'yekan': ['yekan'],

            },
            colors:{
                black_blur:'rgba(0,0,0, 0.7)'
            }
        },
    },
    plugins: [],
}




