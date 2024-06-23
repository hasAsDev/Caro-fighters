import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["poppins"],
                norse: ["norse"],
            },
            fontSize: {
                txt: ["1rem", { lineHeight: "1.25rem" }],
                h3: ["1.125rem", { lineHeight: "1.75rem" }],
                h2: ["2.5rem", { lineHeight: "3.75rem" }],
                h1: ["3.75rem", { lineHeight: "5.625rem" }],
            },
            fontWeight: {
                txt: "400",
                h3: "600",
                h2: "700",
                h1: "700",
            },
            colors: {
                gray: {
                    DEFAULT: "#BEBEBE",
                },
                brown: {
                    DEFAULT: "#58503f",
                    active: "#ffe8b5",
                },
                red: "#8B322C",
                dark: "#000",
                light: "#999",
            },
            borderRadius: {
                primative: "5px",
            },
            screens: {
                desktop: "1280px",
                laptop: "1024px",
                tablet: "640px",
            },
            gridTemplateColumns: {
                15: "repeat(15, minmax(0, 1fr))",
            },
        },
    },

    plugins: [forms],
};
