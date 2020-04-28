@extends("layouts.layout")
@section('title')
   صفحه اصلی
@endsection
@section("content")

    @php
        $contents = $page;
        $highs =$page;
        $mostVisited =$page;
    @endphp
    <div class="container-fluid">

        <div class="container-x">
            <div class="news-s">
                <div class="col-md-7">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($contents as $index=>$content)
                                @continue($index==0)
                                @continue($index>5)
                                <div class="carousel-item {{$index==1?'active':''}}">
                                    <a href="{{$content->url}}"> <img class="d-block w-100"
                                                                      src="{{$content->image}}"
                                                                      alt="{{$content->title}}"></a>
                                    <div class="caption">
                                        <h6>
                                            <a class="caption-title" href="{{$content->url}}">
                                                {{$content->title}}
                                            </a>
                                        </h6>
                                        <p>
                                            <a class="caption-description" href="{{ $content->url }}">
                                                {!! $content->content !!}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                @foreach($contents as $index=>$content)
                    @continue($index>0)
                    <div class="col-md-5">
                        <a href="{{$content->url}}"><img src="{{$content->image}}"
                                                         class="w-100 img-h"
                                                         alt="{{$content->title}}"></a>
                        <div class="caption">
                            <h6>
                                <a class="caption-title" href="{{$content->url}}">
                                    {{$content->title}}
                                </a>
                            </h6>
                            <p>
                                <a class="caption-description" href="{{$content->url}}">
                                    {!! $content->content !!}
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--end first-->
            <!--second-->
            <div class="blog-s">
                <div class="box-h">
                    <h6 class="float-right">مهم ترین اخبار</h6>
                </div>
                <div class="boxes row m-0 justify-content-center ">
                    @forelse($highs as $mv)
                        @if($loop->index < 4)
                            <div class="col-md-4 col-lg-3">
                                <div class="box-b">
                                    <a href="{{$mv->url}}">
                                        <img src="{{$mv->image}}" class="w-100" alt="{{$mv->title}}">
                                    </a>
                                    <div class="padding-div">
                                        <a href="{{$mv->url}}">
                                            <h6>{{$mv->title}}</h6>
                                        </a>
                                        <div class="boxes-icon">
                                            <a href="{{$mv->url}}">
                                                <span>{{$mv->user->fullname}}</span>
                                                <span>{{$mv->jalali_created_at}}</span>
                                                <a href="{{$mv->url}}">
                                                    <i class="fas fa-chevron-left float-left"></i>
                                                </a>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @empty

                    @endforelse

                </div>
            </div>
            <!--end second-->
            <!--third-->
            <div class="col-12">
                <div class="col-lg-3 col-md-4 float-left">

                    <div class="blog-l">
                        <h6>پربازدیدترین ها</h6>
                        @foreach($mostVisited as $m)
                            <a href="{{$m->url}}">
                                <p>{{$m->title}}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class=" col-lg-9 col-md-8 pad-0">
                    @foreach($contents as $content)
                        <div class="blog-r">
                            <div class="col-lg-4">
                                <a href="{{$content->url}}">
                                    <img src="{{$content->image}}" class="w-100" alt="{{$content->title}}">
                                </a>
                            </div>
                            <div class="col-lg-8">
                                <h6>
                                    <a href="#">
                                        {{$content->title}}
                                    </a>
                                </h6>
                                <div class="news-blog-i">
                                    <span>
                                        <a href="{{$content->url}}">
                                            {{ $content->user->name }}
                                        </a>
                                    </span>
                                    <span>
                                    @foreach($content->category as $c)
                                            <a href="{{$c->category->url}}">
                                    {{$c->category->title}}
                                    </a>,
                                        @endforeach
</span>
                                    <span>
<a href="#">
{{$content->jalali_created_at}}
</a>
</span>
                                </div>
                                <p>{!! $content->content !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--end third-->
            <!--pagination-->
            <div class="container st-container">
                <div class="col-12 page-nav">
                     <nav aria-label="Page navigation example">
                       {!! $page->links() !!}
                     </nav>
                </div>
            </div>
            <!--end pagination-->
        </div>
    </div>
@endsection
