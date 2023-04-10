@props(['department'])

<form action="{{ route('user.departments.delete', $department) }}" method="post" style="display:inline-block;">
@csrf
@method('delete')
<button type="submit" class="btn btn-sm btn-danger float-sm-right" onclick="return confirm('Are you sure, you want to delete this Department?')">Delete</button>
</form>