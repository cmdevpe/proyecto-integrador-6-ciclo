<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\Admin\BrandForm;
use App\Models\Brand as BrandModel;


#[Layout('layouts.app')]
#[Title('Marcas')]
class Brand extends Component
{
    use WithPagination;
    public BrandForm $form;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->form->resetForm();
        $this->dispatch('open-modal', name: 'brand-form-modal');
    }

    public function edit(BrandModel $brand): void
    {
        $this->form->setBrand($brand);
        $this->dispatch('open-modal', name: 'brand-form-modal');
    }

    public function save(): void
    {
        if ($this->form->brand_id) {
            $brand = $this->form->update();
            $this->dispatch('toast', type: 'success', message: "¡La marca '{$brand->name}' se actualizó exitosamente!");
        } else {
            $brand = $this->form->store();
            $this->dispatch('toast', type: 'success', message: "¡La marca '{$brand->name}' se creó exitosamente!");
        }
        $this->dispatch('close-modal', name: 'brand-form-modal');
        $this->form->resetForm();
    }

    public function delete(BrandModel $brand): void
    {
        $name = $brand->name;
        $brand->delete();
        $this->dispatch('toast', type: 'success', message: "¡La marca '{$name}' se eliminó exitosamente!");
    }

    public function render()
    {
        $brands = BrandModel::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.admin.brand', compact('brands'));
    }
}
