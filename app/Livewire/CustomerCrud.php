<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerCrud extends Component
{
    use WithPagination;

    // Form properties
    public $customer_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $country;
    public $birth_date;
    public $company;
    public $status = 'active';
    public $notes;

    // UI state
    public $isOpen = false;
    public $isDeleteModalOpen = false;
    public $search = '';

    protected $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'required|email|unique:customers,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'zip_code' => 'nullable|string|max:20',
        'country' => 'nullable|string|max:100',
        'birth_date' => 'nullable|date',
        'company' => 'nullable|string|max:200',
        'status' => 'required|in:active,inactive,blocked',
        'notes' => 'nullable|string',
    ];

    public function render()
    {
        $customers = Customer::query()->search($this->search)->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.customer-crud', [
            'customers' => $customers,
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
        $this->customer_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->customer_id = null;
    }

    private function resetInputFields()
    {
        $this->customer_id = null;
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->city = '';
        $this->state = '';
        $this->zip_code = '';
        $this->country = '';
        $this->birth_date = '';
        $this->company = '';
        $this->status = 'active';
        $this->notes = '';
    }

    public function store()
    {
        $this->validate();

        Customer::updateOrCreate(
            ['id' => $this->customer_id],
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
                'country' => $this->country,
                'birth_date' => $this->birth_date,
                'company' => $this->company,
                'status' => $this->status,
                'notes' => $this->notes,
            ],
        );

        session()->flash('message', $this->customer_id ? 'Customer updated successfully!' : 'Customer created successfully!');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        $this->customer_id = $id;
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->city = $customer->city;
        $this->state = $customer->state;
        $this->zip_code = $customer->zip_code;
        $this->country = $customer->country;
        $this->birth_date = $customer->birth_date?->format('Y-m-d');
        $this->company = $customer->company;
        $this->status = $customer->status;
        $this->notes = $customer->notes;

        // Update unique rule for email to ignore current customer
        $this->rules['email'] = 'required|email|unique:customers,email,' . $id;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            $customer->delete();
            $this->closeDeleteModal();
            session()->flash('message', 'Customer deleted successfully!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
