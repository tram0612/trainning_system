<div style="border:1px solid red;border-radius:5px;padding:10px;">
    <h1>{{__('email.hello')}} {{$user['name']}}<h1>
    <span style="font-size:13px">{{__('email.registered')}} {{$user['email']}}</span>
    <p style="font-size:15px;line-height:25px;"><a href="{{route('signin')}}">
    {{__('email.welcome')}}</a>
    </p>
</div>
