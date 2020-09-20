<div>
    <div class="btn-group">
        <a href="{{ route(\App\Alias\Routes::EMPLOYEE_VIEW,[$code]) }}" type="button" class="btn btn-default"
           title="View">
            <i class="fas fa-book-open"></i>
        </a>
        <a href="{{ route(\App\Alias\Routes::EMPLOYEE_EDIT,[$code]) }}" type="button" class="btn btn-default"
           title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route(\App\Alias\Routes::EMPLOYEE_DEL,[$code]) }}" type="button"
           class="btn btn-default delete-row-item" title="Delete"
           data-row="{{ $code }}" data-message="The employee's company will not be deleted">
            <i class="fas fa-trash-alt"></i>
        </a>

        <form id="delete-row-item-form-{{ $code }}" action="{{ route(\App\Alias\Routes::EMPLOYEE_DEL,[$code]) }}"
              method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>