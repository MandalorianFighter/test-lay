<div class="card">
    <div class="card-header">
        <h6 class="card-title">{{ __('DataTable with Users') }}</h6>
        <div class="d-inline float-end">
         <button wire:click="deleteUsers" class="btn btn-sm btn-warning">{{ __('Delete Chosen') }}</button>
        </div>
    </div>
    
    <div class="mb-3">
    <div class="row d-flex justify-content-between align-items-center">
    <div class="col-md-4 ml-2 d-flex align-items-center">
        <div class="pe-3 ml-2 order-2">{{ __('Items/page') }}</div>
    <select wire:model="paginate" name="paginate" class="form-select rounded-0 col-md-2 order-1" id="paginate">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    </div>
    
    <div class="input-group mr-2 col-lg-2 float-right">
    <input wire:model="search" class="form-control" type="search" name="search" placeholder="Search">
    </div>
    </div>
    </div>
    <div class="table-wrapper">
    
    <table class="data-table table table-bordered table-striped">
        <thead>
        <tr>
            <th class="wd-15p">
            <div class="d-flex align-items-center justify-content-start">
            <input type="checkbox" wire:model="selectAll">
            <button class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 disabled border-0 text-black ml-2" aria-disabled="true">{{ __('Select All') }}</button>
            </div>
            </th>
            <th class="wd-15p">
                <div class="d-flex align-items-center justify-content-start">
                    <button wire:click="sortBy('id')" class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 border-0">{{ __('ID') }}</button>
                    <x-sort-icon field="id" :sortField="$sortField" :sortAsc="$sortAsc" />
                </div>
            </th>
            <th class="wd-15p">
                <div class="d-flex align-items-center justify-content-start">
                    <button wire:click="sortBy('name')" class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 border-0">{{ __('Name') }}</button>
                    <x-sort-icon field="name" :sortField="$sortField" :sortAsc="$sortAsc" />
                </div>
            </th>
            <th class="wd-15p">
                <div class="d-flex align-items-center justify-content-start">
                    <button wire:click="sortBy('email')" class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 border-0">{{ __('Email') }}</button>
                    <x-sort-icon field="email" :sortField="$sortField" :sortAsc="$sortAsc" />
                </div>
            </th>
            <th class="wd-15p">
                <div class="d-flex align-items-center justify-content-start">
                    <button wire:click="sortBy('created_at')" class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 border-0">{{ __('Register Time') }}</button>
                    <x-sort-icon field="created_at" :sortField="$sortField" :sortAsc="$sortAsc" />
                </div>
            </th>
            <th class="wd-15p">
            <div class="d-flex align-items-center justify-content-end">
                <button class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 disabled border-0 text-black" aria-disabled="true">{{ __('isAdmin') }}</button>
            </div>
            </th>
            <th class="wd-15p">
            <div class="d-flex align-items-center justify-content-end">
                <button class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 disabled border-0 text-black" aria-disabled="true">{{ __('Approved') }}</button>
            </div>
            </th>
            <th class="wd-15p">
            <div class="d-flex align-items-center justify-content-end">
                <button class="btn btn-sm text-nowrap text-uppercase font-weight-bold p-0 disabled border-0 text-black" aria-disabled="true">{{ __('Action') }}</button>
            </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $key => $user)
        <tr>
            <td>
            @if($user->id != 1)
            <input  wire:model="selected" value="{{ $user->id }}" type="checkbox">
            @endif
            </td>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->diffForHumans() }}</td>
            <td>
            </div>
            @if($user->id != 1)
            <div class="d-flex justify-content-end">
            @livewire('toggle-switch', ['model' => $user, 'field' => 'is_admin'], key($user->id.'_first'))
            </div>
            @endif
            </td>
            <td>
            <div class="d-flex justify-content-end">
            @livewire('toggle-switch', ['model' => $user, 'field' => 'approved'], key($user->id.'_second'))
            </div>
            </td>
            <td>
            <div class="d-flex align-items-center justify-content-end">
            @if($user->id != 1)
            <button wire:click="deleteId({{ $user->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">{{__('Delete')}}</button>
            @endif
            </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div><!-- table-wrapper -->
    <div class="pagination justify-content-end">
    {{ $users->links() }}
    </div>
           <!-- LARGE MODAL -->
    <div wire:ignore.self id="modalDelete" class="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title">{{ __('Delete User') }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              
              <div class="modal-body">
                <div class="mb-3">
                <h5>{{ __('Are you sure, you want to delete?') }}</h5>
                </div>
              </div><!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" wire:click="confirmDelete()" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Yes, Delete') }}</button>
              </div>
            </div>
          </div><!-- modal-dialog -->
        </div><!-- modal -->
</div><!-- card -->
