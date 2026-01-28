<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">

        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.taxes.index'),
                    'text' => 'Taxes',
                ],
                [
                    'text' => $tax->id ? 'Edit' : 'Create',
                ],
            ];

            $title = $tax->id ? 'Edit ' . $tax->name : 'Create Tax';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.taxes.index')" />

        <form method="post" action="{{ $tax->id ? route('admin.taxes.update', $tax) : route('admin.taxes.store') }}">
            @csrf

            @isset($tax->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-form.input label="Name" name="name" :value="$tax->name" required autofocus />

                        <div class="space-y-1">
                            <label for="type" class="label-text">Type</label>
                            <select name="type" id="type" class="select @error('type') is-invalid @enderror">
                                @foreach (\App\Enums\TaxType::cases() as $method)
                                    <option value="{{ $method->value }}" @selected(old('type', $tax->type ?? 'default') == $method->value)>
                                        {{ $method->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="helper-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <x-form.input label="Rate" name="rate" :value="$tax->rate" required />
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.taxes.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
