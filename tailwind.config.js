import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                earth: {
                    100: '#f4f2eb',
                    200: '#e9e6d9',
                    300: '#dfdbce',
                    400: '#d5cfba',
                    500: '#c5bca1',
                    600: '#a89d7d',
                    700: '#8c8163',
                    800: '#736952',
                    900: '#5e5645',
                }
            }
        },
    },

    plugins: [forms],
};
