 @extends('layouts.uploadImage')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
{{-- @dd($apartmentId) --}}
                <form method="post" action="{{ route('upr.images.store') }}" enctype="multipart/form-data"
                            class="dropzone" id="dropzone">
                            <input type="hidden" name="apartmentId" value="{{$apartmentId}}">
                @csrf
                </form>
            </div>
        </div>
    </div>

@endsection
