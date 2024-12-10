/** @type {import('tailwindcss').Config} */
import colors from "tailwindcss/colors";

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                orange: colors.orange[500],
                blueHover: "#83dfe9",
                cyanHover: "#1dadc0",
                black: colors.slate[800],
                white: colors.slate[50],
                whiteDarker: colors.gray[100],
                lightBlue: colors.slate[200],
                cyan: "#1fbdd2",
            },
            fontFamily: {
                afacad: ["Afacad Flux", "sans-serif"],
            },
        },
    },
    plugins: [],
};
