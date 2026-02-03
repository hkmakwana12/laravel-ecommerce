@php
    $navigation = [
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard'),
            'active' => ($active = request()->routeIs('admin.dashboard')),
            'icon' => 'icon-[tabler--dashboard]',
        ],
        // Shop group (title only)
        [
            'group' => 'Shop',
        ],
        [
            'name' => 'Products',
            'route' => route('admin.products.index'),
            'active' => ($active = request()->routeIs('admin.products.*')),
            'icon' => 'icon-[tabler--shopping-cart]',
        ],
        [
            'name' => 'Categories',
            'route' => route('admin.categories.index'),
            'active' => ($active = request()->routeIs('admin.categories.*')),
            'icon' => 'icon-[tabler--category]',
        ],
        [
            'name' => 'Brands',
            'route' => route('admin.brands.index'),
            'active' => ($active = request()->routeIs('admin.brands.*')),
            'icon' => 'icon-[tabler--brand-tabler]',
        ],
        [
            'name' => 'Orders',
            'route' => route('admin.orders.index'),
            'active' => ($active = request()->routeIs('admin.orders.*')),
            'icon' => 'icon-[tabler--shopping-bag]',
        ],
        [
            'name' => 'Coupons',
            'route' => route('admin.coupons.index'),
            'active' => ($active = request()->routeIs('admin.coupons.*')),
            'icon' => 'icon-[tabler--discount]',
        ],
        [
            'name' => 'Banners',
            'route' => route('admin.banners.index'),
            'active' => ($active = request()->routeIs('admin.banners.*')),
            'icon' => 'icon-[tabler--photo]',
        ],
        [
            'name' => 'Taxes',
            'route' => route('admin.taxes.index'),
            'active' => ($active = request()->routeIs('admin.taxes.*')),
            'icon' => 'icon-[tabler--receipt-tax]',
        ],
        [
            'name' => 'Contact Queries',
            'route' => route('admin.contactQueries.index'),
            'active' => ($active = request()->routeIs('admin.contactQueries.*')),
            'icon' => 'icon-[tabler--message]',
        ],
        [
            'name' => 'Subscribers',
            'route' => route('admin.subscribers.index'),
            'active' => ($active = request()->routeIs('admin.subscribers.*')),
            'icon' => 'icon-[tabler--mail]',
        ],

        // Management group (title only)
        [
            'group' => 'Management',
        ],
        [
            'name' => 'Attributes',
            'route' => route('admin.attributes.index'),
            'active' => ($active = request()->routeIs('admin.attributes.*')),
            'icon' => 'icon-[tabler--menu-4]',
        ],
        [
            'name' => 'Attribute Options',
            'route' => route('admin.attribute-options.index'),
            'active' => ($active = request()->routeIs('admin.attribute-options.*')),
            'icon' => 'icon-[tabler--menu-deep]',
        ],
        [
            'name' => 'Users',
            'route' => route('admin.users.index'),
            'active' => ($active = request()->routeIs('admin.users.*')),
            'icon' => 'icon-[tabler--users]',
        ],
        // Blog group (title only)
        [
            'group' => 'Blog',
        ],
        [
            'name' => 'Posts',
            'route' => route('admin.blogs.posts.index'),
            'active' => ($active = request()->routeIs('admin.blogs.posts.*')),
            'icon' => 'icon-[tabler--news]',
        ],
        [
            'name' => 'Categories',
            'route' => route('admin.blogs.categories.index'),
            'active' => ($active = request()->routeIs('admin.blogs.categories.*')),
            'icon' => 'icon-[tabler--folders]',
        ],
        // Settings group (title only)
        [
            'group' => 'Settings',
        ],
        [
            'name' => 'General Settings',
            'route' => route('admin.settings.general'),
            'active' => ($active = request()->routeIs('admin.settings.general')),
            'icon' => 'icon-[tabler--settings]',
        ],
        [
            'name' => 'Social Media Links',
            'route' => route('admin.settings.socialMedia'),
            'active' => ($active = request()->routeIs('admin.settings.socialMedia')),
            'icon' => 'icon-[tabler--brand-facebook]',
        ],
        [
            'name' => 'Company Settings',
            'route' => route('admin.settings.company'),
            'active' => ($active = request()->routeIs('admin.settings.company')),
            'icon' => 'icon-[tabler--building]',
        ],
        [
            'name' => 'Prefix Settings',
            'route' => route('admin.settings.prefix'),
            'active' => ($active = request()->routeIs('admin.settings.prefix')),
            'icon' => 'icon-[tabler--adjustments]',
        ],
        [
            'name' => 'Payment Gateway',
            'route' => route('admin.settings.paymentGateway'),
            'active' => ($active = request()->routeIs('admin.settings.paymentGateway')),
            'icon' => 'icon-[tabler--credit-card]',
        ],
    ];
@endphp

<aside id="with-navbar-sidebar"
    class="overlay [--auto-close:lg] lg:shadow-none overlay-open:translate-x-0 drawer drawer-start hidden h-full max-w-75 lg:z-0 lg:block lg:translate-x-0 lg:pt-16"
    role="dialog" tabindex="-1">
    <div class="drawer-head flex lg:hidden px-2 py-3">
        <button type="button" class="btn btn-text max-lg:btn-square lg:hidden me-2" aria-haspopup="dialog"
            aria-expanded="false" aria-controls="with-navbar-sidebar" data-overlay="#with-navbar-sidebar">
            <span class="icon-[tabler--menu-2] size-5"></span>
        </button>
        <div class="flex flex-1 items-center">
            <a class="link text-base-content link-neutral text-xl font-semibold no-underline"
                href="{{ route('admin.dashboard') }}">
                <div class="flex items-center gap-3">
                    <img src="{{ getLogoURL() }}" class="h-8" alt="brand-logo" />
                    <h2 class="text-base-content text-xl font-bold whitespace-nowrap sr-only">{{ config('app.name') }}
                    </h2>
                </div>
            </a>
        </div>
    </div>
    <div class="drawer-body h-full px-2 pt-4 lg:border-e border-base-content/25">
        <ul class="menu space-y-0.5 p-0">
            @foreach ($navigation as $item)
                @if (isset($item['group']))
                    <div class="divider text-base-content/50 py-3 after:border-0">
                        {{ $item['group'] }}</div>
                @else
                    <li>
                        <a href="{{ $item['route'] }}" class="{{ $item['active'] ? 'menu-active' : '' }}">
                            <span class="{{ $item['icon'] }} size-5"></span>
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
