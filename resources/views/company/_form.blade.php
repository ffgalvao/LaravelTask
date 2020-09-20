@csrf
<div class="card-body">
    <div class="form-group row">
        <div class="col-auto">
            <img src="{{ $company->logo_full_path }}"
                 style="max-width: 150px;" class="img-thumbnail img-fluid"
                 alt=" {{ $company->name }}">
        </div>
        <div class="col">
            <label for="logo">{{ $company->logo ? 'Replace' : 'Find' }} your
                logo</label>
            <div class="custom-file @error('logo') is-invalid @enderror">
                <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" name="logo" value="{{ old('logo') }}">
                <label class="custom-file-label" for="logo">Choose a image.(Minimum 100x100px)</label>
            </div>
            @error('logo')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
               placeholder="Enter the company name"
               value="{{ old('name',$company->name)  }}">
        @error('name')
        <span  class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
               placeholder="Enter the company email"
               value="{{ old('email',$company->email)  }}">
        @error('email')
        <span  class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="website">Website</label>
        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website"
               placeholder="Enter the company website"
               value="{{ old('website',$company->website)  }}">
        @error('website')
        <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary float-right w-25">Save</button>
</div>