<nav class="flex justify-center items-center pt-11 h-20 ">    
        <img src="{{ asset('images/Group 163654 (1).png') }}" alt="Image" class=" w-40 h-16">
        {{-- <div class="language-switch">
                <a href="{{ route('locale.switch', 'en') }}" class="text-blue-500">English</a> | 
    <a href="{{ route('locale.switch', 'ar') }}" class="text-blue-500">العربية</a>
            </div> --}}
</nav>
<div class="absolute top-4 right-4 z-50 sm:top-4 sm:right-4 md:top-6 md:right-6 lg:top-8 lg:right-8">
        <div class="relative">
            <button id="languageDropdown" class="flex items-center text-white border-2 border-white px-3 py-2 sm:px-4 sm:py-2 rounded hover:bg-gray-700 focus:outline-none">
                <img src="{{ asset('images/translate.png') }}" alt="Language" class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2">
                {{ strtoupper(app()->getLocale()) }}
                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="dropdownMenu" class="absolute right-0 mt-2 bg-white text-gray-800 rounded shadow-md hidden z-10 w-32 sm:w-40">
                <a href="{{ route('locale.switch', 'en') }}" class="block px-3 py-2 sm:px-4 sm:py-2 hover:bg-gray-200 text-sm sm:text-base">English</a>
                <a href="{{ route('locale.switch', 'ar') }}" class="block px-3 py-2 sm:px-4 sm:py-2 hover:bg-gray-200 text-sm sm:text-base">العربية</a>
            </div>
        </div>
    </div>
