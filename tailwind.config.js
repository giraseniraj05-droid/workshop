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
            colors: {
                primary: {
                    DEFAULT: 'var(--primary)',
                    light: 'var(--primary-light)',
                    lightest: 'var(--primary-lightest)',
                    dark: 'var(--primary-dark)',
                    darker: 'var(--primary-darker)',
                    darkest: 'var(--primary-darkest)',
                },
                secondary: {
                    DEFAULT: 'var(--secondary)',
                    lightest: 'var(--secondary-lightest)',
                    light: 'var(--secondary-light)',
                    dark: 'var(--secondary-dark)',
                    darker: 'var(--secondary-darker)',
                },
                accent: {
                    DEFAULT: 'var(--accent)',
                    light: 'var(--accent-light)',
                    dark: 'var(--accent-dark)',
                },
                background: 'var(--background)',
                teal: {
                    50: 'var(--primary-lightest)',
                    100: 'var(--primary-lightest)',
                    200: 'var(--primary-light)',
                    400: 'var(--primary-light)',
                    500: 'var(--primary)',
                    600: 'var(--primary-dark)',
                    700: 'var(--primary-darker)',
                    800: 'var(--primary-darkest)',
                },
                blue: {
                    50: 'var(--secondary-lightest)',
                    100: 'var(--secondary-lightest)',
                    200: 'var(--secondary-light)',
                    500: 'var(--secondary)',
                    600: 'var(--secondary-dark)',
                    700: 'var(--secondary-darker)',
                },
                indigo: {
                    50: 'var(--accent-light)',
                    500: 'var(--accent)',
                    600: 'var(--accent-dark)',
                    700: 'var(--accent-dark)',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
