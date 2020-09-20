@csrf
<div class="card-body">
    <div class="form-group">
        <label for="first_name">First name</label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
               placeholder="Enter the employee first name"
               value="{{ old('first_name',$employee->first_name)  }}">
        @error('first_name')
        <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="last_name">Last name</label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
               placeholder="Enter the employee last name"
               value="{{ old('last_name',$employee->last_name)  }}">
        @error('last_name')
        <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
               placeholder="Enter the employee email address"
               value="{{ old('email',$employee->email)  }}">
        @error('email')
        <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone number</label>
        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
               placeholder="Enter the employee phone number"
               value="{{ old('phone',$employee->phone)  }}">
        @error('phone')
        <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-group">
        <label for="company">Company</label>
        <select class="form-control select2bs4 @error('company') is-invalid @enderror" id="company" name="company">
                <option>Select the employee company</option>
            @foreach($companiesList as $slug => $name )
                <option {{ $selectedCompany === $slug ?  'selected="selected"' : ''}} value="{{$slug}}">{{ $name  }}</option>
            @endforeach
        </select>
        @error('company')
        <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary float-right w-25">Save</button>
</div>