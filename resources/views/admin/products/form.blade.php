<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.products.index'),
                    'text' => 'Products',
                ],
                [
                    'text' => $product->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $product->id ? 'Edit ' . $product->name : 'Create Product';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.products.index')" />

        @include('admin.products._stepper')

        <form method="post"
            action="{{ $product->id ? route('admin.products.update', $product) : route('admin.products.store') }}"
            class="space-y-6">
            @csrf

            @isset($product->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body" x-data="{
                    title: '{{ addslashes(old('name', $product->name)) }}',
                    slug: '{{ old('slug', $product->slug) }}'
                }">
                    <x-form.input label="Name" name="name" :value="$product->name" x-model="title"
                        @input="slug = slugify(title)" autofocus required />

                    <p class="text-sm text-gray-600">
                        <strong>Slug : </strong>
                        <span x-text="slug"></span>
                    </p>
                    <input type="hidden" name="slug" :value="slug" />

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="brand_id" class="label-text">Brand</label>
                            <select id="brand_id" name="brand_id" @class(['select', 'is-invalid' => $errors->has('brand_id')])
                                data-select='{
                                            "placeholder": "Select",
                                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                            "toggleClasses": "advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                                            "hasSearch": true,
                                            "dropdownClasses": "advance-select-menu max-h-52 pt-0 overflow-y-auto",
                                            "optionClasses": "advance-select-option selected:select-active",
                                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                            "extraMarkup": "<span class=\"icon-[tabler--chevron-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                            }'>
                                <option value="">{{ __('Select Brand') }}</option>
                                @foreach ($brands as $key => $brand)
                                    <option value="{{ $key }}" @selected(old('brand_id', $product->brand_id) == $key)>
                                        {{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <span class="helper-text">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="space-y-1">
                            <label for="category_id" class="label-text">Category</label>
                            <select id="category_id" name="category_id" @class(['select', 'is-invalid' => $errors->has('category_id')])
                                data-select='{
                                            "placeholder": "Select",
                                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                            "toggleClasses": "advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                                            "hasSearch": true,
                                            "dropdownClasses": "advance-select-menu max-h-52 pt-0 overflow-y-auto",
                                            "optionClasses": "advance-select-option selected:select-active",
                                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                            "extraMarkup": "<span class=\"icon-[tabler--chevron-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                            }'>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $key }}" @selected(old('category_id', $product->category_id) == $key)>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="helper-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-1">
                            <input type="hidden" name="is_featured" value="0" />
                            <input type="checkbox" class="switch switch-primary" id="is_featured" name="is_featured"
                                value="1" @checked(old('is_featured', $product->is_featured)) />
                            <label class="label-text text-base" for="is_featured"> Featured Product </label>
                        </div>
                    </div>
                </div>

            </div>

            <div>
                <h3 class="block text-base/tight font-medium text-gray-700 mb-4">Short Description</h3>
                <x-forms.rich-text-editor name="short_description">{!! old('short_description', $product->short_description) !!}</x-forms.rich-text-editor>
            </div>

            <div>
                <h3 class="block text-base/tight font-medium text-gray-700 mb-4">Long Description</h3>
                <x-forms.rich-text-editor name="long_description">{!! old('long_description', $product->long_description) !!}</x-forms.rich-text-editor>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function slugify(str) {
                return str
                    .trim()
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        </script>
    @endpush
</x-layouts.admin>
