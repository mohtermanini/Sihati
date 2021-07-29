@extends('layouts.app')

@section('content')
<main class="flex-grow-1 mt-5">

  @include('includes.breadcrumb',[
    'breadcrumbs' => [
        [ 'title' => 'الصفحة الرئيسية', 'url' => route('index')],
        [ 'title' =>  $post->post_category->name, 
              'url' => route('posts.index',['slug'=> $post->post_category->slug]) ],
        [ 'title' => $post->title]
    ]
])

  <section class="container">
    <div class="row">
      <div class="col-lg-8  mb-3"> 
        <!-- Post -->
        <div class="card">
          <div class="card-header">
            <h3>{{ $post->title }}</h3>
            <div class="d-flex align-items-center text-muted ">
              <i class="bi bi-calendar3 me-2"></i>
              <small>{{ \App\Http\Controllers\GeneralController::toArabicDate($post->created_at) }}</small>
              &nbsp;|&nbsp;
              <a href="{{ route('posts.index', ['slug'=>$post->post_category->slug]) }}"
                 class="text-muted"><small>{{ $post->post_category->name }}</small></a>
              &nbsp;|&nbsp;
              <small>{{ $post->views }} مشاهدة</small>
               </div>
          </div>
          <img src=" {{ asset($post->img) }}" alt="" class="w-100" style="max-height: 250px;">
          <div class="card-body">
            <div class="mt-3">
              {!! $post->content !!}
            </div>
            <!-- Tags -->
            @if($post->tags->count() > 0)
              <hr class="mt-5">
              <h5 class="mt-3">كلمات مفتاحية</h5>
                <ul class="mt-3 list-unstyled">
                  @foreach($post->tags as $tag)
                  <li class="d-inline-block mb-3">
                    <button class="btn btn-outline-info me-2 btn-sm rounded-pill">
                      {{$tag->name}}  
                    </button>
                    </li>
                  @endforeach
                </ul>
              @endif 
            </div>
            <!-- Tags -->
          <div class="card-footer">
         	 <!-- Writers -->
            <?php $currUser = 0; ?>
            @foreach($post->users as $user)
          	 <div class="d-flex flex-wrap flex-sm-nowrap mt-2">
               <img src="{{asset($user->profile->avatar)}}" height="75" width="75" 
                    class="rounded-circle me-2 mb-2">
                <div>
                 <a href="{{ route('users.show',['user'=>$user->id])}}" 
                    class="btn btn-info rounded-pill btn-sm text-decoration-none text-white ">
                      <small>
                      {{ $user->profile->titleFromGender() }} 
                      {{ $user->profile->first_name }}
                      {{ $user->profile->last_name }}
                      </small></a> 
                

                <?php $i=0; ?>
                <p class="mb-0">
                  @foreach($user->profile->jobs as $job)
           			  <small class="{{$i==0?'ms-2':''}} text-muted">{{ $i++==0?'':' - '}}{{ $job->title }}</small>
                   @endforeach
                </p>

                <p class="ms-2">
                <small>
                  {{$user->profile->description}}
                </small>
                 </p>
                  </div>
              </div>
              <!-- Writers -->
            
              {!! ++$currUser == count($post->users)?'':'<hr>' !!}
              
              @endforeach
               
          </div>
        </div>
        <!-- Post --> 
        <!-- Post modify -->
        @if(Auth::check() && 
              (Auth::user()->type_id == Config::get('type_admin_id') ||
               \App\Http\Controllers\GeneralController::checkIfPostWriter($post))
              )
        <div id="modifyBtns" class="text-center mt-3">
            <a id="btnChange" href="{{ route('posts.edit',['id'=>$post->id, 'slug'=>$post->slug]) }}"
                 class="btn btn-warning me-3">تعديل المقالة</a>
        </div>
        @endif
        <!-- Post modify -->
        <!-- Related Posts -->
      @if($related_posts->count() > 0)
     <section id="relatedPosts" class="mt-5">
  	<div class="card">
  		<div class="card-header p-3">
  			<h4>مقالات ذات صلة</h4>
  		</div>
  		<div class="card-body p-0">
        <?php $i=0; ?>
        @foreach($related_posts as $post)
        @if($i++>0) <hr class="m-0"> @endif
  			<a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug])}}"
                 class="d-flex justify-content-between align-items-center p-3 grey-hover">
  				<h6 style="color:blue; font-size:1.1rem;">{{$post->title}}</h6>
  				<i class="bi bi-arrow-left-circle ms-2 text-muted" style="font-size: 25px;"></i>
  			</a>
        @endforeach
  		</div>
  	</div>
  </section>
  @endif
      <!-- Related Posts -->
      </div>
      <div class="col-lg-4  mb-3">
        <aside>
            @include('includes.ads.doctor_register')
         </aside>
      </div>
    </div>
  </section>

</main>

@stop