<section class="py-20">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center space-y-6 md:space-y-0">
        <!-- Text Section -->
        <div class="max-w-2xl text-center md:text-left">
            <h1 class="font-['Roboto'] font-bold text-gray-200 text-5xl leading-tight">
                All the Football Action<br> at Your Fingertips
            </h1>
            <p class="text-gray-400 mt-6 text-xl">
                Whether you're checking live scores, following your favorite teams, or diving deep into match stats, our app brings everything you need to stay updated in the world of football.
            </p>
            <a href="#" class="inline-flex items-center mt-8 px-6 py-3 rounded-lg bg-gradient-to-r from-[#8a2be2] to-[#4169e1] text-white font-medium text-lg hover:opacity-90 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download now
            </a>
        </div>
        <!-- Image Section -->
        <div class="w-full md:w-1/2 clip-image">
            <img src="{{ asset('images/image_1.png') }}" alt="Football Action" class="w-full h-auto object-cover">
        </div>
    </div>
</section>

<style>
    .clip-image {
        clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%);
    
    }
</style>
