<section id="siteSections" class="container mt-5">
    <header class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-center flex-wrap">
        <div class="invisible d-none d-lg-inline">
            @if(Auth::check() && Auth::user()->type_id == Config::get('type_admin_id'))
            <a href="" class="btn btn-sm btn-outline-warning me-2 mb-2">إضافة قسم</a>
            @endif
            <a href="#" class="btn btn-sm btn-outline-success  mb-2">عرض كافة المقالات</a>
        </div>
        <a  class="h2 mb-4 mb-lg-2 text-dark">أقسام الموقع</a>
        <div>
            @if(Auth::check() && Auth::user()->type_id == Config::get('type_admin_id'))
            <a href="{{ route('postCategories.create') }}" class="btn btn-sm btn-outline-warning me-2 mb-2">إضافة قسم</a>
            @endif
            <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-success mb-2">عرض كافة المقالات</a>
        </div>
    </header>
    <nav>
        <div id="siteSectionsRow" class="row mt-5">
              <!-- Sections cards -->
            @foreach($postCategories as $postCategory)
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="{{ route('posts.index',['slug'=> $postCategory->slug]) }}"
                         class="card siteSectionCard">
                        <div class="card-img-top"> <img src="{{ asset($postCategory->img) }}" class="w-100 rounded-3"
                                height="150px" alt=""> </div>
                        <div class="card-body text-center d-flex align-items-center justify-content-center">
                        <div class="w-100">
                            <h5 class="mb-0 text-white">{{ $postCategory->name }}</h5>
                        </div>
                        </div>
                    </a> </div>
            @endforeach
                <!-- Sections cards -->
        </div>

     
        <div class="text-center mt-5">
            <button id="btnSectionsMore" class="btn btn-success">
                <span>إظهار المزيد</span>
                <i class="bi bi-plus-circle"></i>
            </button>
            <button id="btnSectionsLess" class="d-none btn btn-danger d-none">
                <span>أقل</span>
                <i class="bi bi-dash-circle"></i>
            </button>
        </div> 
    
    </nav>
</section>

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#btnSectionsMore").click(function(){
                $("#siteSectionsRow").children().removeClass("d-none");
                toggleShowButtons();
            });
            $("#btnSectionsLess").click(function(){
                removeCards();
                toggleShowButtons();
            });
            function toggleShowButtons(){
                $("#btnSectionsMore").toggleClass("d-none");
                $("#btnSectionsLess").toggleClass("d-none");
            }
            function removeToggleButtons(){
                $("#btnSectionsMore").addClass("d-none");
                $("#btnSectionsLess").addClass("d-none");
            }
            let showCardsNum = -1;
            function removeCards(){
                breakpoints = {"sm" : 576,"md" : 768, "lg" : 992};
                let width = document.documentElement.clientWidth;
                let cardsNum = {{ $postCategories->count() }};
                let newShowCardsNum = showCardsNum;
                if(width>= breakpoints.lg) newShowCardsNum = 12;
                else if(width>= breakpoints.md) newShowCardsNum = 8;
                else if(width>= breakpoints.sm) newShowCardsNum = 6;
                if(showCardsNum == newShowCardsNum){
                    return;
                }
                showCardsNum = newShowCardsNum;
                $("#siteSectionsRow").children().slice(0,showCardsNum ).removeClass("d-none");
                $("#siteSectionsRow").children().slice(showCardsNum).addClass("d-none");

                if( showCardsNum >= cardsNum){
                    removeToggleButtons();
                }
                else{
                    $("#btnSectionsMore").removeClass("d-none");
                    $("#btnSectionsLess").addClass("d-none");
                }
            }
            removeCards();
            window.onresize = removeCards;
         
        });
    </script>
@endsection