<div class="mt-14">
    <x-breadcrumb :items="[
        [
            'label' => __('Dashboard'),
            'url' => route('dashboard'),
        ],
        [
            'label' => __('Users'),
            'active' => true,
        ],
    ]" :show-title="true" />

    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-4">

    </div>
</div>
