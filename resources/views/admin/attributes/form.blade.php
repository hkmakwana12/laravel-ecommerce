<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">

        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.attributes.index'),
                    'text' => 'Attributes',
                ],
                [
                    'text' => $attribute->id ? 'Edit' : 'Create',
                ],
            ];

            $title = $attribute->id ? 'Edit ' . $attribute->name : 'Create Attribute';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.attributes.index')" />

        <form method="post"
            action="{{ $attribute->id ? route('admin.attributes.update', $attribute) : route('admin.attributes.store') }}">
            @csrf

            @isset($attribute->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-form.input label="Name" name="name" :value="$attribute->name" autofocus />
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
