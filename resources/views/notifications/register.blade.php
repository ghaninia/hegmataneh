@extends("notifications.layouts.master")
@section("content")
    <h4 style="margin-bottom: 20px;">
        {{ trans("dashboard.notification.verify.label" , ['attribute' => $user->name ]) }}
    </h4>
    <div style="color: #636363; font-size: 12px;">
        {!! options(\App\Core\Enums\EnumsOption::NOTIFICATION_CONFIRM_REGISTER) !!}
    </div>
    <a
    href="{{ route("authunticate.register.verify" , $user->remember_token ) }}"
    style="border-radius:30px;box-shadow : 0 2px 4px rgba(0,0,0,.1) ;padding: 8px 20px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 12px; display: inline-block; margin: 20px 0px;text-decoration: none;">
        {{ trans("dashboard.notification.verify.link") }}
    </a>
@stop
