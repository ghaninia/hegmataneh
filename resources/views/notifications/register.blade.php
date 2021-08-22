@extends("notifications.layouts.master")
@section("content")
@php( $enumsOption = new \App\Core\Enums\EnumsOption)
<tr>
    <td style="font-size:13px;line-height:22px;font-family:Tahoma,Arial,Helvetica,sans-serif;color:#403f3f;font-weight:normal;text-align:rigth">
        {{ options($enumsOption::NOTIFICATION_CONFIRM_REGISTER) }}
        <div style="border-bottom:1px dotted #eee;padding:20px 10px 15px 10px;margin:0 10px 10px">
            <div  style="width:450px;max-width:100%;margin:0 auto;text-align:center">
                <a href="{{ route("authunticate.register.verify" , $user->remember_token) }}"
                    style="padding:4px 10px;font-size:14px;text-align:center;text-decoration:none;border:none;outline:0;border-radius:2px;border-bottom:2px solid rgba(0,0,0,0.1);display:inline-block;font-weight:bold;margin-bottom:5px;color:#fff;background:#1381bf">
                        {{ trans("guest.enter-to-site")}}
                </a>
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
        </div>
    </td>
</tr>
@stop
