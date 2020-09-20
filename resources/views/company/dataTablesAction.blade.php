<div>
    <div class="btn-group">
        <a href="{{ route(\App\Alias\Routes::COMPANY_VIEW,[$slug]) }}" type="button" class="btn btn-default" title="View">
            <i class="fas fa-book-open"></i>
        </a>
        <a href="{{ route(\App\Alias\Routes::COMPANY_EDIT,[$slug]) }}" type="button" class="btn btn-default" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route(\App\Alias\Routes::COMPANY_DEL,[$slug]) }}" type="button" class="btn btn-default delete-row-item" title="Delete"
           data-row="{{ $slug }}" data-message="All the company employees will be deleted.">
            <i class="fas fa-trash-alt"></i>
        </a>
        <form id="delete-row-item-form-{{ $slug }}" action="{{ route(\App\Alias\Routes::COMPANY_DEL,[$slug]) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>