const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            screens: {
                print: { raw: "print" },
                screen: { raw: "screen" },
            },
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins"],
            },
        },
    },

    plugins: [require("@tailwindcss/forms"), require("flowbite/plugin")],
};
