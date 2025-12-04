<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\Admin\ColorForm;
use App\Models\Color as colorModel;

#[Layout('layouts.app')]
#[Title('Colores')]
class Color extends Component
{
    use WithPagination;
    public ColorForm $form;
    public $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->form->resetForm();
        $this->dispatch('open-modal', name: 'color-form-modal');
    }

    public function edit(ColorModel $color): void
    {
                    $this->form->setColor($color);
                    $this->dispatch('open-modal', name: 'color-form-modal');
    }

    public function save(): void
    {
        if ($this->form->color_id) {
            $color = $this->form->update();
            $this->dispatch('toast', type: 'success', message: "¡El color '{$color->name}' se actualizó exitosamente!");
        } else {
            $color = $this->form->store();
            $this->dispatch('toast', type: 'success', message: "¡El color '{$color->name}' se creó exitosamente!");
        }

        $this->dispatch('close-modal', name: 'color-form-modal');
        $this->form->resetForm();
    }

    public function delete(ColorModel $color): void
    {
        $name = $color->name;
        $color->delete();
        $this->dispatch('toast', type: 'success', message: "¡El color '{$name}' se eliminó exitosamente!");
    }

    public function render()
    {
        $colors = ColorModel::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.admin.color', compact('colors'));
    }
}
