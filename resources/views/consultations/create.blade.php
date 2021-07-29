@extends('layouts.app')

@section('content')
@include('includes.errors')
<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
    <div class="card w-50">
        <div class="card-header">
            <h3 class="text-center">اسأل طبيب</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('consultations.store') }}" method="post">
                @csrf
                <input type="text" class="form-control box-shadow-none" name="title" placeholder="عنوان السؤال"
                    autocomplete="off" required>
                <textarea name="content" class="form-control box-shadow-none mt-3" cols="30" rows="10"
                    placeholder="محتوى السؤال" required></textarea>
                <div
                    class="form-group d-flex align-items-center flex-wrap justify-content-center justify-content-sm-start mt-3">
                    <label for="" class="flex-shrink-0 me-2 mb-2">اختيار صنف</label>
                    <select name="consultation_category_id" id="" class="form-select form-select-sm w-auto mb-2">
                        @foreach($consultation_categories as $consultation_category)
                            <option value="{{ $consultation_category->id }}">
                                {{ $consultation_category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-outline-success">أرسل السؤال</button>
                </div>
            </form>

        </div>
    </div>
</section>
@stop
