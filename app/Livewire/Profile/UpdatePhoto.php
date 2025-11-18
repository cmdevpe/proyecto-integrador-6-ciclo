<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdatePhoto extends Component
{
    use WithFileUploads;

    public $photo;

    public $user;

    protected function rules(): array
    {
        return [
            'photo' => ['required', 'image', 'max:1024'],
        ];
    }

    protected function messages(): array
    {
        return [
            'photo.required' => 'Es necesario seleccionar una :attribute.',
            'photo.image' => 'El archivo debe ser una imagen (JPG, PNG, GIF, etc.).',
            'photo.max' => 'La :attribute no debe pesar más de 1MB.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'photo' => 'foto de perfil',
        ];
    }

    public function mount(): void
    {
        $this->user = auth()->user()->load('socialAccounts');
    }

    public function updatedPhoto(): void
    {
        $this->validateOnly('photo');
    }

    public function updatePhoto(): void
    {
        $this->validate();

        if ($this->user->profile_photo_path) {
            Storage::disk('public')->delete($this->user->profile_photo_path);
        }

        $path = $this->photo->store('profile-photos', 'public');

        $this->user->update([
            'profile_photo_path' => $path,
        ]);

        $this->user->refresh();
        $this->resetPhotoState();

       $this->dispatch('toast', type: 'success', message: __('Profile photo successfully updated.'));
       $this->dispatch('profile-photo-updated');
    }

    public function cancelPhoto(): void
    {
        $this->resetPhotoState();
    }

    public function deletePhoto(): void
    {
        if ($this->user->profile_photo_path) {
            Storage::disk('public')->delete($this->user->profile_photo_path);

            $this->user->update([
                'profile_photo_path' => null,
            ]);

            $this->user->refresh();
        }

        $this->dispatch('toast', type: 'success', message: __('Profile photo successfully deleted.'));
        $this->dispatch('profile-photo-updated');
    }

    private function resetPhotoState(): void
    {
        $this->reset('photo');
        $this->resetValidation('photo');
        $this->dispatch('photo-cancel');
    }

    public function render()
    {
        return view('livewire.profile.update-photo');
    }
}
