<?php

namespace App\Http\Requests\Option;

use App\Models\Post;
use App\Models\Comment;
use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsSort;
use App\Core\Enums\EnumsAnchor;
use App\Core\Enums\EnumsOption;
use Illuminate\Validation\Rule;
use App\Core\Enums\EnumsAuthunticate;
use Illuminate\Foundation\Http\FormRequest;

class OptionUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            EnumsOption::TITLE => ["nullable", "string"],
            ### توضیحات داشبورد
            EnumsOption::DESCRIPTION  => ["nullable", "string"],
            ### آیا بصورت خصوصی در بیاید
            EnumsOption::DASHBOARD_PRIVATE  => ["nullable", "boolean"],
            ### آیدی دیفالت کسی که میخواهد عضو شود
            EnumsOption::DASHBOARD_DEFAULT_REGISTER_ROLE  => ["nullable", "numeric"],
            ### آیا هر کسی میتواند لاگین کند
            EnumsOption::DASHBOARD_CAN_REGISTER  => ["nullable", "boolean"],
            ### کپی رایت داشبورد
            EnumsOption::DASHBOARD_FOOTER_COPYRIGHT  => ["nullable", "string"],
            ### قوانین زمان ثبت نام
            EnumsOption::DASHBOARD_REGISTER_RULE  => ["nullable", "string"],
            ### کپی رایت نوتیفیکیشن
            EnumsOption::NOTIFICATION_COPYRIGHT  => ["nullable", "string"],
            ###  زمانی که نوتیفکیشن زمان ثبت نام ثبت میشود
            EnumsOption::NOTIFICATION_CONFIRM_REGISTER  =>  ["nullable", "string"],
            ### سابجکت درخواست تایید ثبت نام
            EnumsOption::NOTIFICATION_CONFIRM_REGISTER_SUBJECT  =>  ["nullable", "string"],
            ### توکن اینستاگرام
            EnumsOption::TOKEN_INSTAGRAM  =>  ["nullable", "string"],
            ### متن سابسکرایب
            EnumsOption::SUBSCRIBE_TEXT  =>  ["nullable", "string"],
            ### آیدی گیتهاب برای معرفی
            EnumsOption::GITHUB_ACCOUNT  =>  ["nullable", "string"],
            ### آیدی لینکدین برای معرفی
            EnumsOption::LINKDIN_ACCOUNT  =>  ["nullable", "string"],
            ### آیدی توییتر برای معرفی
            EnumsOption::TWITTER_ACCOUNT  =>  ["nullable", "string"],
            ### آیدی جیمیل برای معرفی
            EnumsOption::GMAIL_ACCOUNT  =>  ["nullable", "string"],
            ### آیدی تلگرام برای معرفی
            EnumsOption::TELEGRAM_ACCOUNT  =>  ["nullable", "string"],
            ### آیدی اینستاگرام برای معرفی
            EnumsOption::INSTAGRAM_ACCOUNT  =>  ["nullable", "string"],
            ### توضیحات کوتاه در مورد سایت
            EnumsOption::ABOUTE_US  =>  ["nullable", "string"],
            ### آدرس محل سکونت
            EnumsOption::ADDRESS  =>  ["nullable", "string"],
            ### آدرس ایمیل جهت پشتیبانی
            EnumsOption::SUPPORT_EMAIL  =>  ["nullable", "string"],
            ### تلفن جهت پشتیبانی
            EnumsOption::SUPPORT_TELLPHONE  =>  ["nullable", "string"],
            ### شماره موبایل جهت پشتیبانی
            EnumsOption::SUPPORT_MOBILE  =>  ["nullable", "string"],
            ### فکس جهت پشتیبانی
            EnumsOption::SUPPORT_FAX  =>  ["nullable", "string"],
            ### تعداد ستاره های امتیازدهی
            EnumsOption::COUNT_VOTE_STAR  =>  ["nullable", "numeric"],
            ### توانایی تکرار امتیاز دهی را دارد؟.
            EnumsOption::MEMBER_CAN_EDIT_VOTE  =>  ["nullable", "boolean"],
            ### فقط اعضا و میمهان توانایی امتیازدهی پست ها را دارند
            EnumsOption::CAN_VOTE_POSTS  =>  ["nullable", "array"],
            EnumsOption::CAN_VOTE_POSTS . ".*"  =>  ["required", Rule::in(EnumsAuthunticate::type())],
            ### فقط اعضا و میهمان توانایی امتیازدهی برگه ها را دارند
            EnumsOption::CAN_VOTE_PAGES  => ["nullable", "array"],
            EnumsOption::CAN_VOTE_PAGES . ".*"  =>  ["required", Rule::in(EnumsAuthunticate::type())],
            ### فقط اعضا و میهمان توانایی امتیازدهی محصولات را دارند
            EnumsOption::CAN_VOTE_PRODUCTS  => ["nullable", "array"],
            EnumsOption::CAN_VOTE_PRODUCTS . ".*"  =>  ["required", Rule::in(EnumsAuthunticate::type())],
            ### چه وضعیت های جدول پست میتواند امتیاز بگیرد
            EnumsOption::VOTE_ITEMS_ENABLE  => ["nullable", "array"],
            EnumsOption::VOTE_ITEMS_ENABLE . ".*"  =>  ["required", Rule::in(EnumsPost::type())],
            ### سربرگ فروشگاه
            EnumsOption::SHOP_TITLE  => ["nullable", "string"],
            ### توضیحات فروشگاه
            EnumsOption::SHOP_DESCRIPTION  => ["nullable", "string"],
            ### واحد ارزی
            EnumsOption::SHOP_CURRENCY  => ["nullable", "string"],
            ### چه وضعیت های جدول پست میتواند کامنت بگیرد
            EnumsOption::CAN_COMMENT_POSTS  => ["nullable", "array"],
            EnumsOption::CAN_COMMENT_POSTS . ".*" => ["required", Rule::in(EnumsPost::type())],
            ### توانایی ریپلای کامنت وجود داشته باشد
            EnumsOption::THREAD_COMMENTS  =>  ["nullable", "boolean"],
            ### حداکثر عمق برای کامنت ها چقدر باشد
            EnumsOption::THREAD_COMMENTS_DEPTH  =>  ["nullable", "numeric"],
            ### برای کامنت دهی باید وارد حساب کاربری شوند
            EnumsOption::COMMENT_REGISTRATION  => ["nullable", "boolean"],
            ### کامنت ها صفحه بندی شوند
            EnumsOption::PAGE_COMMENTS  => ["nullable", "boolean"],
            ### حداکثر آیتم های کامنت در صفحه
            EnumsOption::COMMENTS_PER_PAGE  =>  ["nullable", "numeric"],
            ### کامنت ها به چه صورتی مرتب گردند
            EnumsOption::COMMENT_ORDER  =>  ["nullable", Rule::in(EnumsSort::type()) ],
            ### بصورت پیشفرض کامنت ها چگونه مرتب شوند
            EnumsOption::DEFAULT_COMMENTS_PAGE  => ["nullable", Rule::in(EnumsSort::type()) ],
            ### نظارت بر روی نظرات
            EnumsOption::COMMENT_MODERATION  => ["nullable", "boolean"],
            ### چه کسی میتواند نظرها را لایک کند
            EnumsOption::CAN_LIKE_COMMENTS  => ["nullable", "array"],
            EnumsOption::CAN_LIKE_COMMENTS . ".*" =>  ["required", Rule::in(EnumsAuthunticate::type()) ] ,
            ### توانایی لایک برای چه کسایی وجود دارد؟
            EnumsOption::LIKE_ITEMS_ENABLE  => ["nullable", "array"],
            EnumsOption::LIKE_ITEMS_ENABLE.".*"  => ["required", Rule::in(EnumsAnchor::type())],
            ### افراد میتوانند لایک های خود را عوض کنند؟
            EnumsOption::MEMBER_CAN_EDIT_LIKE  => ["nullable", "boolean"],
            ### لوگو
            EnumsOption::LOGO  => ["nullable", "string"],
            ### فاوآیکون
            EnumsOption::FAVICON  => ["nullable", "string"],
        ];
    }
}
