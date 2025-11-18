import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import flowbitePlugin from 'flowbite/plugin'
import wireuiPreset from './vendor/wireui/wireui/tailwind.config.js'

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    presets: [wireuiPreset],

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.{js,ts,vue}',
        // Flowbite
        './node_modules/flowbite/**/*.js',
        // WireUI
        './vendor/wireui/wireui/src/*.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/WireUi/**/*.php',
        './vendor/wireui/wireui/src/Components/**/*.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
            },

            fontFamily: {
                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            transitionDuration: {
                750: '750ms',
            },

            spacing: {
                '14.5': '3.625rem',
            },

            keyframes: {
                fadeSlideIn: {
                    '0%': { opacity: '0', transform: 'translateY(1.5rem)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },

            animation: {
                'fade-slide-in': 'fadeSlideIn 750ms cubic-bezier(0.4,0,0.2,1) both',
            },
        },
    },

    plugins: [forms, typography, flowbitePlugin],
}
