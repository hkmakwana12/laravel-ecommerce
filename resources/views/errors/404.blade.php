<x-layouts.front>
    <!-- 404 Start -->
    <div class="container py-[150px]">
        <div class="text-center">
            <h2 class="font-display2 title-404 leading-tight font-bold text-gray-black">404</h2>
            <p class="font-display2 subtitle-404 leading-tight font-bold text-gray-black pb-5 capitalize">Oops! Page not
                found</p>
            <p class="font-display2 sub-subtitle-404 text-lg leading-tight font-normal text-gray-500 ">The page
                you are looking for doesn't exist or has been removed.</p>
            <a href="{{ route('home') }}"
                class="bg-primary-600 px-4 py-2.5 rounded-md text-white leading-tight inline-block items-center justify-center mt-6 transition-all duration-300 ease-in-out hover:bg-primary-500">Back
                to Home</a>
        </div>
    </div>
    <!-- 404 end -->
</x-layouts.front>
