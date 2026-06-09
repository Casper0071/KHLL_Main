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
            colors: {
                // DARK BACKGROUND
                background: {
                    DEFAULT: '#202A41',
                    dark: '#1A2336',
                    light: '#2A3552',
                },

                // LIGHT SECTIONS / BLOBS
                surface: {
                    DEFAULT: '#F4F7FB',
                    soft: '#E9EEF7',
                },

                // PRIMARY (GOUD)
                primary: {
                    DEFAULT: '#EAB751',
                    hover: '#D9A94A',
                    light: '#F5D58A',
                    dark: '#C9972E',
                },

                // TEXT COLORS
                text: {
                    dark: '#0B122A',
                    light: '#F4F7FB',
                    muted: '#7386B2',
                },

                // DECORATION (noten etc.)
                accent: {
                    DEFAULT: '#7386B2',
                    soft: '#9AA9CC',
                },
                lol: {
                    DEFAULT: '#3B82F6',
                    soft: '#93C5FD',
                    dark: '#1E40AF',
                },
                khll: {
                    DEFAULT: '#EAB751',
                    soft: '#F5D58A',
                    dark: '#C9972E',
                },
                activiteiten: {
                    DEFAULT: '#10B981',
                    soft: '#6EE7B7',
                    dark: '#059669',
                }
            },


            fontFamily: {
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                opensans: ['Open Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
