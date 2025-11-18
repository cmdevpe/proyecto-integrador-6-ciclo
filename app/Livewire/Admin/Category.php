<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\CategoryForm;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Category as categoryModel;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Categorías')]
class Category extends Component
{
    use WithPagination;

    public CategoryForm $form;

    public $search = '';
    public $showModal = false;
    public $editId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->form->resetForm();
        $this->dispatch('open-modal', name: 'category-form-modal');
    }

    public function edit(categoryModel $category): void
    {
        $this->form->setCategory($category);
        $this->dispatch('open-modal', name: 'category-form-modal');
    }

    public function save(): void
    {
        if ($this->form->category_id) {
            $category = $this->form->update();
            $this->dispatch('toast', type: 'success', message: "¡La categoría '{$category->name}' se actualizó exitosamente!");
        } else {
            $category = $this->form->store();
            $this->dispatch('toast', type: 'success', message: "¡La categoría '{$category->name}' se creó exitosamente!");
        }
        $this->dispatch('close-modal', name: 'category-form-modal');
        $this->form->resetForm();
    }

    public function delete(categoryModel $category): void
    {
        $categoryName = $category->name;
        $category->delete();

        $this->dispatch('toast', type: 'success', message: "¡La categoría '{$categoryName}' se eliminó exitosamente!");
    }

    public function render()
    {
        $categories = categoryModel::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);
            
        return view('livewire.admin.category', compact('categories'));
    }
}
