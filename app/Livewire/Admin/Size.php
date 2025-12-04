<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\Admin\SizeForm;
use App\Models\Size as SizeModel;

#[Layout('layouts.app')]
#[Title('Tallas')]
class Size extends Component
{
    use WithPagination;
    public SizeForm $form;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->form->resetForm();
        $this->dispatch('open-modal', name: 'size-form-modal');
    }

    public function edit(SizeModel $size): void
    {
        $this->form->setSize($size);
        $this->dispatch('open-modal', name: 'size-form-modal');
    }

    public function save(): void
    {
        if ($this->form->size_id) {
            $size = $this->form->update();
            $this->dispatch('toast', type: 'success', message: "¡La talla '{$size->name}' se actualizó exitosamente!");
        } else {
            $size = $this->form->store();
            $this->dispatch('toast', type: 'success', message: "¡La talla '{$size->name}' se creó exitosamente!");
        }
        $this->dispatch('close-modal', name: 'size-form-modal');
        $this->form->resetForm();
    }

    public function delete(SizeModel $size): void
    {
        $sizeName = $size->name;
        $size->delete();

        $this->dispatch('toast', type: 'success', message: "¡La talla '{$sizeName}' se eliminó exitosamente!");
    }

    public function render()
    {
        $sizes = SizeModel::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.admin.size', compact('sizes'));
    }
}
