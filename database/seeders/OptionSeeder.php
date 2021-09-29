<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsSort;
use App\Core\Enums\EnumsAnchor;
use App\Core\Enums\EnumsOption;
use Illuminate\Database\Seeder;
use App\Core\Enums\EnumsAuthunticate;
use App\Repositories\Currency\CurrencyRepository;
use App\Repositories\Language\LanguageRepository;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $languageDefault = app(LanguageRepository::class)->create([
            "name" => "فارسی" ,
            "code" => "ir"
        ]);
        
        $currencyDefault = app(CurrencyRepository::class)->create([
            "name" => "ریال" ,
            "code" => "rial"
        ]);

        array_map(function ($record) {
            Option::create([
                "key" => $record["key"],
                "default" => $record["default"],
            ]);
        }, [
            [
                ### سربرگ داشبورد
                'key' => EnumsOption::TITLE,
                'default' => "صفحه رسمی امین غنی نیا"
            ],
            [
                ### توضیحات داشبورد
                'key' => EnumsOption::DESCRIPTION,
                'default' => "توضیحات کوتاهی در مورد صفحه رسمی امین غنی نیا"
            ],
            [
                ### آیا بصورت خصوصی در بیاید
                'key' => EnumsOption::DASHBOARD_PRIVATE,
                'default' => FALSE
            ],
            [
                ### آیدی دیفالت کسی که میخواهد عضو شود
                'key' => EnumsOption::DASHBOARD_DEFAULT_REGISTER_ROLE,
                'default' => NULL
            ],
            [
                ### آیا هر کسی میتواند لاگین کند
                'key' => EnumsOption::DASHBOARD_CAN_REGISTER,
                'default' => TRUE
            ],
            [
                ### کپی رایت داشبورد
                'key' => EnumsOption::DASHBOARD_FOOTER_COPYRIGHT,
                'default' => NULL
            ],
            [
                ### قوانین زمان ثبت نام
                'key' => EnumsOption::DASHBOARD_REGISTER_RULE,
                'default' => NULL
            ],
            [
                ### کپی رایت نوتیفیکیشن
                'key' => EnumsOption::NOTIFICATION_COPYRIGHT,
                'default' => "©Copyrights Lora Co - 1400"
            ],
            [
                ### پیام زمانی که نوتیفکیشن زمان ثبت نام ثبت میشود
                'key' => EnumsOption::NOTIFICATION_CONFIRM_REGISTER,
                'default' => "از عضویت شما صمیمانه خوشبختیم. اگر شما میخواهید پروفایل خود را تکمیل نمایید و عضویت را کامل کنید روی لینک زیر کلیک کنید و در غیر این صورت این ایمیل را نادیده بگیرید"
            ],
            [
                ### سابجکت درخواست تایید ثبت نام
                'key' => EnumsOption::NOTIFICATION_CONFIRM_REGISTER_SUBJECT,
                'default' => "تایید عضویت سایت"
            ],
            [
                ### توکن اینستاگرام
                'key' => EnumsOption::TOKEN_INSTAGRAM,
                'default' => NULL
            ],
            [
                ### متن سابسکرایب
                'key' => EnumsOption::SUBSCRIBE_TEXT,
                'default' => NULL
            ],
            [
                ### آیدی گیتهاب برای معرفی
                'key' => EnumsOption::GITHUB_ACCOUNT,
                'default' => NULL
            ],
            [
                ### آیدی لینکدین برای معرفی
                'key' => EnumsOption::LINKDIN_ACCOUNT,
                'default' => NULL
            ],
            [
                ### آیدی توییتر برای معرفی
                'key' => EnumsOption::TWITTER_ACCOUNT,
                'default' => NULL
            ],
            [
                ### آیدی جیمیل برای معرفی
                'key' => EnumsOption::GMAIL_ACCOUNT,
                'default' => NULL
            ],
            [
                ### آیدی تلگرام برای معرفی
                'key' => EnumsOption::TELEGRAM_ACCOUNT,
                'default' => NULL
            ],
            [
                ### آیدی اینستاگرام برای معرفی
                'key' => EnumsOption::INSTAGRAM_ACCOUNT,
                'default' => NULL
            ],
            [
                ### توضیحات کوتاه در مورد سایت
                'key' => EnumsOption::ABOUTE_US,
                'default' => NULL
            ],
            [
                ### آدرس محل سکونت
                'key' => EnumsOption::ADDRESS,
                'default' => NULL
            ],
            [
                ### آدرس ایمیل جهت پشتیبانی
                'key' => EnumsOption::SUPPORT_EMAIL,
                'default' => NULL
            ],
            [
                ### تلفن جهت پشتیبانی
                'key' => EnumsOption::SUPPORT_TELLPHONE,
                'default' => NULL
            ],
            [
                ### شماره موبایل جهت پشتیبانی
                'key' => EnumsOption::SUPPORT_MOBILE,
                'default' => NULL
            ],
            [
                ### فکس جهت پشتیبانی
                'key' => EnumsOption::SUPPORT_FAX,
                'default' => NULL
            ],
            [
                ### تعداد ستاره های امتیازدهی
                'key' => EnumsOption::COUNT_VOTE_STAR,
                'default' => 5
            ],
            [
                ### توانایی تکرار امتیاز دهی را دارد؟.
                'key' => EnumsOption::MEMBER_CAN_EDIT_VOTE,
                'default' => TRUE
            ],
            [
                ### فقط اعضا و میمهان توانایی امتیازدهی پست ها را دارند
                'key' => EnumsOption::CAN_VOTE_POSTS,
                'default' => EnumsAuthunticate::type()
            ],
            [
                ### فقط اعضا و میهمان توانایی امتیازدهی برگه ها را دارند
                'key' => EnumsOption::CAN_VOTE_PAGES,
                'default' => EnumsAuthunticate::type()
            ],
            [
                ### فقط اعضا و میهمان توانایی امتیازدهی محصولات را دارند
                'key' => EnumsOption::CAN_VOTE_PRODUCTS,
                'default' => EnumsAuthunticate::type()
            ],
            [
                ### چه وضعیت های جدول پست میتواند امتیاز بگیرد
                'key' => EnumsOption::VOTE_ITEMS_ENABLE,
                'default' => EnumsPost::type()
            ],
            [
                ### سربرگ فروشگاه
                'key' => EnumsOption::SHOP_TITLE,
                'default' => NULL
            ],
            [
                ### توضیحات فروشگاه
                'key' => EnumsOption::SHOP_DESCRIPTION,
                'default' => NULL
            ],
            [
                ### واحد ارزی
                'key' => EnumsOption::SHOP_CURRENCY,
                'default' => NULL
            ],
            [
                ### چه وضعیت های جدول پست میتواند کامنت بگیرد
                'key' => EnumsOption::CAN_COMMENT_POSTS,
                'default' => EnumsPost::type()
            ],
            [
                ### توانایی ریپلای کامنت وجود داشته باشد
                'key' => EnumsOption::THREAD_COMMENTS,
                'default' => TRUE
            ],
            [
                ### حداکثر عمق برای کامنت ها چقدر باشد
                'key' => EnumsOption::THREAD_COMMENTS_DEPTH,
                'default' => 4
            ],
            [
                ### برای کامنت دهی باید وارد حساب کاربری شوند
                'key' => EnumsOption::COMMENT_REGISTRATION,
                'default' => FALSE
            ],
            [
                ### کامنت ها صفحه بندی شوند
                'key' => EnumsOption::PAGE_COMMENTS,
                'default' => TRUE
            ],
            [
                ### حداکثر آیتم های کامنت در صفحه
                'key' => EnumsOption::COMMENTS_PER_PAGE,
                'default' => 50
            ],
            [
                ### کامنت ها به چه صورتی مرتب گردند
                'key' => EnumsOption::COMMENT_ORDER,
                'default' => EnumsSort::TYPE_ASC
            ],
            [
                ### بصورت پیشفرض کامنت ها چگونه مرتب شوند
                'key' => EnumsOption::DEFAULT_COMMENTS_PAGE,
                'default' => EnumsSort::TYPE_ASC
            ],
            [
                ### نظارت بر روی نظرات
                'key' => EnumsOption::COMMENT_MODERATION,
                'default' => TRUE
            ],
            [
                ### چه کسی میتواند نظرها را لایک کند
                'key' => EnumsOption::CAN_LIKE_COMMENTS,
                'default' => EnumsAuthunticate::type()
            ],
            [
                ### توانایی لایک برای چه کسایی وجود دارد؟
                'key' => EnumsOption::LIKE_ITEMS_ENABLE,
                'default' => EnumsAnchor::type()
            ],
            [
                ### افراد میتوانند لایک های خود را عوض کنند؟
                'key' => EnumsOption::MEMBER_CAN_EDIT_LIKE,
                'default' => TRUE
            ],
            [
                ### لوگو
                'key' => EnumsOption::LOGO,
                'default' => NULL
            ],
            [
                ### فاوآیکون
                'key' => EnumsOption::FAVICON,
                'default' => NULL
            ],
            [
                ### زبان دیفالت سیستم
                'key' => EnumsOption::SYSTEM_DEFAULT_LANGUAGE,
                'default' => $languageDefault->id
            ],
            [
                ### واحد پولی دیفالت
                'key' => EnumsOption::SYSTEM_DEFAULT_CURRENCY,
                'default' => $currencyDefault->id
            ],
        ]);
    }
}
