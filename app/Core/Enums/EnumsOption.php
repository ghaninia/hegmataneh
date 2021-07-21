<?php

namespace App\Core\Enums;

use App\Core\Abstracts\Enum;

class EnumsOption extends Enum
{

    /**
     * برای ولیدیشن باید در کلاس
     * App\Http\Requests\Option\OptionUpdate
     * اقدام نمایید
     */

    ### سربرگ داشبورد
    const TITLE = "title";
    ### توضیحات داشبورد
    const DESCRIPTION  = "description";
    ### آیا بصورت خصوصی در بیاید
    const DASHBOARD_PRIVATE  = "dashboard_private";
    ### آیدی دیفالت کسی که میخواهد عضو شود
    const DASHBOARD_DEFAULT_REGISTER_ROLE  = "dashboard_default_register_role";
    ### آیا هر کسی میتواند لاگین کند
    const DASHBOARD_CAN_REGISTER  = "dashboard_can_register";
    ### کپی رایت داشبورد
    const DASHBOARD_FOOTER_COPYRIGHT  = "dashboard_footer_copyright";
    ### قوانین زمان ثبت نام
    const DASHBOARD_REGISTER_RULE  = "dashboard_register_rule";
    ### کپی رایت نوتیفیکیشن
    const NOTIFICATION_COPYRIGHT  = "notification_copyright";
    ###  زمانی که نوتیفکیشن زمان ثبت نام ثبت میشود
    const NOTIFICATION_CONFIRM_REGISTER  = "notification_confirm_register";
    ### سابجکت درخواست تایید ثبت نام
    const NOTIFICATION_CONFIRM_REGISTER_SUBJECT  = "notification_confirm_register_subject";
    ### توکن اینستاگرام
    const TOKEN_INSTAGRAM  = "token_instagram";
    ### متن سابسکرایب
    const SUBSCRIBE_TEXT  = "subscribe_text";
    ### آیدی گیتهاب برای معرفی
    const GITHUB_ACCOUNT  = "github_account";
    ### آیدی لینکدین برای معرفی
    const LINKDIN_ACCOUNT  = "linkdin_account";
    ### آیدی توییتر برای معرفی
    const TWITTER_ACCOUNT  = "twitter_account";
    ### آیدی جیمیل برای معرفی
    const GMAIL_ACCOUNT  = "gmail_account";
    ### آیدی تلگرام برای معرفی
    const TELEGRAM_ACCOUNT  = "telegram_account";
    ### آیدی اینستاگرام برای معرفی
    const INSTAGRAM_ACCOUNT  = "instagram_account";
    ### توضیحات کوتاه در مورد سایت
    const ABOUTE_US  = "aboute_us";
    ### آدرس محل سکونت
    const ADDRESS  = "address";
    ### آدرس ایمیل جهت پشتیبانی
    const SUPPORT_EMAIL  = "support_email";
    ### تلفن جهت پشتیبانی
    const SUPPORT_TELLPHONE  = "support_tellphone";
    ### شماره موبایل جهت پشتیبانی
    const SUPPORT_MOBILE  = "support_mobile";
    ### فکس جهت پشتیبانی
    const SUPPORT_FAX  = "support_fax";
    ### تعداد ستاره های امتیازدهی
    const COUNT_VOTE_STAR  = "count_vote_star";
    ### توانایی تکرار امتیاز دهی را دارد؟.
    const MEMBER_CAN_EDIT_VOTE  = "member_can_edit_vote";
    ### فقط اعضا و میمهان توانایی امتیازدهی پست ها را دارند
    const CAN_VOTE_POSTS  = "can_vote_posts";
    ### فقط اعضا و میهمان توانایی امتیازدهی برگه ها را دارند
    const CAN_VOTE_PAGES  = "can_vote_pages";
    ### فقط اعضا و میهمان توانایی امتیازدهی محصولات را دارند
    const CAN_VOTE_PRODUCTS  = "can_vote_products";
    ### چه وضعیت های جدول پست میتواند امتیاز بگیرد
    const VOTE_ITEMS_ENABLE  = "vote_items_enable";
    ### سربرگ فروشگاه
    const SHOP_TITLE  = "shop_title";
    ### توضیحات فروشگاه
    const SHOP_DESCRIPTION  = "shop_description";
    ### واحد ارزی
    const SHOP_CURRENCY  = "shop_currency";
    ### چه وضعیت های جدول پست میتواند کامنت بگیرد
    const CAN_COMMENT_POSTS  = "can_comment_posts";
    ### توانایی ریپلای کامنت وجود داشته باشد
    const THREAD_COMMENTS  = "thread_comments";
    ### حداکثر عمق برای کامنت ها چقدر باشد
    const THREAD_COMMENTS_DEPTH  = "thread_comments_depth";
    ### برای کامنت دهی باید وارد حساب کاربری شوند
    const COMMENT_REGISTRATION  = "comment_registration";
    ### کامنت ها صفحه بندی شوند
    const PAGE_COMMENTS  = "page_comments";
    ### حداکثر آیتم های کامنت در صفحه
    const COMMENTS_PER_PAGE  = "comments_per_page";
    ### کامنت ها به چه صورتی مرتب گردند
    const COMMENT_ORDER  = "comment_order";
    ### بصورت پیشفرض کامنت ها چگونه مرتب شوند
    const DEFAULT_COMMENTS_PAGE  = "default_comments_page";
    ### نظارت بر روی نظرات
    const COMMENT_MODERATION  = "comment_moderation";
    ### چه کسی میتواند نظرها را لایک کند
    const CAN_LIKE_COMMENTS  = "can_like_comments";
    ### توانایی لایک برای چه کسایی وجود دارد؟
    const LIKE_ITEMS_ENABLE  = "like_items_enable";
    ### افراد میتوانند لایک های خود را عوض کنند؟
    const MEMBER_CAN_EDIT_LIKE  = "member_can_edit_like";
    ### لوگو
    const LOGO  = "logo";
    ### فاوآیکون
    const FAVICON  = "favicon";
}
