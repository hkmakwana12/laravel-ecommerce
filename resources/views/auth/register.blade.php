<x-layouts.front>
    @php
        $breadcrumbs = [
            'links' => [['url' => route('home'), 'text' => 'Home'], ['url' => '#', 'text' => 'Sign Up']],
            'title' => 'Sign Up',
        ];
    @endphp

    @include('components.common.breadcrumb', $breadcrumbs)

    <!-- Sign Up Form Start -->
    <div class="container py-20">

        <div class="w-1/2 bg-white shadow-lg rounded-xl mx-auto p-8">
            <h2 class="text-center text-gray-800 xl:text-4xl text-xl font-bold mb-10">Sign Up</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2 col-span-2 md:col-span-1">
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                            placeholder="First Name" class="form-control" />
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2 col-span-2 md:col-span-1">
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                            placeholder="Last Name" class="form-control" />
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        class="form-control" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        placeholder="Phone Number" class="form-control" />
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm Password" class="form-control" />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full gap-x-2">
                    Sign Up
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7.5L20.5 12M20.5 12L16 16.5M20.5 12H4.5" stroke="white" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </form>
            <p class="mt-4 text-sm/6 text-gray-800 opacity-70">By Clicking I am agree with Terms & Conditions</p>

            <p class="font-normal text-base leading-tight text-gray-800 mt-6 text-center">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary-600 font-medium text-base leading-tight">
                    Sign in instead</a>
            </p>
        </div>
    </div>
    <!-- Sign Up Form End -->

</x-layouts.front>
