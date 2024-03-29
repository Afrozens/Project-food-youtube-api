import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'black-background': "url('/img/black-background.png')",
                'index-background': "url('/img/banner01.png')",
                'header-background': "url('/img/banner02.png')",
                'header-secondary-background': "url('/img/banner03.jpg')"
            },
            backgroundColor: {
                primary: '#1976D2'
            },
            colors: {
                primary: '#1976D2'
            }
        },
    },

    plugins: [forms],
};
