@extends("layouts.layout")
@section('title')
    {{$content->title}}
@endsection
@section("content")
    <div class="container-fluid">

        <div class="container-x row m-0 mt-lg-5 mt-md-5">
            <div class="col-lg-12 col-md-12">
                <div class="blog-r">
                    <img src="{{$content->image}}" class="w-100" alt="{{$content->title}}">
                    <div class="blog-r-t">
                        <h5 class="">
                            {{$content->title}}
                        </h5>
                        <span>
              <a href="#">
                {{$content->user->name}}
              </a>
            </span>
                        <span>
              <a href="#">
                دسته بندی @foreach($content->category as $c)
                      <a href="{{ "#" }}">{{$c->Category->title}}</a>
                      , @endforeach
              </a>
           </span>
                        <span>
             <a href="#">
              {{$content->jalali_created_at}}
             </a>
           </span>
                        <span class="float-left">
             {{--<a href="#">
              اشتراک گذاری
             </a>--}}
           </span>
                    </div>
                    {!! $content->body !!}
                    <hr/>
                    <h5>
                        منبع : <a target="_blank" href="{{ $content->base_url }}">ارز دیجیتال</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>



@endsection
