<div class="mt-14">
    <x-breadcrumb :items="[
        [
            'label' => __('Dashboard'),
            'url' => route('dashboard'),
        ],
        [
            'label' => __('Users'),
            'url' => route('users'),
        ],
        [
            'label' => __('Profile'),
            'active' => true,
        ],
    ]" :show-title="true" />

    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-4">
        <div class="grid grid-cols-1 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
            <div class="col-span-full xl:col-auto">
                @livewire('profile.update-photo')
                @livewire('profile.active-session')
            </div>

            <div class="col-span-2">
                @livewire('profile.update-profile')
                @livewire('profile.update-password')
            </div>
        </div>
    </div>
</div>
