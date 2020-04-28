<!DOCTYPE html>
<html lang="en">
@include("includes.head")
<body dir="rtl">
<div class="container-fluid">

    @include("includes.menu")
    {{--    <div class="container-x">--}}
    @yield("content")
        @include("includes.footer")
    <div id="search">
        <button type="button" class="close">×</button>
        <form action="{{"#" }}" method="get" class="p-5">
            <div class="form-group">
                <label for="SearchInput" style="display: none;"></label>
                <input type="text" id="SearchInput" class="custom-input-x" name="query"
                       placeholder="به دنبال چه چیزی هستید ؟"/>
            </div>
            <button type="submit" class="btn btn-outline-light mt-2">جستجو کن</button>
        </form>
    </div>
    <script>


        $(function () {
            $('a[href="#search"]').on('click', function (event) {
                event.preventDefault();
                $('#search').addClass('open');
            });

            $('#search, #search button.close').on('click keyup', function (event) {
                if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                    $(this).removeClass('open');
                }
            });
        });
    </script>
</div>

</body>
</html>
