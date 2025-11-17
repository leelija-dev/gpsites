import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        screens: {
            xs: "350px",
            smxl: "400px",
            xxs: "450px",
            smx: "500px", // Custom extra small breakpoint
            sm: "640px",
            md: "768px",
            lg: "991px",
            lgg: "1024px",
            xl: "1280px",
            xll: "1367px",
            "2xl": "1536px",
            "3xl": "1680px",
            // Max-width variants
            "max-xl": { max: "1279px" },
            "max-lg": { max: "1023px" },
            // Height-based breakpoints
            tall: { raw: "(min-height: 800px)" },
        },
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
           
            fontSize: {
                // Heading 1
                "h1-xs": ["1.75rem", { lineHeight: "1.2" }],
                "h1-sm": ["2.25rem", { lineHeight: "1.2" }],
                "h1-md": ["3rem", { lineHeight: "1.15" }],
                "h1-lg": ["2.8rem", { lineHeight: "1.15" }],
                "h1-lgg": ["3rem", { lineHeight: "1.15" }],
                "h1-xl": ["3.2rem", { lineHeight: "1.15" }],
                "h1-2xl": ["4rem", { lineHeight: "1.15" }],

                // Heading 2
                "h2-xs": ["1.5rem", { lineHeight: "1.25" }],
                "h2-sm": ["1.75rem", { lineHeight: "1.25" }],
                "h2-md": ["2rem", { lineHeight: "1.2" }],
                "h2-lg": ["2.25rem", { lineHeight: "1.2" }],
                "h2-lgg": ["2.3rem", { lineHeight: "1.1" }],
                "h2-xl": ["2.5rem", { lineHeight: "1.25" }],
                "h2-2xl": ["3rem", { lineHeight: "1.25" }],

                // Heading 3
                "h3-xs": ["1.25rem", { lineHeight: "1.3" }],
                "h3-sm": ["1.5rem", { lineHeight: "1.3" }],
                "h3-md": ["1.75rem", { lineHeight: "1.25" }],
                "h3-lg": ["1.75rem", { lineHeight: "1.25" }],
                "h3-lgg": ["1.85rem", { lineHeight: "1.2" }],
                "h3-xl": ["2rem", { lineHeight: "1.2" }],
                "h3-2xl": ["2.4rem", { lineHeight: "1.1" }],

                // Heading 4
                "h4-xs": ["1.125rem", { lineHeight: "1.4" }],
                "h4-sm": ["1.25rem", { lineHeight: "1.4" }],
                "h4-md": ["1.5rem", { lineHeight: "1.3" }],
                "h4-lg": ["1.75rem", { lineHeight: "1.3" }],
                "h4-lgg": ["1.875rem", { lineHeight: "1.25" }],
                "h4-xl": ["2rem", { lineHeight: "1.25" }],
                "h4-2xl": ["2.25rem", { lineHeight: "1.2" }],

                // Paragraph
                "p-xs": ["0.875rem", { lineHeight: "1.5" }],
                "p-sm": ["1rem", { lineHeight: "1.5" }],
                "p-md": ["1.025rem", { lineHeight: "1.5" }],
                "p-lg": ["1.050rem", { lineHeight: "1.5" }],
                "p-lgg": ["1rem", { lineHeight: "1.5" }],
                "p-xl": ["1.2rem", { lineHeight: "1.5" }],
                "p-2xl": ["1.425rem", { lineHeight: "1.4" }],

                // Small Text (span, li, etc.)
                "text-xs": ["0.75rem", { lineHeight: "1.5" }],
                "text-sm": ["0.875rem", { lineHeight: "1.5" }],
                "text-md": ["1rem", { lineHeight: "1.5" }],
                "text-lg": ["1.125rem", { lineHeight: "1.5" }],
                "text-lgg": ["1.25rem", { lineHeight: "1.4" }],
                "text-xl": ["1.375rem", { lineHeight: "1.4" }],
                "text-2xl": ["1.5rem", { lineHeight: "1.3" }],

                // Links (can use same as paragraph or smaller)
                "a-xs": ["0.875rem", { lineHeight: "1.5" }],
                "a-sm": ["1rem", { lineHeight: "1.5" }],
                "a-md": ["1.125rem", { lineHeight: "1.5" }],
                // ... continue pattern as needed
            },
            colors: {
                primary: "#471396", // purple-700
                secondary: "#B13BFF", // purple-700
                darkPrimary:"#090040",
                "primary-light": "#A78BFA", // purple-400
            },
        },
    },

    plugins: [
        function ({ addComponents }) {
            addComponents({
                ".btn-primary": {
                    "@apply bg-primary lg:text-[20px] text-[16px] hover:bg-white hover:text-primary hover:border-primary border-secondary border-[1px] text-white font-semibold py-3 px-8 rounded-[15px] transition-all duration-300":
                        "",
                },
                ".btn-secondary": {
                    "@apply bg-white lg:text-[20px] text-[16px] hover:bg-primary hover:text-white text-primary hover:border-secondary border-primary border-[1px]  font-semibold py-3 px-8 rounded-[15px] transition-all duration-300":
                        "",
                },
            });
        },

        forms,
    ],
};
