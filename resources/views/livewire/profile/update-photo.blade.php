<div x-data="{ photoPreview: null }" @photo-cancel.window="photoPreview = null">
    <x-card variant="profile" class="mb-4">
        <input type="file" class="hidden" wire:model.live="photo" x-ref="photoInput"
            @change="
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        photoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.photoInput.files[0]);
               " />

        <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
            <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0 object-cover shrink-0"
                src="{{ $user->profile_photo_url }}"
                :src="photoPreview ?? '{{ $photo ? $photo->temporaryUrl() : $user->profile_photo_url }}'"
                alt="{{ $user->name }}">

            <div>
                <x-heading as="h3" variant="subtitle" class="mb-1">
                    {{ __('Profile photo') }}
                </x-heading>

                <x-paragraph class="text-sm mb-4">
                    JPG, PNG o GIF · Máx. 1MB
                </x-paragraph>

                @if ($photo)
                    <div class="flex items-center space-x-2">
                        <x-button size="sm" wire:click="updatePhoto" wireTarget="updatePhoto">
                            <x-slot:loading>
                                {{ __('Saving...') }}
                            </x-slot:loading>
                            <i class="fa-solid fa-floppy-disk mr-2"></i>
                            {{ __('Save') }}
                        </x-button>

                        <x-button color="light" size="sm" wire:click="cancelPhoto">
                            {{ __('Cancel') }}
                        </x-button>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <x-button size="sm" @click="$refs.photoInput.click()">
                            <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i>
                            {{ __('Upload photo') }}
                        </x-button>

                        @if ($user->profile_photo_path)
                            <x-button color="light" size="sm" wire:click="deletePhoto"
                                wire:confirm="{{ __('Are you sure you want to delete your profile photo?') }}">
                                {{ __('Delete') }}
                            </x-button>
                        @endif
                    </div>
                @endif

                @error('photo')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-card>
</div>
