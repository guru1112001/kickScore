<section class="py-20 my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <!-- Text Section -->
    <div class="max-w-2xl">
      <h1 class="font-['Roboto'] font-bold text-gray-200 text-4xl leading-tight">
        Your Ultimate Football <br>Companion – All the Scores,<br> Stats, and Updates in One Place
      </h1>

      <p class="text-gray-400 mt-6 text-base">
        Stay connected to the beautiful game like never before. Our app is designed for true football fans who want
        quick access to the latest scores, personalized match alerts, and detailed stats—right at their fingertips.
      </p>

      <!-- Download Apps Section -->
      <div class="imageLink mt-6">
        <div class="downloadApps">Download Apps:</div>
        <div class="image flex gap-4 mt-2">
          <div class="image2"></div>
          <div class="image3"></div>
        </div>
      </div>
    </div>

    <!-- Image Section -->
    <div class="iPhone15 mt-8">
      {{-- <img src="{{ asset('images/image_1.png')}}" alt="Football Action"
        class="w-full h-full object-cover clip-image"> --}}
    </div>
    <div class="iPhone152 mt-8">
      {{-- <img src="{{ asset('images/image_1.png')}}" alt="Football Action"
        class="w-full h-full object-cover clip-image"> --}}
    </div>
  </div>
</section>

<!-- New Section with Image on Left and Text on Right -->
<section class="py-20 my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <!-- Image on Left -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/flower.png') }}" alt="Game/Event Listing" class="w-[28rem] h-auto object-cover">
    </div>

    <!-- Text on Right -->
    <div class="w-full md:w-1/2 md:pl-8 mt-8 md:mt-0">
      <h2 class="font-['Roboto'] font-bold text-gray-200 text-3xl leading-tight">
        Games/Event Listing
      </h2>
      <p class=" mt-4 text-base font-bold text-white">
        Track all the matches in one place. Get live scores, upcoming fixtures, and results for every major football
        league, right at your fingertips.
      </p>
    </div>
  </div>
</section>

<!-- New Section with Image on Right and Text on Left -->
<section class="py-20 my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <!-- Text on Left -->
    <div class="w-full md:w-1/2 md:pr-8 mb-8 md:mb-0">
      <h2 class="font-['Roboto'] font-bold text-gray-200 text-3xl leading-tight">
        Goal Of The Day
      </h2>
      <p class="text-white mt-4 text-base font-bold">
        Get detailed insights into the most impressive goals, including key stats and player info, to relive the
        excitement through descriptions and analysis.
      </p>
    </div>

    <!-- Image on Right -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/social.png') }}" alt="Live Updates" class="w-full h-auto object-cover">
    </div>
  </div>
</section>

<section class="py-20 my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <!-- Image on Left -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/flower.png') }}" alt="Game/Event Listing" class="w-[28rem] h-auto object-cover">
    </div>

    <!-- Text on Right -->
    <div class="w-full md:w-1/2 md:pl-8 mt-8 md:mt-0">
      <h2 class="font-['Roboto'] font-bold text-gray-200 text-3xl leading-tight">
        Match Trivia
      </h2>
      <p class=" mt-4 text-base font-bold text-white">
        Challenge yourself with fun football trivia. Learn cool facts about players, teams, and matches while testing your football knowledge.
      </p>
    </div>
  </div>
</section>

<section class="py-20 my-14">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
    <!-- Text on Left -->
    <div class="w-full md:w-1/2 md:pr-8 mb-8 md:mb-0">
      <h2 class="font-['Roboto'] font-bold text-gray-200 text-3xl leading-tight">
        Match Discussions
      </h2>
      <p class="text-white mt-4 text-base font-bold">
        Share your thoughts and opinions with fans worldwide. Join the debate on matches, tactics, and the latest football action in real-time discussions.
      </p>
    </div>

    <!-- Image on Right -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/social.png') }}" alt="Live Updates" class="w-full h-auto object-cover">
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
    top: 929px;
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
    top: 907px;
    width: 411px;
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
</style>