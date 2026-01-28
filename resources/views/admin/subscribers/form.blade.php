<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">

        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.subscribers.index'),
                    'text' => 'Subscribers',
                ],
                [
                    'text' => $subscriber->id ? 'Edit' : 'Create',
                ],
            ];

            $title = $subscriber->id ? 'Edit ' . $subscriber->name : 'Create Subscriber';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.subscribers.index')" />

        <form method="post"
            action="{{ $subscriber->id ? route('admin.subscribers.update', $subscriber) : route('admin.subscribers.store') }}">
            @csrf

            @isset($subscriber->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-form.input label="Name" name="name" :value="$subscriber->name" autofocus />
                        <x-form.input label="Email" name="email" :value="$subscriber->email" required />
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.subscribers.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
