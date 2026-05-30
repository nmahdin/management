<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCustomer extends Component
{
    #[Validate('required|max:255')]
    public $name;

    #[Validate('min:8|max:12')]
    public $number;

    #[Validate('required|min:1|max:255')]
    public $city;

    #[Validate('nullable|date')]
    public $birthday;

    #[Validate('max:250')]
    public $address;

    #[Validate('required|array')]
    public $com_ways = [];

    #[Validate('nullable|max:250')]
    public $notes;

    #[Validate('required|in:male,female')]
    public $gender;

    public function save()
    {
        $validated = $this->validate([
            'name' => ['required', 'max:250'],
            'number' => ['min:8', 'max:12', Rule::unique('customers')],
            'city' => ['required', 'min:1', 'max:255'],
            'address' => ['max:250'],
            'com_ways' => ['required', 'array'],
            'birthday' => ['nullable'],
            'notes' => ['nullable'],
            'gender' => ['required', 'in:male,female'],
        ]);

        $customer = Customer::create([
            'name' => $this->name,
            'number' => $this->number,
            'city' => $this->city,
            'address' => $this->address,
            'com_ways' => json_encode($this->com_ways),
            'birthday' => $this->birthday,
            'notes' => $this->notes,
            'gender' => $this->gender,
        ]);

        session()->flash('created', $customer->name);
        $this->reset(['name', 'number', 'city', 'address', 'com_ways', 'notes', 'gender', 'birthday']);
    }

    public function render()
    {
        return view('livewire.create-customer');
    }
}
