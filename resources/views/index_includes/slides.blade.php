<section class="container mt-5">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php $i = 0; ?>
            @foreach($slides as $slide)
            <button type="button" data-bs-target="#carouselExampleCaptions" 
            data-bs-slide-to="{{$i}}" class="{{$i++==0?'active':''}}"></button>
            @endforeach
        </div>
        <div class="carousel-inner" style="height: 400px;">
            <!-- Slides Items -->
            <?php $i = 0; ?>
            @foreach($slides as $slide)
            <div class="carousel-item {{$i==0?'active':''}} h-100"> <img src='{{ asset("$slide->img") }}'
                    class="h-100 w-100" >
                <div class="carousel-caption" style="top:10%;">
                    <div class="p-5 " style="background-color: rgba(0,0,0,0.5);  word-wrap: break-word; ">
                    <h2>{{$slide->title}}</h2>
                    <p>{!! $slide->content !!}</p>
                </div>
                </div>
            </div>
            <?php ++$i; ?>
            @endforeach
            <!-- Slides Items -->
            
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> </button>
        </div>
    </div>
    @if(Auth::check() && Auth::user()->type_id == Config::get('type_admin_id'))
    <div class="text-center">
        <a href="{{ route('slides.edit') }}" class="btn btn-outline-warning mt-5">تعديل الشرائح</a>
    </div>
    @endif
</section>
