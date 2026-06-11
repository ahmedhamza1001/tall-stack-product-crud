<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCrud extends Component
{
    use WithPagination;

    // Form properties
    public $product_id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $sku;
    public $category;
    public $is_active = true;

    // UI state
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'sku' => 'required|unique:products,sku',
        'category' => 'nullable',
        'is_active' => 'boolean'
    ];

    public function render()
    {
        $products = Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->orWhere('category', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.product-crud', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetValidation();
    }

    public function openDeleteModal($id)
    {
        $this->product_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->product_id = null;
    }

    private function resetInputFields()
    {
        $this->product_id = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock = '';
        $this->sku = '';
        $this->category = '';
        $this->is_active = true;
    }

    public function store()
    {
        $this->validate();

        Product::updateOrCreate(['id' => $this->product_id], [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'category' => $this->category,
            'is_active' => $this->is_active
        ]);

        session()->flash('message', $this->product_id ? 'Product updated successfully!' : 'Product created successfully!');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->product_id = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->sku = $product->sku;
        $this->category = $product->category;
        $this->is_active = $product->is_active;

        // Update unique rule for SKU to ignore current product
        $this->rules['sku'] = 'required|unique:products,sku,' . $id;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->product_id) {
            Product::find($this->product_id)->delete();
            $this->closeDeleteModal();
            session()->flash('message', 'Product deleted successfully!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
