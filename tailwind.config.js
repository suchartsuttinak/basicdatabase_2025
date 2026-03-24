import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',   // เพิ่มเพื่อรองรับไฟล์ JS
        './resources/js/**/*.vue',  // ถ้ามี Vue component
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#2563eb', // blue-600
                    dark: '#1e40af',    // blue-800
                },
                secondary: {
                    DEFAULT: '#6b7280', // gray-500
                },
            },
        },
    },

    plugins: [
        forms,
    ],
};