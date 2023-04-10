<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $deleteId;
    public $paginate = 10;
    public $search;
    public $sortField;
    public $sortAsc = true;
    protected $queryString = ['search', 'sortAsc', 'sortField'];

    public $selected = [];
    public $selectAll = false;



    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function confirmDelete()
    {
        User::find($this->deleteId)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('User Is Deleted!')]);
    }
    
    public function deleteUsers() 
    {
        if(!empty($this->selected)) {
            User::destroy($this->selected);
            $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => __('Selected Users Are Deleted!')]);
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'warning',  'message' => __('Please, Select At Least One User!')]);
        }
    }

    public function updatedSelectAll($value) 
    {
        if($value) {
            $this->selected = User::where('id','!=',1)->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }
  
    public function sortBy($field)
    {
        if($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::where('email', 'like', '%'.trim($this->search).'%')
            ->when($this->sortField, function($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })->paginate($this->paginate),
        ]);
    }
}

