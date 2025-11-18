@props([
    'label' => __('Verification Code'),
    'name' => 'code',
    'call' => null,
])

<div>
    <label for="code-1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
    </label>

    <div x-data="otpInputs({ length: 6, onlyDigits: true })" x-init="init();
    $watch('digits', () => $wire.set('{{ $name }}', digits.join('')));" @if ($call)
        @otp-complete.window="
            $wire.set('{{ $name }}', $event.detail);
            $wire.call('{{ $call }}');
        "
        @endif
        @paste.window.prevent="handlePaste($event)"
        class="flex space-x-2 rtl:space-x-reverse"
        >
        <div>
            <label for="code-1" class="sr-only">First code</label>
            <input type="text" maxlength="1" data-focus-input-init data-focus-input-next="code-2" id="code-1"
                x-ref="code-1" x-model="digits[0]" @input="onInput(0, $event)" @keydown="onKeydown(0, $event)"
                class="block w-14 h-14 text-xl font-extrabold text-center text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                required />
        </div>
        <div>
            <label for="code-2" class="sr-only">Second code</label>
            <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-1"
                data-focus-input-next="code-3" id="code-2" x-ref="code-2" x-model="digits[1]"
                @input="onInput(1, $event)" @keydown="onKeydown(1, $event)"
                class="block w-14 h-14 text-xl font-extrabold text-center text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                required />
        </div>
        <div>
            <label for="code-3" class="sr-only">Third code</label>
            <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-2"
                data-focus-input-next="code-4" id="code-3" x-ref="code-3" x-model="digits[2]"
                @input="onInput(2, $event)" @keydown="onKeydown(2, $event)"
                class="block w-14 h-14 text-xl font-extrabold text-center text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                required />
        </div>
        <div>
            <label for="code-4" class="sr-only">Fourth code</label>
            <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-3"
                data-focus-input-next="code-5" id="code-4" x-ref="code-4" x-model="digits[3]"
                @input="onInput(3, $event)" @keydown="onKeydown(3, $event)"
                class="block w-14 h-14 text-xl font-extrabold text-center text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                required />
        </div>
        <div>
            <label for="code-5" class="sr-only">Fifth code</label>
            <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-4"
                data-focus-input-next="code-6" id="code-5" x-ref="code-5" x-model="digits[4]"
                @input="onInput(4, $event)" @keydown="onKeydown(4, $event)"
                class="block w-14 h-14 text-xl font-extrabold text-center text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                required />
        </div>
        <div>
            <label for="code-6" class="sr-only">Sixth code</label>
            <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-5" id="code-6"
                x-ref="code-6" x-model="digits[5]" @input="onInput(5, $event)" @keydown="onKeydown(5, $event)"
                class="block w-14 h-14 text-xl font-extrabold text-center text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-600 dark:focus:border-primary-600"
                required />
        </div>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
