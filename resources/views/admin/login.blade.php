<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | {{ setting('general.site_name') }}</title>

    {{-- favicon --}}
    <link rel="icon" type="image/png" href="{{ getFaviconURL() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&ampdisplay=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Script -->
    <script type="text/javascript">
        (function() {
            try {
                const root = document.documentElement;
                const savedTheme = localStorage.getItem('theme') || 'light';
                root.setAttribute('data-theme', savedTheme);
            } catch (e) {
                console.warn('Early theme script error:', e);
            }
        })();
    </script>
</head>

<body class="bg-base-200">
    <x-admin.alert />

    <div class="flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-10">
        <div class="relative flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div
                class="bg-base-100 shadow-base-300/20 z-1 w-full space-y-6 rounded-xl p-6 shadow-md sm:min-w-md lg:p-8">
                <div class="flex items-center gap-3">
                    <img src="{{ getLogoURL() }}" class="h-8" alt="brand-logo" />
                </div>
                <div>
                    <h3 class="text-base-content mb-1.5 text-2xl font-semibold">Sign in to
                        {{ setting('general.site_name') }}</h3>
                </div>
                <div class="space-y-4">
                    <form method="POST" action="{{ route('admin.login.post') }}" class="mb-4 space-y-4">
                        @csrf

                        {{-- Email --}}
                        <x-form.input label="Email Address" name="email" type="email" required autofocus />

                        {{-- Password --}}
                        <x-form.password label="Password" name="password" required />

                        <div class="flex items-center justify-between gap-y-2">
                            <x-form.checkbox name="remember" id="rememberMe" label="Remember Me" />

                            @if (Route::has('admin.password.request'))
                                <a href="{{ route('admin.password.request') }}"
                                    class="link link-animated link-primary font-normal">Forgot Your Password?</a>
                            @endif
                        </div>

                        <button class="btn btn-lg btn-primary btn-gradient btn-block">Sign in</button>
                    </form>

                    @if (Route::has('admin.register'))
                        <p class="text-base-content/80 mb-4 text-center">
                            Don't have an account? <a class="link link-animated link-primary font-normal"
                                href="{{ route('admin.register') }}">Register</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
