<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">

        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.attribute-options.index'),
                    'text' => 'Attribute Options',
                ],
                [
                    'text' => $attributeOption->id ? 'Edit' : 'Create',
                ],
            ];

            $title = $attributeOption->id ? 'Edit ' . $attributeOption->value : 'Create Attribute Option';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.attribute-options.index')" />

        <form method="post"
            action="{{ $attributeOption->id ? route('admin.attribute-options.update', $attributeOption) : route('admin.attribute-options.store') }}">
            @csrf

            @isset($attributeOption->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="attribute_id" class="label-text required">Attribute</label>
                            <select name="attribute_id" id="attribute_id"
                                class="select @error('attribute_id') is-invalid @enderror">
                                <option value="">Select Attribute</option>
                                @foreach ($attributes as $key => $attribute)
                                    <option value="{{ $key }}" @selected(old('attribute_id', $attributeOption->attribute_id) == $key)>
                                        {{ $attribute }}
                                    </option>
                                @endforeach
                            </select>
                            @error('attribute_id')
                                <span class="helper-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <x-form.input label="Value" name="value" :value="$attributeOption->value" required />
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.attribute-options.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
