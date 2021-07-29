<div class="d-sm-flex flex-wrap align-items-center">
    <form action="{{ $search_route }}" method="GET" class="d-flex flex-wrap align-items-center">
        @if( old('orderCol') !== null )
            <input type="hidden" name="orderCol" value="{{ old('orderCol') }}">
        @endif
        @if( old('orderType') !== null )
            <input type="hidden" name="orderType" value="{{ old('orderType') }}">
        @endif
        @if( old('answered') !== null)
        <input type="hidden" name="answered" value="{{ old('answered') }}">
        @endif
        <div class="mb-2 me-2">
            <select class="js-example-basic-multiple" style="" name="tags[]" multiple="multiple">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success mb-2">بحث</button>
    </form>
    <form action="{{ $all_route }}" method="GET">
        @if( old('orderCol') !== null )
            <input type="hidden" name="orderCol" value="{{ old('orderCol') }}">
        @endif
        @if( old('orderType') !== null )
            <input type="hidden" name="orderType" value="{{ old('orderType') }}">
        @endif
        <button type="submit" class="btn btn-success mb-2 ms-sm-2 ms-0">{{ $all_text }}</button>
    </form>
</div>
