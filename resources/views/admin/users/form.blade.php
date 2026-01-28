<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.users.index'),
                    'text' => 'Users',
                ],
                [
                    'text' => $user->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $user->id ? 'Edit ' . $user->name : 'Create User';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.users.index')" />

        <form method="post" action="{{ $user->id ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf

            @isset($user->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-form.input label="First Name" name="first_name" :value="$user->first_name" required autofocus />

                        <x-form.input label="Last Name" name="last_name" :value="$user->last_name" />
                        <x-form.input label="Email" name="email" :value="$user->email" required />
                        <x-form.input label="Phone" name="phone" :value="$user->phone" required />

                        <!---  password------->
                        <x-form.password type="password" label="Password" name="password" :value="''"
                            :required="!$user->id" />

                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
