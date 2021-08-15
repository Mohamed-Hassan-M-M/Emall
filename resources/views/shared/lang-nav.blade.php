<div id="exTab3" class="container">	
    <ul  class="nav nav-pills">
        @foreach($languages as $lang)
        <li class="{{($lang->code==app()->getLocale())?'active':''}}">
            <a  href="#{{$lang->code}}" class="btn " data-toggle="tab">
                <img src="{{asset('assets/images/flags/'.$lang->code.'.jpg')}}" alt="user-image" class="mr-1"
                     height="12"> <span
                     class="align-middle">{{$lang->name}}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>