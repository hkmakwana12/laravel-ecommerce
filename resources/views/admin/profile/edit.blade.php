<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Profile',
                ],
                [
                    'text' => 'Edit',
                ],
            ];
            $title = 'Edit ' . $user->name;
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title />


        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">

            <form method="post" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('put')

                <div class="card">
                    <div class="card-header">
                        <h5 class="text-base-content text-lg font-medium">Basic Info</h5>
                    </div>
                    <div class="card-body space-y-2">
                        <x-form.input label="Name" name="name" :value="$user->name" required autofocus />
                        <x-form.input label="Email" name="email" :value="$user->email" required />
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>

            <!--------Password --------->
            <form method="post" action="{{ route('admin.profile.password') }}">
                @csrf
                @method('put')

                <div class="card">
                    <div class="card-header">
                        <h5 class="text-base-content text-lg font-medium">Change Password</h5>
                    </div>
                    <div class="card-body space-y-2">
                        <x-form.password label="Current Password" name="current_password" type="password" required />
                        <x-form.password label="New Password" name="password" type="password" required />
                        <x-form.password label="Confirm Password" name="password_confirmation" type="password"
                            required />
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</x-layouts.admin>
