<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <style>
        .pathFront {
            fill: url(#g1);
        }

        .pathBack {
            fill: url(#back);
        }

        .path-top {
            fill: url(#front);
        }
    </style>
    <style>
        :root {
            --tw-screen-sm: 640px;
            --tw-screen-md: 768px;
            --tw-screen-lg: 1024px;
            --tw-screen-xl: 1280px;
            --tw-screen-2xl: 1536px;
            --tw-color-inherit: inherit;
            --tw-color-current: currentColor;
            --tw-color-transparent: transparent;
            --tw-color-black: 0 0 0;
            --tw-color-white: 255 255 255;
            --tw-color-slate-50: 248 250 252;
            --tw-color-slate-100: 241 245 249;
            --tw-color-slate-200: 226 232 240;
            --tw-color-slate-300: 203 213 225;
            --tw-color-slate-400: 148 163 184;
            --tw-color-slate-500: 100 116 139;
            --tw-color-slate-600: 71 85 105;
            --tw-color-slate-700: 51 65 85;
            --tw-color-slate-800: 30 41 59;
            --tw-color-slate-900: 15 23 42;
            --tw-color-gray-50: 249 250 251;
            --tw-color-gray-100: 243 244 246;
            --tw-color-gray-200: 229 231 235;
            --tw-color-gray-300: 209 213 219;
            --tw-color-gray-400: 156 163 175;
            --tw-color-gray-500: 107 114 128;
            --tw-color-gray-600: 75 85 99;
            --tw-color-gray-700: 55 65 81;
            --tw-color-gray-800: 31 41 55;
            --tw-color-gray-900: 17 24 39;
            --tw-color-zinc-50: 250 250 250;
            --tw-color-zinc-100: 244 244 245;
            --tw-color-zinc-200: 228 228 231;
            --tw-color-zinc-300: 212 212 216;
            --tw-color-zinc-400: 161 161 170;
            --tw-color-zinc-500: 113 113 122;
            --tw-color-zinc-600: 82 82 91;
            --tw-color-zinc-700: 63 63 70;
            --tw-color-zinc-800: 39 39 42;
            --tw-color-zinc-900: 24 24 27;
            --tw-color-neutral-50: 250 250 250;
            --tw-color-neutral-100: 245 245 245;
            --tw-color-neutral-200: 229 229 229;
            --tw-color-neutral-300: 212 212 212;
            --tw-color-neutral-400: 163 163 163;
            --tw-color-neutral-500: 115 115 115;
            --tw-color-neutral-600: 82 82 82;
            --tw-color-neutral-700: 64 64 64;
            --tw-color-neutral-800: 38 38 38;
            --tw-color-neutral-900: 23 23 23;
            --tw-color-stone-50: 250 250 249;
            --tw-color-stone-100: 245 245 244;
            --tw-color-stone-200: 231 229 228;
            --tw-color-stone-300: 214 211 209;
            --tw-color-stone-400: 168 162 158;
            --tw-color-stone-500: 120 113 108;
            --tw-color-stone-600: 87 83 78;
            --tw-color-stone-700: 68 64 60;
            --tw-color-stone-800: 41 37 36;
            --tw-color-stone-900: 28 25 23;
            --tw-color-red-50: 254 242 242;
            --tw-color-red-100: 254 226 226;
            --tw-color-red-200: 254 202 202;
            --tw-color-red-300: 252 165 165;
            --tw-color-red-400: 248 113 113;
            --tw-color-red-500: 239 68 68;
            --tw-color-red-600: 220 38 38;
            --tw-color-red-700: 185 28 28;
            --tw-color-red-800: 153 27 27;
            --tw-color-red-900: 127 29 29;
            --tw-color-orange-50: 255 247 237;
            --tw-color-orange-100: 255 237 213;
            --tw-color-orange-200: 254 215 170;
            --tw-color-orange-300: 253 186 116;
            --tw-color-orange-400: 251 146 60;
            --tw-color-orange-500: 249 115 22;
            --tw-color-orange-600: 234 88 12;
            --tw-color-orange-700: 194 65 12;
            --tw-color-orange-800: 154 52 18;
            --tw-color-orange-900: 124 45 18;
            --tw-color-amber-50: 255 251 235;
            --tw-color-amber-100: 254 243 199;
            --tw-color-amber-200: 253 230 138;
            --tw-color-amber-300: 252 211 77;
            --tw-color-amber-400: 251 191 36;
            --tw-color-amber-500: 245 158 11;
            --tw-color-amber-600: 217 119 6;
            --tw-color-amber-700: 180 83 9;
            --tw-color-amber-800: 146 64 14;
            --tw-color-amber-900: 120 53 15;
            --tw-color-yellow-50: 254 252 232;
            --tw-color-yellow-100: 254 249 195;
            --tw-color-yellow-200: 254 240 138;
            --tw-color-yellow-300: 253 224 71;
            --tw-color-yellow-400: 250 204 21;
            --tw-color-yellow-500: 234 179 8;
            --tw-color-yellow-600: 202 138 4;
            --tw-color-yellow-700: 161 98 7;
            --tw-color-yellow-800: 133 77 14;
            --tw-color-yellow-900: 113 63 18;
            --tw-color-lime-50: 247 254 231;
            --tw-color-lime-100: 236 252 203;
            --tw-color-lime-200: 217 249 157;
            --tw-color-lime-300: 190 242 100;
            --tw-color-lime-400: 163 230 53;
            --tw-color-lime-500: 132 204 22;
            --tw-color-lime-600: 101 163 13;
            --tw-color-lime-700: 77 124 15;
            --tw-color-lime-800: 63 98 18;
            --tw-color-lime-900: 54 83 20;
            --tw-color-green-50: 240 253 244;
            --tw-color-green-100: 220 252 231;
            --tw-color-green-200: 187 247 208;
            --tw-color-green-300: 134 239 172;
            --tw-color-green-400: 74 222 128;
            --tw-color-green-500: 34 197 94;
            --tw-color-green-600: 22 163 74;
            --tw-color-green-700: 21 128 61;
            --tw-color-green-800: 22 101 52;
            --tw-color-green-900: 20 83 45;
            --tw-color-emerald-50: 236 253 245;
            --tw-color-emerald-100: 209 250 229;
            --tw-color-emerald-200: 167 243 208;
            --tw-color-emerald-300: 110 231 183;
            --tw-color-emerald-400: 52 211 153;
            --tw-color-emerald-500: 16 185 129;
            --tw-color-emerald-600: 5 150 105;
            --tw-color-emerald-700: 4 120 87;
            --tw-color-emerald-800: 6 95 70;
            --tw-color-emerald-900: 6 78 59;
            --tw-color-teal-50: 240 253 250;
            --tw-color-teal-100: 204 251 241;
            --tw-color-teal-200: 153 246 228;
            --tw-color-teal-300: 94 234 212;
            --tw-color-teal-400: 45 212 191;
            --tw-color-teal-500: 20 184 166;
            --tw-color-teal-600: 13 148 136;
            --tw-color-teal-700: 15 118 110;
            --tw-color-teal-800: 17 94 89;
            --tw-color-teal-900: 19 78 74;
            --tw-color-cyan-50: 236 254 255;
            --tw-color-cyan-100: 207 250 254;
            --tw-color-cyan-200: 165 243 252;
            --tw-color-cyan-300: 103 232 249;
            --tw-color-cyan-400: 34 211 238;
            --tw-color-cyan-500: 6 182 212;
            --tw-color-cyan-600: 8 145 178;
            --tw-color-cyan-700: 14 116 144;
            --tw-color-cyan-800: 21 94 117;
            --tw-color-cyan-900: 22 78 99;
            --tw-color-sky-50: 240 249 255;
            --tw-color-sky-100: 224 242 254;
            --tw-color-sky-200: 186 230 253;
            --tw-color-sky-300: 125 211 252;
            --tw-color-sky-400: 56 189 248;
            --tw-color-sky-500: 14 165 233;
            --tw-color-sky-600: 2 132 199;
            --tw-color-sky-700: 3 105 161;
            --tw-color-sky-800: 7 89 133;
            --tw-color-sky-900: 12 74 110;
            --tw-color-blue-50: 239 246 255;
            --tw-color-blue-100: 219 234 254;
            --tw-color-blue-200: 191 219 254;
            --tw-color-blue-300: 147 197 253;
            --tw-color-blue-400: 96 165 250;
            --tw-color-blue-500: 59 130 246;
            --tw-color-blue-600: 37 99 235;
            --tw-color-blue-700: 29 78 216;
            --tw-color-blue-800: 30 64 175;
            --tw-color-blue-900: 30 58 138;
            --tw-color-indigo-50: 238 242 255;
            --tw-color-indigo-100: 224 231 255;
            --tw-color-indigo-200: 199 210 254;
            --tw-color-indigo-300: 165 180 252;
            --tw-color-indigo-400: 129 140 248;
            --tw-color-indigo-500: 99 102 241;
            --tw-color-indigo-600: 79 70 229;
            --tw-color-indigo-700: 67 56 202;
            --tw-color-indigo-800: 55 48 163;
            --tw-color-indigo-900: 49 46 129;
            --tw-color-violet-50: 245 243 255;
            --tw-color-violet-100: 237 233 254;
            --tw-color-violet-200: 221 214 254;
            --tw-color-violet-300: 196 181 253;
            --tw-color-violet-400: 167 139 250;
            --tw-color-violet-500: 139 92 246;
            --tw-color-violet-600: 124 58 237;
            --tw-color-violet-700: 109 40 217;
            --tw-color-violet-800: 91 33 182;
            --tw-color-violet-900: 76 29 149;
            --tw-color-purple-50: 250 245 255;
            --tw-color-purple-100: 243 232 255;
            --tw-color-purple-200: 233 213 255;
            --tw-color-purple-300: 216 180 254;
            --tw-color-purple-400: 192 132 252;
            --tw-color-purple-500: 168 85 247;
            --tw-color-purple-600: 147 51 234;
            --tw-color-purple-700: 126 34 206;
            --tw-color-purple-800: 107 33 168;
            --tw-color-purple-900: 88 28 135;
            --tw-color-fuchsia-50: 253 244 255;
            --tw-color-fuchsia-100: 250 232 255;
            --tw-color-fuchsia-200: 245 208 254;
            --tw-color-fuchsia-300: 240 171 252;
            --tw-color-fuchsia-400: 232 121 249;
            --tw-color-fuchsia-500: 217 70 239;
            --tw-color-fuchsia-600: 192 38 211;
            --tw-color-fuchsia-700: 162 28 175;
            --tw-color-fuchsia-800: 134 25 143;
            --tw-color-fuchsia-900: 112 26 117;
            --tw-color-pink-50: 253 242 248;
            --tw-color-pink-100: 252 231 243;
            --tw-color-pink-200: 251 207 232;
            --tw-color-pink-300: 249 168 212;
            --tw-color-pink-400: 244 114 182;
            --tw-color-pink-500: 236 72 153;
            --tw-color-pink-600: 219 39 119;
            --tw-color-pink-700: 190 24 93;
            --tw-color-pink-800: 157 23 77;
            --tw-color-pink-900: 131 24 67;
            --tw-color-rose-50: 255 241 242;
            --tw-color-rose-100: 255 228 230;
            --tw-color-rose-200: 254 205 211;
            --tw-color-rose-300: 253 164 175;
            --tw-color-rose-400: 251 113 133;
            --tw-color-rose-500: 244 63 94;
            --tw-color-rose-600: 225 29 72;
            --tw-color-rose-700: 190 18 60;
            --tw-color-rose-800: 159 18 57;
            --tw-color-rose-900: 136 19 55;
            --tw-color-primary-50: 239 246 255;
            --tw-color-primary-100: 219 234 254;
            --tw-color-primary-200: 191 219 254;
            --tw-color-primary-300: 147 197 253;
            --tw-color-primary-400: 96 165 250;
            --tw-color-primary-500: 59 130 246;
            --tw-color-primary-600: 37 99 235;
            --tw-color-primary-700: 29 78 216;
            --tw-color-primary-800: 30 64 175;
            --tw-color-primary-900: 30 58 138;
            --tw-color-primary: 48 86 211;
            --tw-size-0: 0px;
            --tw-size-1: 0.25rem;
            --tw-size-2: 0.5rem;
            --tw-size-3: 0.75rem;
            --tw-size-4: 1rem;
            --tw-size-5: 1.25rem;
            --tw-size-6: 1.5rem;
            --tw-size-7: 1.75rem;
            --tw-size-8: 2rem;
            --tw-size-9: 2.25rem;
            --tw-size-10: 2.5rem;
            --tw-size-11: 2.75rem;
            --tw-size-12: 3rem;
            --tw-size-14: 3.5rem;
            --tw-size-16: 4rem;
            --tw-size-20: 5rem;
            --tw-size-24: 6rem;
            --tw-size-28: 7rem;
            --tw-size-32: 8rem;
            --tw-size-36: 9rem;
            --tw-size-40: 10rem;
            --tw-size-44: 11rem;
            --tw-size-48: 12rem;
            --tw-size-52: 13rem;
            --tw-size-56: 14rem;
            --tw-size-60: 15rem;
            --tw-size-64: 16rem;
            --tw-size-72: 18rem;
            --tw-size-80: 20rem;
            --tw-size-96: 24rem;
            --tw-size-px: 1px;
            --tw-size-0_5: 0.125rem;
            --tw-size-1_5: 0.375rem;
            --tw-size-2_5: 0.625rem;
            --tw-size-3_5: 0.875rem;
            --tw-width-1: 1;
            --tw-width-2: 2;
            --tw-width-3: 3;
            --tw-width-4: 4;
            --tw-width-5: 5;
            --tw-width-6: 6;
            --tw-width-7: 7;
            --tw-width-8: 8;
            --tw-width-9: 9;
            --tw-width-10: 10;
            --tw-width-11: 11;
            --tw-width-12: 12;
            --tw-width-auto: auto;
            --tw-width-3xs: 16rem;
            --tw-width-2xs: 18rem;
            --tw-width-xs: 20rem;
            --tw-width-sm: 24rem;
            --tw-width-md: 28rem;
            --tw-width-lg: 32rem;
            --tw-width-xl: 36rem;
            --tw-width-2xl: 42rem;
            --tw-width-3xl: 48rem;
            --tw-width-4xl: 56rem;
            --tw-width-5xl: 64rem;
            --tw-width-6xl: 72rem;
            --tw-width-7xl: 80rem;
            --tw-width-prose: 65ch;
            --tw-font-family-sans: ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
                "Noto Color Emoji";
            --tw-font-family-serif: ui-serif, Georgia, Cambria, "Times New Roman", Times,
                serif;
            --tw-font-family-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
                "Liberation Mono", "Courier New", monospace;
            --tw-font-size-xs: 0.75rem;
            --tw-font-size-sm: 0.875rem;
            --tw-font-size-base: 1rem;
            --tw-font-size-lg: 1.125rem;
            --tw-font-size-xl: 1.25rem;
            --tw-font-size-2xl: 1.5rem;
            --tw-font-size-3xl: 1.875rem;
            --tw-font-size-4xl: 2.25rem;
            --tw-font-size-5xl: 3rem;
            --tw-font-size-6xl: 3.75rem;
            --tw-font-size-7xl: 4.5rem;
            --tw-font-size-8xl: 6rem;
            --tw-font-size-9xl: 8rem;
            --tw-font-weight-thin: 100;
            --tw-font-weight-extralight: 200;
            --tw-font-weight-light: 300;
            --tw-font-weight-normal: 400;
            --tw-font-weight-medium: 500;
            --tw-font-weight-semibold: 600;
            --tw-font-weight-bold: 700;
            --tw-font-weight-extrabold: 800;
            --tw-font-weight-black: 900;
            --tw-line-height-3: 0.75rem;
            --tw-line-height-4: 1rem;
            --tw-line-height-5: 1.25rem;
            --tw-line-height-6: 1.5rem;
            --tw-line-height-7: 1.75rem;
            --tw-line-height-8: 2rem;
            --tw-line-height-9: 2.25rem;
            --tw-line-height-10: 2.5rem;
            --tw-line-height-none: 1;
            --tw-line-height-tight: 1.25;
            --tw-line-height-snug: 1.375;
            --tw-line-height-normal: 1.5;
            --tw-line-height-relaxed: 1.625;
            --tw-line-height-loose: 2;
            --tw-border-radius-none: 0px;
            --tw-border-radius-sm: 0.125rem;
            --tw-border-radius-default: 0.25rem;
            --tw-border-radius-md: 0.375rem;
            --tw-border-radius-lg: 0.5rem;
            --tw-border-radius-xl: 0.75rem;
            --tw-border-radius-2xl: 1rem;
            --tw-border-radius-3xl: 1.5rem;
            --tw-border-radius-full: 9999px;
        }

        @layer tailwind-reset {
            /*
        ! tailwindcss v3.1.8 | MIT License | https://tailwindcss.com
        */
                    /*
        1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
        2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
        */

                    *,
                    ::before,
                    ::after {
                        box-sizing: border-box;
                        /* 1 */
                        border-width: 0;
                        /* 2 */
                        border-style: solid;
                        /* 2 */
                        border-color: rgb(var(--tw-color-gray-200) / 1);
                        /* 2 */
                    }

                    ::before,
                    ::after {
                        --tw-content: "";
                    }

                    /*
        1. Use a consistent sensible line-height in all browsers.
        2. Prevent adjustments of font size after orientation changes in iOS.
        3. Use a more readable tab size.
        4. Use the user's configured `sans` font-family by default.
        */

            html {
                line-height: 1.5;
                /* 1 */
                -webkit-text-size-adjust: 100%;
                /* 2 */
                -moz-tab-size: 4;
                /* 3 */
                -o-tab-size: 4;
                tab-size: 4;
                /* 3 */
                font-family: var(--tw-font-family-sans);
                /* 4 */
            }

            /*
        1. Remove the margin in all browsers.
        2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
        */

            body {
                margin: 0;
                /* 1 */
                line-height: inherit;
                /* 2 */
            }

            /*
        1. Add the correct height in Firefox.
        2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
        3. Ensure horizontal rules are visible by default.
        */

            hr {
                height: 0;
                /* 1 */
                color: inherit;
                /* 2 */
                border-top-width: 1px;
                /* 3 */
            }

            /*
        Add the correct text decoration in Chrome, Edge, and Safari.
        */

            abbr:where([title]) {
                -webkit-text-decoration: underline dotted;
                text-decoration: underline dotted;
            }

            /*
        Remove the default font size and weight for headings.
        */

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-size: inherit;
                font-weight: inherit;
            }

            /*
        Reset links to optimize for opt-in styling instead of opt-out.
        */

            a {
                color: inherit;
                text-decoration: inherit;
            }

            /*
        Add the correct font weight in Edge and Safari.
        */

            b,
            strong {
                font-weight: bolder;
            }

            /*
        1. Use the user's configured `mono` font family by default.
        2. Correct the odd `em` font sizing in all browsers.
        */

            code,
            kbd,
            samp,
            pre {
                font-family: var(--tw-font-family-mono);
                /* 1 */
                font-size: 1em;
                /* 2 */
            }

            /*
        Add the correct font size in all browsers.
        */

            small {
                font-size: 80%;
            }

            /*
        Prevent `sub` and `sup` elements from affecting the line height in all browsers.
        */

            sub,
            sup {
                font-size: 75%;
                line-height: 0;
                position: relative;
                vertical-align: baseline;
            }

            sub {
                bottom: -0.25em;
            }

            sup {
                top: -0.5em;
            }

            /*
        1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
        2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
        3. Remove gaps between table borders by default.
        */

            table {
                text-indent: 0;
                /* 1 */
                border-color: inherit;
                /* 2 */
                border-collapse: collapse;
                /* 3 */
            }

            /*
        1. Change the font styles in all browsers.
        2. Remove the margin in Firefox and Safari.
        3. Remove default padding in all browsers.
        */

            button,
            input,
            optgroup,
            select,
            textarea {
                font-family: inherit;
                /* 1 */
                font-size: 100%;
                /* 1 */
                font-weight: inherit;
                /* 1 */
                line-height: inherit;
                /* 1 */
                color: inherit;
                /* 1 */
                margin: 0;
                /* 2 */
                padding: 0;
                /* 3 */
            }

            /*
        Remove the inheritance of text transform in Edge and Firefox.
        */

            button,
            select {
                text-transform: none;
            }

            /*
        1. Correct the inability to style clickable types in iOS and Safari.
        2. Remove default button styles.
        */

            button,
            [type="button"],
            [type="reset"],
            [type="submit"] {
                -webkit-appearance: button;
                /* 1 */
                background-color: transparent;
                /* 2 */
                background-image: none;
                /* 2 */
            }

            /*
        Use the modern Firefox focus style for all focusable elements.
        */

            :-moz-focusring {
                outline: auto;
            }

            /*
        Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
        */

            :-moz-ui-invalid {
                box-shadow: none;
            }

            /*
        Add the correct vertical alignment in Chrome and Firefox.
        */

            progress {
                vertical-align: baseline;
            }

            /*
        Correct the cursor style of increment and decrement buttons in Safari.
        */

            ::-webkit-inner-spin-button,
            ::-webkit-outer-spin-button {
                height: auto;
            }

            /*
        1. Correct the odd appearance in Chrome and Safari.
        2. Correct the outline style in Safari.
        */

            [type="search"] {
                -webkit-appearance: textfield;
                /* 1 */
                outline-offset: -2px;
                /* 2 */
            }

            /*
        Remove the inner padding in Chrome and Safari on macOS.
        */

            ::-webkit-search-decoration {
                -webkit-appearance: none;
            }

            /*
        1. Correct the inability to style clickable types in iOS and Safari.
        2. Change font properties to `inherit` in Safari.
        */

            ::-webkit-file-upload-button {
                -webkit-appearance: button;
                /* 1 */
                font: inherit;
                /* 2 */
            }

            /*
        Add the correct display in Chrome and Safari.
        */

            summary {
                display: list-item;
            }

            /*
        Removes the default spacing and border for appropriate elements.
        */

            blockquote,
            dl,
            dd,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            hr,
            figure,
            p,
            pre {
                margin: 0;
            }

            fieldset {
                margin: 0;
                padding: 0;
            }

            legend {
                padding: 0;
            }

            ol,
            ul,
            menu {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            /*
        Prevent resizing textareas horizontally by default.
        */

            textarea {
                resize: vertical;
            }

            /*
        1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
        2. Set the default placeholder color to the user's configured gray 400 color.
        */

            input::-moz-placeholder,
            textarea::-moz-placeholder {
                opacity: 1;
                /* 1 */
                color: rgb(var(--tw-color-gray-400) / 1);
                /* 2 */
            }

            input::placeholder,
            textarea::placeholder {
                opacity: 1;
                /* 1 */
                color: rgb(var(--tw-color-gray-400) / 1);
                /* 2 */
            }

            /*
        Set the default cursor for buttons.
        */

            button,
            [role="button"] {
                cursor: pointer;
            }

            /*
        Make sure disabled buttons don't get the pointer cursor.
        */
            :disabled {
                cursor: default;
            }

            /*
        1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
        2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
        This can trigger a poorly considered lint error in some tools but is included by design.
        */

            img,
            svg,
            video,
            canvas,
            audio,
            iframe,
            embed,
            object {
                display: block;
                /* 1 */
                vertical-align: middle;
                /* 2 */
            }

            /*
        Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
        */

            img,
            video {
                max-width: 100%;
                height: auto;
            }

            *,
            ::before,
            ::after {
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-pan-x: ;
                --tw-pan-y: ;
                --tw-pinch-zoom: ;
                --tw-scroll-snap-strictness: proximity;
                --tw-ordinal: ;
                --tw-slashed-zero: ;
                --tw-numeric-figure: ;
                --tw-numeric-spacing: ;
                --tw-numeric-fraction: ;
                --tw-ring-inset: ;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgb(147 197 253 / 0.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                --tw-blur: ;
                --tw-brightness: ;
                --tw-contrast: ;
                --tw-grayscale: ;
                --tw-hue-rotate: ;
                --tw-invert: ;
                --tw-saturate: ;
                --tw-sepia: ;
                --tw-drop-shadow: ;
                --tw-backdrop-blur: ;
                --tw-backdrop-brightness: ;
                --tw-backdrop-contrast: ;
                --tw-backdrop-grayscale: ;
                --tw-backdrop-hue-rotate: ;
                --tw-backdrop-invert: ;
                --tw-backdrop-opacity: ;
                --tw-backdrop-saturate: ;
                --tw-backdrop-sepia: ;
            }

            ::-webkit-backdrop {
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-pan-x: ;
                --tw-pan-y: ;
                --tw-pinch-zoom: ;
                --tw-scroll-snap-strictness: proximity;
                --tw-ordinal: ;
                --tw-slashed-zero: ;
                --tw-numeric-figure: ;
                --tw-numeric-spacing: ;
                --tw-numeric-fraction: ;
                --tw-ring-inset: ;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgb(147 197 253 / 0.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                --tw-blur: ;
                --tw-brightness: ;
                --tw-contrast: ;
                --tw-grayscale: ;
                --tw-hue-rotate: ;
                --tw-invert: ;
                --tw-saturate: ;
                --tw-sepia: ;
                --tw-drop-shadow: ;
                --tw-backdrop-blur: ;
                --tw-backdrop-brightness: ;
                --tw-backdrop-contrast: ;
                --tw-backdrop-grayscale: ;
                --tw-backdrop-hue-rotate: ;
                --tw-backdrop-invert: ;
                --tw-backdrop-opacity: ;
                --tw-backdrop-saturate: ;
                --tw-backdrop-sepia: ;
            }

            ::backdrop {
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-pan-x: ;
                --tw-pan-y: ;
                --tw-pinch-zoom: ;
                --tw-scroll-snap-strictness: proximity;
                --tw-ordinal: ;
                --tw-slashed-zero: ;
                --tw-numeric-figure: ;
                --tw-numeric-spacing: ;
                --tw-numeric-fraction: ;
                --tw-ring-inset: ;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgb(147 197 253 / 0.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                --tw-blur: ;
                --tw-brightness: ;
                --tw-contrast: ;
                --tw-grayscale: ;
                --tw-hue-rotate: ;
                --tw-invert: ;
                --tw-saturate: ;
                --tw-sepia: ;
                --tw-drop-shadow: ;
                --tw-backdrop-blur: ;
                --tw-backdrop-brightness: ;
                --tw-backdrop-contrast: ;
                --tw-backdrop-grayscale: ;
                --tw-backdrop-hue-rotate: ;
                --tw-backdrop-invert: ;
                --tw-backdrop-opacity: ;
                --tw-backdrop-saturate: ;
                --tw-backdrop-sepia: ;
            }
        }

        div.idcard {
            height: -webkit-fit-content;
            height: -moz-fit-content;
            height: fit-content;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content;
            --tw-bg-opacity: 1;
            background-color: rgb(var(--tw-color-gray-100) / var(--tw-bg-opacity));
            margin: var(--tw-size-6);
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Unknown class .justify-cente */
        }

        div.idcard>div.idcard__unique27 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        div.idcard>div>div.idcard__unique29 {
            border-radius: var(--tw-border-radius-lg);
            position: relative;
            border-width: 1px;
            overflow: hidden;
            height: 288px;
            width: 523px;
            background-image: linear-gradient(to bottom left, var(--tw-gradient-stops));
            margin-bottom: var(--tw-size-3);
            --tw-gradient-from: {{ $member->member_type == 1 ? '#eac282' : '#f4d3d3' }};
            --tw-gradient-to: rgb(234 194 130 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
            --tw-gradient-to: {{ $member->member_type == 1 ? '#8e6b47' : '#fcf0ed' }};
        }

        div.idcard>div>div>div.idcard__unique1 {
            position: absolute;
            z-index: 50;
            top: calc(var(--tw-size-9) * -1);
            left: calc(var(--tw-size-10) * -1);
        }

        div.idcard>div>div>div.idcard__unique2 {
            position: absolute;
            z-index: 40;
            top: calc(var(--tw-size-9) * -1);
            left: calc(var(--tw-size-4) * 1);
            opacity: {{ $member->member_type == 0 ? 0.1 : 0.7 }};
        }

        div.idcard>div>div>div.idcard__unique3 {
            position: absolute;
            z-index: 30;
            top: calc(var(--tw-size-9) * -1);
            left: calc(var(--tw-size-1) * -1);
        }

        div.idcard>div>div>div.idcard__unique4 {
            position: absolute;
            z-index: 20;
            top: calc(var(--tw-size-48) * -1);
            left: calc(var(--tw-size-2) * -1);
        }

        div.idcard>div>div>div.idcard__unique5 {
            position: absolute;
            top: calc(var(--tw-size-4) * -1);
            left: calc(var(--tw-size-2) * -14);
            opacity: {{ $member->member_type == 0 ? 0.3 : 0.7 }};
        }

        div.idcard>div>div>div.idcard__unique6 {
            position: absolute;
            top: calc(var(--tw-size-4) * -1);
            left: calc(var(--tw-size-2) * 2);
            opacity: {{ $member->member_type == 0 ? 0.3 : 0.7 }};
        }

        div.idcard>div>div>div.idcard__unique7 {
            height: 288px;
            width: 523px;
            position: absolute;
            top: var(--tw-size-0);
            bottom: var(--tw-size-0);
            left: var(--tw-size-0);
            right: var(--tw-size-0);
        }

        div.idcard>div>div>div>div.idcard__unique11 {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        div.idcard>div>div>div>div>img {
            position: absolute;
            z-index: 60;
            width: 100px;
            height: 100px;
            bottom: var(--tw-size-32);
            left: var(--tw-size-12);
            border-width: 1px;
            border-radius: var(--tw-border-radius-full);
            -o-object-fit: cover;
            object-fit: cover;
            --tw-border-opacity: 1;
            border-color: rgb({{ $member->member_type == 1 ? '234 194 130' : '255 177 157' }} / var(--tw-border-opacity));
            --tw-bg-opacity: 1;
            background-color: rgb({{ $member->member_type == 1 ? '142 107 71' : '242 114 114' }} / var(--tw-bg-opacity));
        }

        div.idcard>div>div>div>div>div.idcard__unique14 {
            position: absolute;
            z-index: 60;
            bottom: var(--tw-size-3);
            left: var(--tw-size-3);
        }

        div.idcard>div>div>div>div>div>div.idcard__unique16 {
            display: flex;
            align-items: flex-end;
            gap: var(--tw-size-2);
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique8 {
            width: 100px;
            height: 100px;
            position: relative;
            overflow: hidden;
            border-radius: var(--tw-border-radius-md);
            --tw-bg-opacity: 1;
            background-color: rgb(234 194 130 / var(--tw-bg-opacity));
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique9 {
            font-family: var(--tw-font-family-sans);
            font-weight: var(--tw-font-weight-semibold);
        }

        div.idcard>div>div>div>div>div>div>div>h1 {
            font-size: var(--tw-font-size-base);
            line-height: var(--tw-line-height-6);
            --tw-text-opacity: 1;
            color: rgb({{ $member->member_type == 1 ? '142 107 71' : '242 144 144' }} / var(--tw-text-opacity));
        }

        div.idcard>div>div>div>div>div>div>div>h2 {
            font-size: var(--tw-font-size-sm);
            line-height: var(--tw-line-height-5);
            --tw-text-opacity: 1;
            color: rgb({{ $member->member_type == 1 ? '234 194 130' : '255 255 255' }} / var(--tw-text-opacity));
        }

        div.idcard>div>div>div.idcard__unique10 {
            height: 288px;
            width: 523px;
            position: absolute;
            top: var(--tw-size-0);
            bottom: var(--tw-size-0);
            left: var(--tw-size-0);
            z-index: 100;
            right: var(--tw-size-0);
        }

        div.idcard>div>div>div>div.idcard__unique12 {
            position: absolute;
            top: var(--tw-size-4);
            right: var(--tw-size-4);
        }

        div.idcard>div>div>div>div>h1 {
            position: relative;
            font-family: var(--tw-font-family-sans);
            font-size: var(--tw-font-size-lg);
            line-height: var(--tw-line-height-7);
            font-weight: var(--tw-font-weight-bold);
            text-transform: uppercase;
            --tw-text-opacity: 1;
            color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-text-opacity));
        }

        div.idcard>div>div>div>div>h1>div {
            position: absolute;
            width: 100%;
            border-width: 2px;
            bottom: calc(var(--tw-size-7) * -1);
            --tw-border-opacity: 1;
            border-color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-border-opacity));
        }

        div.idcard>div>div>div>div>h3 {
            font-family: var(--tw-font-family-sans);
            font-size: var(--tw-font-size-sm);
            line-height: var(--tw-line-height-5);
            font-weight: var(--tw-font-weight-bold);
            text-transform: uppercase;
            text-align: end;
            --tw-text-opacity: 1;
            color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-text-opacity));
        }

        div.idcard>div>div>div>div.idcard__unique13 {
            position: absolute;
            top: var(--tw-size-20);
            right: var(--tw-size-4);
        }

        div.idcard>div>div>div>div>div.idcard__unique15 {
            display: grid;
            gap: var(--tw-size-2);
        }

        div.idcard>div>div>div>div>div>div.idcard__unique17 {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        div.idcard>div>div>div>div>div>div>h1 {
            font-family: var(--tw-font-family-sans);
            font-size: var(--tw-font-size-base);
            line-height: var(--tw-line-height-6);
            font-weight: var(--tw-font-weight-semibold);
            --tw-text-opacity: 1;
            color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-text-opacity));
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique18 {
            margin-left: var(--tw-size-1);
            padding: var(--tw-size-1_5);
            border-radius: var(--tw-border-radius-full);
            --tw-bg-opacity: 1;
            background-color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-bg-opacity));
        }

        div.idcard>div>div>div>div>div>div>div>svg {
            width: var(--tw-size-5);
            height: var(--tw-size-5);
        }

        div.idcard>div>div>div>div>div>div.idcard__unique19 {
            display: {{ $member->url_fb != null ? 'flex' : 'none' }};
            align-items: center;
            justify-content: flex-end;
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique20 {
            margin-left: var(--tw-size-1);
            padding: var(--tw-size-1_5);
            border-radius: var(--tw-border-radius-full);
            --tw-bg-opacity: 1;
            background-color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-bg-opacity));
        }

        div.idcard>div>div>div>div>div>div.idcard__unique21 {
            display: {{ $member->url_ig != null ? 'flex' : 'none' }};
            align-items: center;
            justify-content: flex-end;
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique22 {
            margin-left: var(--tw-size-1);
            padding: var(--tw-size-1_5);
            border-radius: var(--tw-border-radius-full);
            --tw-bg-opacity: 1;
            background-color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-bg-opacity));
        }

        div.idcard>div>div>div>div>div>div.idcard__unique23 {
            display: {{ $member->url_tiktok != null ? 'flex' : 'none' }};
            align-items: center;
            justify-content: flex-end;
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique24 {
            margin-left: var(--tw-size-1);
            padding: var(--tw-size-1_5);
            border-radius: var(--tw-border-radius-full);
            --tw-bg-opacity: 1;
            background-color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-bg-opacity));
        }

        div.idcard>div>div>div>div>div>div.idcard__unique25 {
            display: {{ $member->url_website != null ? 'flex' : 'none' }};
            align-items: center;
            justify-content: flex-end;
        }

        div.idcard>div>div>div>div>div>div>div.idcard__unique26 {
            margin-left: var(--tw-size-1);
            padding: var(--tw-size-1_5);
            border-radius: var(--tw-border-radius-full);
            --tw-bg-opacity: 1;
            background-color: rgb({{ $member->member_type == 1 ? '10 55 73' : '242 144 144' }} / var(--tw-bg-opacity));
        }

        div.idcard>div.idcard__unique28 {
            border-radius: var(--tw-border-radius-lg);
            position: relative;
            border-width: 1px;
            overflow: hidden;
            height: 288px;
            width: 523px;
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
            margin-bottom: var(--tw-size-3);
            --tw-gradient-from: {{ $member->member_type == 1 ? '#000f20' : '#f4d3d3' }};
            --tw-gradient-to: rgb(0 15 32 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
            --tw-gradient-to: {{ $member->member_type == 1 ? '#0a3749' : '#fcf0ed' }};
        }

        div.idcard>div>div.idcard__unique30 {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        div.idcard>div>div>img {
            width: 135px;
            -o-object-fit: cover;
            object-fit: cover;
        }

        div.idcard>div>div>div.idcard__unique31 {
            width: 100%;
            position: absolute;
            bottom: var(--tw-size-3);
            right: var(--tw-size-0);
            left: var(--tw-size-0);
            background-image: linear-gradient(to bottom left, var(--tw-gradient-stops));
            height: 25px;
            --tw-gradient-from: {{ $member->member_type == 1 ? '#eac282' : '#f6a2a2' }};
            --tw-gradient-to: rgb(234 194 130 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
            --tw-gradient-to: {{ $member->member_type == 1 ? '#8e6b47' : '#ffb19d' }};
        }

        div.idcard>div>div>div>div.idcard__unique32 {
            font-family: var(--tw-font-family-sans);
            font-size: var(--tw-font-size-base);
            line-height: var(--tw-line-height-6);
            font-weight: var(--tw-font-weight-semibold);
            text-align: center;
            --tw-text-opacity: 1;
            color: rgb({{ $member->member_type == 1 ? '10 55 73' : '255 255 255' }} / var(--tw-text-opacity));
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="idcard">
        <!-- front -->
        <div class="idcard__unique27">
            <div class="idcard__unique29">
                <!-- path front -->
                <div class="idcard__unique1">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 496" width="400"
                        height="496">
                        <defs>
                            <linearGradient id="g1" x1="-181" y1="261.4" x2="-27.6" y2="-57.5"
                                gradientUnits="userSpaceOnUse">
                                <stop offset="0"
                                    stop-color="{{ $member->member_type == 1 ? '#000f20' : '#f6a2a2' }}" />
                                <stop offset="1"
                                    stop-color="{{ $member->member_type == 1 ? '#0a3749' : '#f4d3d3' }}" />
                            </linearGradient>
                        </defs>
                        <path id="&lt;Path&gt;" class="pathFront"
                            d="m8.5 321.6c-3.6-9-5.3-18.7-4.8-28.4l11.6-226.7c2.2-44.4 46.6-74.4 88.4-59.2 57 20.6 104.7 64.5 128.9 123.9l60.6 148.6c18.4 45-16.3 93.8-64.8 91.3l-161.8-8.3c-25.7-1.3-48.3-17.3-58.1-41.2z" />
                    </svg>
                </div>
                <!-- path shadow -->
                <div class="idcard__unique2">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 496" width="400"
                        height="496">
                        <defs>
                            <image width="765" height="918" id="img1"
                                href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAv0AAAOWCAMAAABLXN0LAAAAAXNSR0IB2cksfwAAAwBQTFRF/v7+AAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABnXhcDwAAAQB0Uk5TAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIjJCUmJygpKissLS4vMDEyMzQ1Njc4OTo7PD0+P0BB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" />
                        </defs>
                        <use id="&lt;Image&gt;" style="opacity: 0.9; mix-blend-mode: multiply" href="#img1"
                            transform="matrix(.444,0,0,.444,-20,-18)" />
                    </svg>
                </div>
                <!-- path back -->
                <div class="idcard__unique3">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 496" width="400"
                        height="496">
                        <defs>
                            <linearGradient id="back" x1="-177.5" y1="275" x2="-43.2" y2="-45.1"
                                gradientUnits="userSpaceOnUse">
                                <stop offset="0"
                                    stop-color="{{ $member->member_type == 1 ? '#000f20' : '#f6a2a2' }}" />
                                <stop offset="1"
                                    stop-color="{{ $member->member_type == 1 ? '#0a3749' : '#f4d3d3' }}" />
                            </linearGradient>
                        </defs>
                        <path id="&lt;Path&gt;" class="pathBack"
                            d="m11.2 324.6c-4.1-8.7-6.2-18.1-6.2-27.7v-222.7c0-43.5 42-75.1 83.6-62.4 56.9 17.4 105.9 58 132.6 115l66.7 142.5c20.3 43.2-11.2 92.7-58.9 92.7h-158.9c-25.3 0-48.2-14.6-58.9-37.4z" />
                    </svg>
                </div>
                <!-- path top -->
                <div class="idcard__unique4">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 342 280" width="400"
                        height="327">
                        <title>New Project</title>
                        <defs>
                            <linearGradient id="front" x1="-57.2" y1="143.6" x2="161" y2="-109.6"
                                gradientUnits="userSpaceOnUse">
                                <stop offset="0"
                                    stop-color="{{ $member->member_type == 1 ? '#8e6b47' : '#fcf0ed' }}" />
                                <stop offset="1"
                                    stop-color="{{ $member->member_type == 1 ? '#eac282' : '#ffb19d' }}" />
                            </linearGradient>
                        </defs>
                        <path id="&lt;Path&gt;" class="path-top"
                            d="m86 276.1l-79.2-1.7 0.5-249.5 331.2-19.6-141.8 211.7c-24.8 37-66.3 59.1-110.7 59.1z" />
                    </svg>
                </div>
                <!-- path top shadow -->
                <div class="idcard__unique5">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 372 303" width="400"
                        height="326">
                        <defs>
                            <image width="792" height="665" id="top"
                                href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAxgAAAKZCAMAAAAMOH2fAAAAAXNSR0IB2cksfwAAAwBQTFRF/v7+AAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABnXhcDwAAAQB0Uk5TAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIjJCUmJygpKissLS4vMDEyMzQ1Njc4OTo7PD0+P0BB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" />
                        </defs>
                        <use id="&lt;Image&gt;" style="opacity: 0.9; mix-blend-mode: multiply" href="#top"
                            transform="matrix(.48,0,0,.48,-4.44,-8.88)" />
                    </svg>
                </div>
                <!-- path shadow 2 -->
                <div class="idcard__unique6">
                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 496" width="400"
                        height="496">
                        <defs>
                            <image width="765" height="918" id="img1"
                                href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAv0AAAOWCAMAAABLXN0LAAAAAXNSR0IB2cksfwAAAwBQTFRF/v7+AAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABAAABnXhcDwAAAQB0Uk5TAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIjJCUmJygpKissLS4vMDEyMzQ1Njc4OTo7PD0+P0BB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" />
                        </defs>
                        <use id="&lt;Image&gt;" style="opacity: 0.9; mix-blend-mode: multiply" href="#img1"
                            transform="matrix(.444,0,0,.444,-20,-18)" />
                    </svg>
                </div>
                <!-- data -->
                <div class="idcard__unique7">
                    <div class="idcard__unique11">
                        <img src="{{ $member->image != null ? route('member-image', $member->image) : asset('image/logo.png') }}"
                            alt="">
                        <div class="idcard__unique14">
                            <div class="idcard__unique16">
                                <!-- qrcode -->
                                {{-- <div class="idcard__unique8">
                                </div> --}}
                                {!! QrCode::size(100)->margin(1)->generate('https://pusat.lsskincare.id/profile/' . $member->username) !!}
                                <div class="idcard__unique9">
                                    <h1>
                                        Join On
                                    </h1>
                                    <h2>
                                        {{ $member->join_on }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- data text -->
                <div class="idcard__unique10">
                    <!-- header -->
                    <div class="idcard__unique12">
                        <h1>
                            {{ $member->member_name }}
                            <div></div>
                        </h1>
                        <h3>
                            {{ $member->member_type == 0 ? 'Reseller' : 'Agen' }}
                        </h3>
                    </div>
                    <!-- center -->
                    <div class="idcard__unique13">
                        <div class="idcard__unique15">
                            <!-- wa -->
                            <div class="idcard__unique17">
                                <h1>
                                    {{ $member->member_phone }}
                                </h1>
                                <div class="idcard__unique18">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58"
                                        xmlspace="preserve" fill="#eac282">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <path
                                                    style="fill:{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}"
                                                    d="M0,58l4.988-14.963C2.457,38.78,1,33.812,1,28.5C1,12.76,13.76,0,29.5,0S58,12.76,58,28.5 S45.24,57,29.5,57c-4.789,0-9.299-1.187-13.26-3.273L0,58z">
                                                </path>
                                                <path
                                                    style="fill:{{ $member->member_type == 1 ? '#0a3749' : '#f27272' }}"
                                                    d="M47.683,37.985c-1.316-2.487-6.169-5.331-6.169-5.331c-1.098-0.626-2.423-0.696-3.049,0.42 c0,0-1.577,1.891-1.978,2.163c-1.832,1.241-3.529,1.193-5.242-0.52l-3.981-3.981l-3.981-3.981c-1.713-1.713-1.761-3.41-0.52-5.242 c0.272-0.401,2.163-1.978,2.163-1.978c1.116-0.627,1.046-1.951,0.42-3.049c0,0-2.844-4.853-5.331-6.169 c-1.058-0.56-2.357-0.364-3.203,0.482l-1.758,1.758c-5.577,5.577-2.831,11.873,2.746,17.45l5.097,5.097l5.097,5.097 c5.577,5.577,11.873,8.323,17.45,2.746l1.758-1.758C48.048,40.341,48.243,39.042,47.683,37.985z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- fb -->
                            <div class="idcard__unique19">
                                <h1>
                                    {{ $member->url_fb }}
                                </h1>
                                <div class="idcard__unique20">
                                    <svg viewBox="0 0 24 24" id="meteor-icon-kit__regular-facebook" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 17.9895 4.38823 22.954 10.125 23.8542V15.4688H7.07812V12H10.125V9.35625C10.125 6.34875 11.9165 4.6875 14.6576 4.6875C15.9705 4.6875 17.3438 4.92188 17.3438 4.92188V7.875H15.8306C14.3399 7.875 13.875 8.80001 13.875 9.74899V12H17.2031L16.6711 15.4688H13.875V23.8542C19.6118 22.954 24 17.9895 24 12Z"
                                                fill="{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- ig -->
                            <div class="idcard__unique21">
                                <h1>
                                    {{ $member->url_ig }}
                                </h1>
                                <div class="idcard__unique22">
                                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="m0 0h32v32h-32z"></path>
                                                <path
                                                    d="m17.0830929.03277248c8.1190907 0 14.7619831 6.64289236 14.7619831 14.76198302v2.3064326c0 8.1190906-6.6429288 14.761983-14.7619831 14.761983h-2.3064325c-8.11909069 0-14.76198306-6.6428924-14.76198306-14.761983v-2.3064326c0-8.11909066 6.64289237-14.76198302 14.76198306-14.76198302zm-.8630324 8.0002641-.2053832-.0002641c-1.7102378 0-3.4204757.05652851-3.4204757.05652851-2.4979736 0-4.52299562 2.02501761-4.52299562 4.52298561 0 0-.05191606 1.4685349-.05624239 3.0447858l-.00028625.2060969c0 1.7648596.05652864 3.590089.05652864 3.5900891 0 2.497968 2.02502202 4.5229856 4.52299562 4.5229856 0 0 1.5990132.0565285 3.2508899.0565285 1.7648634 0 3.6466255-.0565285 3.6466255-.0565285 2.4979736 0 4.4664317-1.9684539 4.4664317-4.4664219 0 0 .0565286-1.8046833.0565286-3.5335605l-.0010281-.4057303c-.0076601-1.5511586-.0555357-3.0148084-.0555357-3.0148084 0-2.4979681-1.9684582-4.46642191-4.4664317-4.46642191 0 0-1.6282521-.05209668-3.2716213-.05626441zm-.2053831 1.43969747c1.4024317 0 3.2005639.04637875 3.2005638.04637875 2.0483524 0 3.3130573 1.2647021 3.3130573 3.31305 0 0 .0463789 1.7674322.0463789 3.1541781 0 1.4176885-.0463789 3.2469355-.0463789 3.2469355 0 2.048348-1.2647049 3.31305-3.3130573 3.31305 0 0-1.5901757.0389711-2.9699093.0454662l-.3697206.0009126c-1.3545375 0-3.0049692-.0463788-3.0049692-.0463788-2.0483172 0-3.36958592-1.321301-3.36958592-3.3695785 0 0-.04637885-1.8359078-.04637885-3.2830941 0-1.3545344.04637885-3.061491.04637885-3.061491 0-2.0483479 1.32130402-3.31305 3.36958592-3.31305 0 0 1.7416035-.04637875 3.1440353-.04637875zm-.0000353 2.46195055c-2.2632951 0-4.0980441 1.8347448-4.0980441 4.098035s1.8347489 4.098035 4.0980441 4.098035 4.0980441-1.8347448 4.0980441-4.098035c0-2.2632901-1.8347489-4.098035-4.0980441-4.098035zm0 1.4313625c1.4727754 0 2.6666784 1.1939004 2.6666784 2.6666725s-1.193903 2.6666726-2.6666784 2.6666726c-1.4727401 0-2.6666784-1.1939005-2.6666784-2.6666726s1.1939031-2.6666725 2.6666784-2.6666725zm4.2941322-2.5685935c-.5468547 0-.9902027.4455321-.9902027.9950991 0 .5495671.443348.9950639.9902027.9950639.5468546 0 .9901674-.4454968.9901674-.9950639 0-.5496023-.4433128-.9950991-.9901674-.9950991z"
                                                    fill="{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}"
                                                    fill-rule="nonzero"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- tiktok -->
                            <div class="idcard__unique23">
                                <h1>
                                    {{ $member->url_tiktok }}
                                </h1>
                                <div class="idcard__unique24">
                                    <svg fill="{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}"
                                        viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>TikTok icon</title>
                                            <path
                                                d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- website -->
                            <div class="idcard__unique25">
                                <h1>
                                    {{ $member->url_website }}
                                </h1>
                                <div class="idcard__unique26">
                                    <svg viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <circle cx="96" cy="96" r="74"
                                                stroke="{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}"
                                                stroke-width="12"></circle>
                                            <ellipse cx="96" cy="96"
                                                stroke="{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}"
                                                stroke-width="12" rx="30" ry="74"></ellipse>
                                            <path stroke="{{ $member->member_type == 1 ? '#eac282' : '#ffffff' }}"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="12"
                                                d="M28 72h136M28 120h136"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- back -->
        <div class="idcard__unique28">
            <div class="idcard__unique30">
                <img src="{{ $member->member_type == 1 ? asset('image/logo_emas.png') : asset('image/logo_id.png') }}"
                    alt="">
                <!-- line footer -->
                <div class="idcard__unique31">
                    <div class="idcard__unique32">
                        www.pusat.lsskincare.id
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</body>

</html>
