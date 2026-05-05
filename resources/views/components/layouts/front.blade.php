<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? setting('general.site_name') }}</title>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&ampdisplay=swap"
        rel="stylesheet" />

    {{-- Meta Description --}}
    <meta name="description" content="{{ $description ?? setting('general.site_description') }}" />

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ request()->url() }}" />

    {{-- favicon --}}
    <link rel="icon" type="image/png" href="{{ getFaviconURL() }}" />

    {{-- Open Graph --}}

    <!-- css link here  -->
    @vite('resources/css/app.css')

    @stack('styles')

    @if (setting('general.analytics_code'))
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('general.analytics_code') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ setting('general.analytics_code') }}');
        </script>
    @endif
</head>

<body class="bg-base-100">
    <x-admin.alert />
    <div class="bg-base-100 flex-col">
        <x-front.header />

        <main class="flex-1">
            {{ $slot }}
            <x-front.footer />
        </main>

    </div>

    <!-- script file here -->
    @vite('resources/js/app.js')
    @stack('scripts')

    @if (setting('general.is_captcha'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: [],
                count: 0,
                sub_total: 0,
                total_tax_amount: 0,
                grand_total: 0,
                loading: false,

                setCart(data) {
                    this.items = data.items;
                    this.count = data.count;
                    this.sub_total = data.sub_total;
                    this.taxes = data.taxes;
                    this.total_tax_amount = data.total_tax_amount;
                    this.grand_total = data.grand_total;
                },

                init() {
                    this.fetchCart();
                },

                async fetchCart() {
                    try {
                        this.loading = true;
                        let res = await axios.get(`{{ route('account.cart.list') }}`);
                        this.setCart(res.data.cart);
                    } catch (e) {
                        console.error('Fetch cart failed', e);
                    } finally {
                        this.loading = false;
                    }
                },

                async addFromForm(form) {
                    if (this.loading) return;

                    try {
                        this.loading = true;

                        let formData = new FormData(form);

                        let res = await axios.post(form.action, formData);

                        this.fetchCart();

                    } catch (e) {
                        console.error('Add to cart failed', e);
                    } finally {
                        this.loading = false;
                    }
                },

                async remove(productId) {
                    try {
                        this.loading = true;

                        let res = await axios.get(
                            `{{ route('account.removeFromCart', ['product_id' => ':product_id']) }}`
                            .replace(':product_id', productId));

                        this.fetchCart();

                    } catch (e) {
                        console.error('Remove failed', e);
                    } finally {
                        this.loading = false;
                    }
                },
                async increment(productId, variantId) {
                    try {
                        this.loading = true;

                        let res = await axios.post(
                            `{{ route('products.addToCart') }}`, {
                                _token: '{{ csrf_token() }}',
                                product_id: productId,
                                variant_id: variantId,
                                quantity: 1
                            }
                        );

                        this.fetchCart();

                    } catch (e) {
                        console.error('Increment failed', e);
                    } finally {
                        this.loading = false;
                    }
                },
                async decrement(productId, variantId) {
                    try {
                        this.loading = true;

                        let res = await axios.post(
                            `{{ route('products.addToCart') }}`, {
                                _token: '{{ csrf_token() }}',
                                product_id: productId,
                                variant_id: variantId,
                                quantity: -1
                            }
                        );

                        this.fetchCart();

                    } catch (e) {
                        console.error('Decrement failed', e);
                    } finally {
                        this.loading = false;
                    }
                }
            });
        });

        function formatCurrency(value) {
            return value.toLocaleString('en-US', {
                style: 'currency',
                currency: '{{ app_country()->currency }}'
            });
        }
    </script>
</body>

</html>
