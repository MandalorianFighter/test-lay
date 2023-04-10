@props(['employee'])

<form action="{{ route('user.employees.delete', $employee) }}" method="post" style="display:inline-block;">
@csrf
@method('delete')
<button type="submit" class="btn btn-sm btn-danger float-sm-right" onclick="return confirm('Are you sure, you want to delete this Employee?')">Delete</button>
</form>