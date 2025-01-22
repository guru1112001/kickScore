<section class="py-10 md:py-20">
    <div @class([
        'container mx-auto px-4 flex flex-col md:flex-row items-center space-y-6 md:space-y-0',
        'md:flex-row-reverse' => App::isLocale('ar')
    ])>
        <!-- Text Section -->
        <div @class([
            'max-w-2xl text-center md:text-start w-full md:w-1/2',
            'pr-0 md:pr-8' => !App::isLocale('ar'),
            'pr-0 md:pl-8' => App::isLocale('ar')
        ])>
            <h1 class="font-['Source Sans'] font-bold text-gray-200 text-3xl md:text-5xl leading-tight">
                {{ __('messages.Hero_section_heading', [], app()->getLocale()) }}
            </h1>
            <p class="text-gray-400 mt-4 md:mt-6 text-base md:text-xl">
                @lang('messages.Hero_section_description')
            </p>
            <a href="#" class="inline-flex items-center mt-6 md:mt-8 px-4 md:px-6 py-2 md:py-3 rounded-lg bg-gradient-to-r from-[#8a2be2] to-[#4169e1] text-white font-medium text-base md:text-lg hover:opacity-90 transition-opacity justify-center">
                <svg @class([
                    'h-4 w-4 md:h-5 md:w-5',
                    'mr-2' => !App::isLocale('ar'),
                    'ml-2' => App::isLocale('ar')
                ]) xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <linearGradient id="AraffhWwwEqZfgFEBZFoqa_L1ws9zn2uD01_gr1" x1="18.102" x2="25.297" y1="3.244" y2="34.74" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#35ab4a"></stop><stop offset=".297" stop-color="#31a145"></stop><stop offset=".798" stop-color="#288739"></stop><stop offset="1" stop-color="#237a33"></stop></linearGradient><path fill="url(#AraffhWwwEqZfgFEBZFoqa_L1ws9zn2uD01_gr1)" d="M13.488,4.012C10.794,2.508,7.605,3.778,6.45,6.323L24.126,24l9.014-9.014L13.488,4.012z"></path><linearGradient id="AraffhWwwEqZfgFEBZFoqb_L1ws9zn2uD01_gr2" x1="19.158" x2="21.194" y1="23.862" y2="66.931" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f14e5d"></stop><stop offset=".499" stop-color="#ea3d4f"></stop><stop offset="1" stop-color="#e12138"></stop></linearGradient><path fill="url(#AraffhWwwEqZfgFEBZFoqb_L1ws9zn2uD01_gr2)" d="M33.14,33.014L24.126,24L6.45,41.677 c1.156,2.546,4.345,3.815,7.038,2.312L33.14,33.014z"></path><linearGradient id="AraffhWwwEqZfgFEBZFoqc_L1ws9zn2uD01_gr3" x1="32.943" x2="36.541" y1="14.899" y2="43.612" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffd844"></stop><stop offset=".519" stop-color="#ffc63f"></stop><stop offset="1" stop-color="#ffb03a"></stop></linearGradient><path fill="url(#AraffhWwwEqZfgFEBZFoqc_L1ws9zn2uD01_gr3)" d="M41.419,28.393 c1.72-0.96,2.58-2.676,2.581-4.393c-0.001-1.717-0.861-3.434-2.581-4.393l-8.279-4.621L24.126,24l9.014,9.014L41.419,28.393z"></path><linearGradient id="AraffhWwwEqZfgFEBZFoqd_L1ws9zn2uD01_gr4" x1="13.853" x2="15.572" y1="5.901" y2="42.811" gradientUnits="userSpaceOnUse"><stop offset=".003" stop-color="#0090e6"></stop><stop offset="1" stop-color="#0065a0"></stop></linearGradient><path fill="url(#AraffhWwwEqZfgFEBZFoqd_L1ws9zn2uD01_gr4)" d="M6.45,6.323C6.168,6.948,6,7.652,6,8.408 v31.179c0,0.761,0.164,1.463,0.45,2.09l17.674-17.68L6.45,6.323z"></path>
                </svg>
                <svg @class([
                    'h-4 w-4 md:h-5 md:w-5',
                    'mr-2' => !App::isLocale('ar'),
                    'ml-2' => App::isLocale('ar')
                ]) xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" id="app-store">
                    <defs>
                        <linearGradient id="a" x1="-1315.782" x2="-1195.782" y1="529.793" y2="529.793" gradientTransform="rotate(-90 -832.788 -362.994)" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#1d6ff2"></stop>
                            <stop offset="1" stop-color="#1ac8fc"></stop>
                        </linearGradient>
                    </defs>
                    <path fill="url(#a)" fill-rule="evenodd" d="M120,26V94a25.94821,25.94821,0,0,1-26,26H26A25.94821,25.94821,0,0,1,0,94V26A25.94821,25.94821,0,0,1,26,0H94A25.94821,25.94821,0,0,1,120,26Z"></path>
                    <path fill="#fff" fill-rule="evenodd" d="M82.6,69H97.5a5.5,5.5,0,0,1,0,11H82.6Z"></path>
                    <path fill="#fff" fill-rule="evenodd" d="M64.3 69a7.85317 7.85317 0 0 1 7.9 7.9 8.14893 8.14893 0 0 1-.6 3.1H22.5a5.5 5.5 0 0 1 0-11zM62.9 32.8v9.6H56.5L48.7 29a5.19712 5.19712 0 1 1 9-5.2zM68.4 42.1L95.7 89.4a5.48862 5.48862 0 0 1-9.5 5.5L69.7 66.2c-1.5-2.8-2.6-5-3.3-6.2A15.03868 15.03868 0 0 1 68.4 42.1z"></path>
                    <g>
                        <path fill="#fff" fill-rule="evenodd" d="M46 74H33.3L62 24.3a5.48862 5.48862 0 0 1 9.5 5.5zM39.3 85.5L34 94.8a5.48862 5.48862 0 1 1-9.5-5.5l3.9-6.8a8.59835 8.59835 0 0 1 3.9-.9A7.77814 7.77814 0 0 1 39.3 85.5z"></path>
                    </g>
                </svg>
                @lang('messages.Hero_section_download_now')
            </a>
        </div>
        <!-- Image Section -->
        <div @class([
            'w-full md:w-1/2 clip-image mt-6 md:mt-0',
            'clip-image-rtl' => App::isLocale('ar')
        ])>
            <img src="{{ asset('images/image_1.png') }}" alt="Football Action" class="w-full h-auto object-cover">
        </div>
    </div>
</section>

<style>
    .clip-image {
        clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%);
    }

    .clip-image-rtl {
        clip-path: polygon(0% 0%, 75% 0%, 100% 100%, 25% 100%);
    }

    @media (max-width: 768px) {
        .clip-image, .clip-image-rtl {
            clip-path: none;
        }
    }

    [dir="rtl"] .bg-gradient-to-r {
        background: linear-gradient(to left, #8a2be2, #4169e1);
    }
</style>