import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import flowbitePlugin from "flowbite/plugin"; // Import Flowbite plugin

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js", // Optional: include your custom JS
        "./node_modules/flowbite/**/*.js", // ← Required for Flowbite
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        flowbitePlugin, // ← Proper Flowbite plugin usage
    ],
};
