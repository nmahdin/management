<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatCustomer extends Component
{
//    #[Validate('required' , 'max:255')]
    public $name;
//    #[Validate('min:8', 'max:12', "unique:customers")]
    public $number;
//    #[Validate('required' , 'max:255')]
    public $city;
//    #[Validate('date')]
    public $birthday;
//    #[Validate('required' , 'max:255')]
    public $address;
//    #[Validate('required' , 'array')]
    public $com_ways = [];
//    #[Validate('required' , 'max:250')]
    public $notes;

//    public function rules()
//    {
//        return
//        [
//            'number' => ['required', Rule::unique('customers')],
//        ];
//    }

    public function save()
    {
//        dd($this->com_ways);
        $validated = $this->validate([
            'name' => ['required', 'max:250'],
            'number' => ['min:8', 'max:12', Rule::unique('customers')],
            'city' => ['required', 'min:1', 'max:255'],
            'address' => ['max:250'],
            'com_ways' => ['required', 'array'],
            'birthday' => [],
        ]);

//        $this->validate();

//        dd($data);
        $customer = Customer::create([
            'name' => $this->name,
            'number' => $this->number,
            'city' => $this->city,
            'address' => $this->address,
            'com_ways' => json_encode($this->com_ways),
            'birthday' => $this->birthday,
        ]);

        session()->flash('created', $customer->name);
        $this->reset(['name', 'number', 'city', 'address', 'com_ways', 'notes']);
//        return $this->;
    }
    public function render()
    {
        return view('livewire.creat-customer');
    }
}
