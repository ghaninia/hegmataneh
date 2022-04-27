<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Currency;
use App\Models\Language;
use App\Kernel\Enums\EnumsPost;
use App\Kernel\Enums\EnumsSort;
use App\Kernel\Enums\EnumsOption;
use App\Kernel\Enums\EnumsSystem;
use Illuminate\Database\Seeder;
use App\Kernel\Enums\EnumsAuthunticate;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $languageDefault = Language::create([
            "name" => "فارسی" ,
            "code" => "ir"
        ]);

        $currencyDefault = Currency::create([
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
                'title' => 'سربرگ داشبورد' ,
                'key' => EnumsOption::TITLE,
                'default' => "صفحه رسمی امین غنی نیا"
            ],
            [
                'title' => 'توضیحات داشبورد' ,
                'key' => EnumsOption::DESCRIPTION,
                'default' => "توضیحات کوتاهی در مورد صفحه رسمی امین غنی نیا"
            ],
            [
                'title' => 'آیا بصورت خصوصی در بیاید' ,
                'key' => EnumsOption::DASHBOARD_PRIVATE,
                'default' => FALSE
            ],
            [
                'title' => 'آیدی دیفالت کسی که میخواهد عضو شود' ,
                'key' => EnumsOption::DASHBOARD_DEFAULT_REGISTER_ROLE,
                'default' => NULL
            ],
            [
                'title' => 'آیا هر کسی میتواند لاگین کند' ,
                'key' => EnumsOption::DASHBOARD_CAN_REGISTER,
                'default' => TRUE
            ],
            [
                'title' => 'کپی رایت داشبورد' ,
                'key' => EnumsOption::DASHBOARD_FOOTER_COPYRIGHT,
                'default' => NULL
            ],
            [
                'title' => 'قوانین زمان ثبت نام' ,
                'key' => EnumsOption::DASHBOARD_REGISTER_RULE,
                'default' => NULL
            ],
            [
                'title' => 'کپی رایت نوتیفیکیشن' ,
                'key' => EnumsOption::NOTIFICATION_COPYRIGHT,
                'default' => "©Copyrights Lora Co - 1400"
            ],
            [
                'title' => 'پیام زمانی که نوتیفکیشن زمان ثبت نام ثبت میشود' ,
                'key' => EnumsOption::NOTIFICATION_CONFIRM_REGISTER,
                'default' => "از عضویت شما صمیمانه خوشبختیم. اگر شما میخواهید پروفایل خود را تکمیل نمایید و عضویت را کامل کنید روی لینک زیر کلیک کنید و در غیر این صورت این ایمیل را نادیده بگیرید"
            ],
            [
                'title' => 'سابجکت درخواست تایید ثبت نام' ,
                'key' => EnumsOption::NOTIFICATION_CONFIRM_REGISTER_SUBJECT,
                'default' => "تایید عضویت سایت"
            ],
            [
                'title' => 'توکن اینستاگرام' ,
                'key' => EnumsOption::TOKEN_INSTAGRAM,
                'default' => NULL
            ],
            [
                'title' => 'متن سابسکرایب' ,
                'key' => EnumsOption::SUBSCRIBE_TEXT,
                'default' => NULL
            ],
            [
                'title' => 'آیدی گیتهاب برای معرفی' ,
                'key' => EnumsOption::GITHUB_ACCOUNT,
                'default' => NULL
            ],
            [
                'title' => 'آیدی لینکدین برای معرفی' ,
                'key' => EnumsOption::LINKDIN_ACCOUNT,
                'default' => NULL
            ],
            [
                'title' => 'آیدی توییتر برای معرفی' ,
                'key' => EnumsOption::TWITTER_ACCOUNT,
                'default' => NULL
            ],
            [
                'title' => 'آیدی جیمیل برای معرفی' ,
                'key' => EnumsOption::GMAIL_ACCOUNT,
                'default' => NULL
            ],
            [
                'title' => 'آیدی تلگرام برای معرفی' ,
                'key' => EnumsOption::TELEGRAM_ACCOUNT,
                'default' => NULL
            ],
            [
                'title' => 'آیدی اینستاگرام برای معرفی' ,
                'key' => EnumsOption::INSTAGRAM_ACCOUNT,
                'default' => NULL
            ],
            [
                'title' => 'توضیحات کوتاه در مورد سایت' ,
                'key' => EnumsOption::ABOUTE_US,
                'default' => NULL
            ],
            [
                'title' => 'آدرس محل سکونت' ,
                'key' => EnumsOption::ADDRESS,
                'default' => NULL
            ],
            [
                'title' => 'آدرس ایمیل جهت پشتیبانی' ,
                'key' => EnumsOption::SUPPORT_EMAIL,
                'default' => NULL
            ],
            [
                'title' => 'تلفن جهت پشتیبانی' ,
                'key' => EnumsOption::SUPPORT_TELLPHONE,
                'default' => NULL
            ],
            [
                'title' => 'شماره موبایل جهت پشتیبانی' ,
                'key' => EnumsOption::SUPPORT_MOBILE,
                'default' => NULL
            ],
            [
                'title' => 'فکس جهت پشتیبانی' ,
                'key' => EnumsOption::SUPPORT_FAX,
                'default' => NULL
            ],
            [
                'title' => 'تعداد ستاره های امتیازدهی' ,
                'key' => EnumsOption::COUNT_VOTE_STAR,
                'default' => 5
            ],
            [
                'title' => 'توانایی تکرار امتیاز دهی را دارد' ,
                'key' => EnumsOption::MEMBER_CAN_EDIT_VOTE,
                'default' => TRUE
            ],
            [
                'title' => 'فقط اعضا و میمهان توانایی امتیازدهی پست ها را دارند' ,
                'key' => EnumsOption::CAN_VOTE_POSTS,
                'default' => EnumsAuthunticate::type()
            ],
            [
                'title' => 'فقط اعضا و میهمان توانایی امتیازدهی برگه ها را دارند' ,
                'key' => EnumsOption::CAN_VOTE_PAGES,
                'default' => EnumsAuthunticate::type()
            ],
            [
                'title' => 'فقط اعضا و میهمان توانایی امتیازدهی محصولات را دارند' ,
                'key' => EnumsOption::CAN_VOTE_PRODUCTS,
                'default' => EnumsAuthunticate::type()
            ],
            [
                'title' => 'چه وضعیت های جدول پست میتواند امتیاز بگیرد' ,
                'key' => EnumsOption::VOTE_ITEMS_ENABLE,
                'default' => EnumsPost::type()
            ],
            [
                'title' => 'سربرگ فروشگاه' ,
                'key' => EnumsOption::SHOP_TITLE,
                'default' => NULL
            ],
            [
                'title' => 'توضیحات فروشگاه' ,
                'key' => EnumsOption::SHOP_DESCRIPTION,
                'default' => NULL
            ],
            [
                'title' => 'واحد ارزی' ,
                'key' => EnumsOption::SHOP_CURRENCY,
                'default' => NULL
            ],
            [
                'title' => 'چه وضعیت های جدول پست میتواند کامنت بگیرد' ,
                'key' => EnumsOption::CAN_COMMENT_POSTS,
                'default' => EnumsPost::type()
            ],
            [
                'title' => 'توانایی ریپلای کامنت وجود داشته باشد' ,
                'key' => EnumsOption::THREAD_COMMENTS,
                'default' => TRUE
            ],
            [
                'title' => 'حداکثر عمق برای کامنت ها چقدر باشد' ,
                'key' => EnumsOption::THREAD_COMMENTS_DEPTH,
                'default' => 4
            ],
            [
                'title' => 'برای کامنت دهی باید وارد حساب کاربری شوند' ,
                'key' => EnumsOption::COMMENT_REGISTRATION,
                'default' => FALSE
            ],
            [
                'title' => 'کامنت ها صفحه بندی شوند' ,
                'key' => EnumsOption::PAGE_COMMENTS,
                'default' => TRUE
            ],
            [
                'title' => 'حداکثر آیتم های کامنت در صفحه' ,
                'key' => EnumsOption::COMMENTS_PER_PAGE,
                'default' => 50
            ],
            [
                'title' => 'کامنت ها به چه صورتی مرتب گردند' ,
                'key' => EnumsOption::COMMENT_ORDER,
                'default' => EnumsSort::TYPE_ASC
            ],
            [
                'title' => 'بصورت پیشفرض کامنت ها چگونه مرتب شوند' ,
                'key' => EnumsOption::DEFAULT_COMMENTS_PAGE,
                'default' => EnumsSort::TYPE_ASC
            ],
            [
                'title' => 'نظارت بر روی نظرات' ,
                'key' => EnumsOption::COMMENT_MODERATION,
                'default' => TRUE
            ],
            [
                'title' => 'چه کسی میتواند نظرها را لایک کند' ,
                'key' => EnumsOption::CAN_LIKE_COMMENTS,
                'default' => EnumsAuthunticate::type()
            ],
            [
                'title' => 'توانایی لایک برای چه کسایی وجود دارد' ,
                'key' => EnumsOption::LIKE_ITEMS_ENABLE,
                'default' => EnumsSystem::type()
            ],
            [
                'title' => 'افراد میتوانند لایک های خود را عوض کنند' ,
                'key' => EnumsOption::MEMBER_CAN_EDIT_LIKE,
                'default' => TRUE
            ],
            [
                'title' => 'لوگو' ,
                'key' => EnumsOption::LOGO,
                'default' => NULL
            ],
            [
                'title' => 'فاوآیکون' ,
                'key' => EnumsOption::FAVICON,
                'default' => NULL
            ],
            [
                'title' => 'زبان دیفالت سیستم' ,
                'key' => EnumsOption::SYSTEM_DEFAULT_LANGUAGE,
                'default' => $languageDefault->id
            ],
            [
                'title' => 'واحد پولی دیفالت' ,
                'key' => EnumsOption::SYSTEM_DEFAULT_CURRENCY,
                'default' => $currencyDefault->id
            ],
        ]);
    }
}
