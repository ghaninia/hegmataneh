<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted'             => ':attribute باید پذیرفته شده باشد.',
    'active_url'           => 'آدرس :attribute معتبر نیست',
    'after'                => ':attribute باید یک تاریخ بعد :date باشد .',
    'after_or_equal'       => ':attribute باید بعد یا برابر تاریخ  :date باشد.',
    'alpha'                => ':attribute فقط باید حروف باشد.',
    'alpha_dash'           => ':attribute فقط باید حروف , عدد و خط تیره باشد. ',
    'alpha_num'            => ':attribute باید شامل حروف الفبا و عدد باشد.',
    'array'                => ':attribute باید شامل آرایه باشد.',
    'before'               => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal'      => 'تاریخ :attribute باید قبل یا برابر :date باشد.',
    'between'              => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file'    => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string'  => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array'   => ':attribute باید بین :min و :max آیتم باشد.',
    ],
    'boolean'              => ':attribute باید شامل true , false باشد.',
    'date'                 => ':attribute یک تاریخ معتبر نیست.',
    'date_format'          => ':attribute با الگوی :format مطاقبت ندارد.',
    'different'            => ':attribute و :other باید متفاوت باشند.',
    'digits'               => ':attribute باید :digits رقم باشد.',
    'digits_between'       => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions'           => ':attribute ابعاد تصویر نامعتبر است .',
    'distinct'             => ':attribute دارای مقدار تکراری است.',
    'email'                => ':attribute نشانی ایمیل نامعتبر است.',
    'exists'               => ':attribute انتخاب شده، معتبر نیست.',
    'file'                 => 'فیلد :attribute باید یک فایل بگیرد.',
    'filled'               => 'فیلد :attribute باید مقدار داشته باشد.',
    'image'                => ':attribute باید تصویر باشد.',
    'in'                   => ':attribute انتخاب شده، معتبر نیست.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute باید نوع داده ای عددی (integer) باشد.',
    'ip'                   => ':attribute باید IP آدرس معتبر باشد.',
    'ipv4'                 => 'فیلد  :attribute باید یک IPv4 معتبر باشد.',
    'ipv6'                 => 'فیلد :attribute باید یک IPv6 معتبر باشد.',
    'json'                 => ':attribute باید یک رشته معتبر json باشد .',
    'max'                  => [
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'file'    => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'string'  => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array'   => ':attribute نباید بیشتر از :max آیتم باشد.',
    ],
    'mimes'                => ':attribute باید یکی از فرمت های :values باشد.',
    'mimetypes'            => ':attribute باید یک فایل از نوع (:values) باشد .',
    'min'                  => [
        'numeric' => ':attribute نباید کوچکتر از :min باشد.',
        'file'    => ':attribute نباید کوچکتر از :min کیلوبایت باشد.',
        'string'  => ':attribute نباید کمتر از :min کاراکتر باشد.',
        'array'   => ':attribute نباید کمتر از :min آیتم باشد.',
    ],
    'not_in'               => ':attribute انتخاب شده، معتبر نیست.',
    'numeric'              => ':attribute باید شامل عدد باشد.',
    'present'              => ':attribute باید وجود داشته باشد !',
    'regex'                => ':attribute یک فرمت معتبر نیست',
    'required'             => ':attribute خالی است',
    'required_if'          => 'فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.',
    'required_unless'      => 'فیلد :attribute مورد نیاز است مگر اینکه :other در :values وجود داشته باشد.',
    'required_with'        => ':attribute الزامی است زمانی که :values موجود است.',
    'required_with_all'    => ':attribute الزامی است زمانی که :values موجود است.',
    'required_without'     => ':attribute الزامی است زمانی که :values موجود نیست.',
    'required_without_all' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'same'                 => ':attribute و :other باید مانند هم باشند.',
    'size'                 => [
        'numeric' => ':attribute باید برابر با :size باشد.',
        'file'    => ':attribute باید برابر با :size کیلوبایت باشد.',
        'string'  => ':attribute باید برابر با :size کاراکتر باشد.',
        'array'   => ':attribute باسد شامل :size آیتم باشد.',
    ],
    'string'               => ':attribute باید یک رشته باشد.',
    'timezone'             => ':attribute باید یک منطقه معتبر باشد.',
    'unique'               => ':attribute قبلا انتخاب شده است.',
    'uploaded'             => ':attribute آپلود نشد ! ',
    'url'                  => 'فرمت آدرس :attribute اشتباه است.',
    "Packages"              => " کد امنیتی مطابقت ندارد .",
    "mobile"               => " فرمت شماره همراه درست نمی باشد.",
    "color"                => "فرمت رنگ ورودی درست نمی باشد.",
    "vote"                 => "اعتبار ورودی امتیاز صحیح میباشد .",
    "price"                => "فرمت :attribute صحیح نمیباشد.",
    'captcha'     => "کد امنیتی صحیح نمیباشد.",
    'jdate' => ':attribute' . ' معتبر نمی باشد.',
    'jdate_equal' => ':attribute' . ' تاریخ شمسی برابر ' . ':fa-date' . ' نمی باشد.',
    'jdate_not_equal' => ':attribute' . ' تاریخ شمسی نامساوی ' . ':fa-date' . ' نمی باشد.',
    'jdatetime' => ':attribute' . '  معتبر نمی باشد.',
    'jdatetime_equal' => ':attribute' . ' تاریخ و زمان شمسی مساوی ' . ':fa-date' . ' نمی باشد.',
    'jdatetime_not_equal' => ':attribute' . ' تاریخ و زمان شمسی نامساوی ' . ':fa-date' . ' نمی باشد.',
    'jdate_after' => ':attribute' . ' تاریخ شمسی باید بعد از ' . ':fa-date' . ' باشد.',
    'jdate_after_equal' => ':attribute' . ' تاریخ شمسی باید بعد یا برابر از ' . ':fa-date' . ' باشد.',
    'jdatetime_after' => ':attribute' . ' تاریخ و زمان شمسی باید بعد از ' . ':fa-date' . ' باشد.',
    'jdatetime_after_equal' => ':attribute' . ' تاریخ و زمان شمسی باید بعد یا برابر از ' . ':fa-date' . ' باشد.',
    'jdate_before' => ':attribute' . ' تاریخ شمسی باید قبل از ' . ':fa-date' . ' باشد.',
    'jdate_before_equal' => ':attribute' . ' تاریخ شمسی باید قبل یا برابر از ' . ':fa-date' . ' باشد.',
    'jdatetime_before' => ':attribute' . ' تاریخ و زمان شمسی باید قبل از ' . ':fa-date' . ' باشد.',
    'jdatetime_before_equal' => ':attribute' . ' تاریخ و زمان شمسی باید قبل یا برابر از ' . ':fa-date' . ' باشد.',

    "national_code" => "فرمت کدملی صحیح نمی‌باشد.",
    "persian_char" => "فرمت تایپ فارسی صحیح نمی باشد.",

    "slug" => "فرمت لینک پیوند صخیح نمی باشد.",
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        "status" => "وضعیت" ,
        "comment_status" => "وضعیت دیدگاه" ,
        "vote_status" => "وضعیت امتیازدهی" ,
        "format" => "فرمت" ,
        "development" => "توسعه پذیری" ,
        "title" => "تیتر" ,
        "slug" => "لینک یکتا" ,
        "faq" => "دستورالعمل" ,
        "excerpt" => "خلاصه مطلب" ,
        "theme" => "پوسته" ,
        "published_at" => "زمان انتشار" ,
        "created_at" => "زمان ساخت" ,
        "links" => "لینک‌های پیوستی" ,
        "links.*" => "لینک‌ پیوستی" ,
        "attachments" => "فایل‌های پیوستی" ,
        "attachments.*" => "فایل پیوستی" ,
    ],

];
