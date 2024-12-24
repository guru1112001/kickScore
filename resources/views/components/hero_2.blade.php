<section class="py-10 md:py-20 my-4 md:my-14 relative">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center relative">
    <!-- Text Section -->
    <div class="max-w-xl w-full md:w-1/2 z-10 relative">
      <h1 class="font-bold text-gray-200 text-xl md:text-4xl leading-tight text-center md:text-left">
        @lang('messages.Hero_section2_phone_heading')
      </h1>
      <p class="text-gray-400 mt-4 md:mt-6 text-xl text-center md:text-left">
        @lang('messages.Hero_section2_description')
      </p>
      <!-- Download Apps Section -->
      <div class="mt-4 md:mt-6 w-full text-center md:text-left">
        <div class="text-white text-base">@lang('messages.Hero_section2_downloadbtn'):</div>
        <div class="flex justify-center md:justify-start gap-4 mt-2">
          <div class="w-[118px] h-[39px] bg-center bg-no-repeat bg-cover cursor-pointer" style="background-image: url('{{ asset('images/image.png') }}')"></div>
          <div class="w-[132px] h-[39px] bg-center bg-no-repeat bg-cover cursor-pointer" style="background-image: url('{{ asset('images/image2.png') }}')"></div>
        </div>
      </div>
    </div>
    <!-- Image Section -->
    <div class="absolute hidden md:block iPhone15" ></div>
    <div class="absolute hidden md:block iPhone152" ></div>
  </div>
</section>

<!-- New Section with Image on Left and Text on Right -->
<section class="py-10 md:py-20 my-4 md:my-14">
  <div class="container mx-auto px-4 flex flex-col-reverse md:flex-row items-center">
    <div class="w-full mt-6 md:mt-0">
      <img src="{{ asset('images/Gamelisting.png') }}" alt="Game/Event Listing" class="w-full">
    </div>
    <div class="w-full md:pl-8 text-center md:text-left">
      <h2 class="font-bold text-gray-200 text-6xl leading-tight">
        @lang('messages.Hero_section2_Games/Event')
      </h2>
      <h2 class="font-bold text-[#F5C451] text-6xl leading-tight">@lang('messages.Hero_section2_Listing')</h2>
      <p class="mt-4 text-xl text-white">
        @lang('messages.Hero_section2_Games/Event_description')
      </p>
    </div>
  </div>
</section>

<!-- New Section with Image on Right and Text on Left -->
<section class="py-10 md:py-20 my-4 md:my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <div class="w-full md:w-1/2 md:pr-8 text-center md:text-left">
      <h2 class="font-bold text-[#6C63FF] text-6xl leading-tight">
        @lang('messages.Hero_section2_Goal')
      </h2>
      <h2 class="font-bold text-gray-200 text-6xl leading-tight">@lang('messages.Hero_section2_of_the_day')</h2>
      <p class="text-white text-xl mt-4">@lang('messages.Hero_section2_Goal_description')</p>
    </div>
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/Goaloftheday.png') }}" alt="Live Updates" class="w-full">
    </div>
  </div>
</section>

<!-- Additional Sections -->
<section class="py-10 md:py-20 my-4 md:my-14">
  <div class="container mx-auto px-4 flex flex-col-reverse md:flex-row items-center">
    <div class="w-full md:w-1/2 mt-6 md:mt-0">
      <img src="{{ asset('images/Match_trivia.png') }}" alt="Game/Event Listing" class="w-full">
    </div>
    <div class="w-full md:w-1/2 md:pl-8 text-center md:text-left">
      <h2 class="font-bold text-[#6C63FF] text-6xl leading-tight">@lang('messages.Hero_section2_Match')</h2>
      <h2 class="font-bold text-gray-200 text-6xl leading-tight">@lang('messages.Hero_section2_Trivia')</h2>
      <p class="text-white text-xl mt-4">@lang('messages.Hero_section2_Match_Trivia_description')</p>
    </div>
  </div>
</section>

<section class="py-10 md:py-20 my-4 md:my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <div class="w-full md:w-1/2 md:pr-8 text-center md:text-left">
      <h2 class="font-bold text-gray-200 text-6xl leading-tight">@lang('messages.Hero_section2_Match')</h2>
      <h2 class="font-bold text-[#F5C451] text-6xl leading-tight">@lang('messages.Hero_section2_Discussions')</h2>
      <p class="text-white text-xl mt-4">@lang('messages.Hero_section2_Match_Discussions_description')</p>
    </div>
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/Match_discusion.png') }}" alt="Live Updates" class="w-full">
    </div>
  </div>
</section>


<style>
  .clip-image {
    /* clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%); */
  }

  .iPhone15 {
    position: absolute;
    left: 599px;
    /* top: 929px; */
    width: 683px;
    height: 466px;
    background-image: url('{{ asset('images/iPhone 15.png') }}');
    background-position: center;
    background-repeat: no-repeat;
    /* background-size: cover; */
  }

  .iPhone152 {
    position: absolute;
    left: 921px;
    /* top: 907px; */
    width: 380px;
    height: 469px;
    background-image: url('{{ asset('images/iPhone152.png') }}');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .imageLink {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .downloadApps {
    color: #fff;
    font-size: 16px;
  }

  .image {
    display: flex;
    gap: 16px;
  }

  .image2 {
    width: 118px;
    height: 39px;
    background-image: url('{{ asset('images/image.png') }}');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .image3 {
    width: 132px;
    height: 39px;
    background-image: url('{{ asset('images/image2.png') }}');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  /* Mobile Responsiveness */
  @media (max-width: 768px) {
    .iPhone15, .iPhone152 {
      display: none;
    }
  }
</style>