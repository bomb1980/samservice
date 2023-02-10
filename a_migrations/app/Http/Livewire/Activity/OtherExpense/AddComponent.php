<?php

namespace App\Http\Livewire\Activity\OtherExpense;

use Livewire\Component;

class AddComponent extends Component
{
    public $types, $items = [], $name, $date, $amount, $remark;

    public function render()
    {
        return view('livewire.activity.other-expense.add-component');
    }

    public function addItem()
    {
        $this->items[] = [
            'name' => $this->name,
            'date' => $this->date,
            'amount' => $this->amount,
        ];

        $this->reset(['name', 'date', 'amount', 'remark']);
        $this->emit('add_item');
    }

    public function submit()
    {
        $this->emit('save_success');
    }

    public function redirectTo()
    {
        return redirect()->route('activity.other_expense.index');
    }
}
