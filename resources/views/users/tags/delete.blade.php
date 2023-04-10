@props(['tag'])

<form action="{{ route('user.tags.delete', $tag) }}" method="post" style="display:inline-block;">
@csrf
@method('delete')
<button type="submit" class="btn btn-sm btn-danger float-sm-right" onclick="return confirm('Are you sure, you want to delete this Tag?')">Delete</button>
</form>