<div>
    <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-gray-900/50 dark:bg-gray-900/80 sm:hidden" :aria-hidden="(!sidebarOpen).toString()">
    </div>

    <aside id="logo-sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           :aria-hidden="(!sidebarOpen && window.innerWidth < 640).toString()"
           class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 -translate-x-full sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
           aria-label="Sidebar">

        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                @foreach ($menuItems as $item)
                    @if ($item->authorize())
                        {!! $item->render() !!}
                    @endif
                @endforeach
            </ul>
        </div>
    </aside>
</div>
