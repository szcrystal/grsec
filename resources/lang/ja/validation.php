<?php  // resources/lang/ja/validation.php

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

    'accepted'             => ':attributeを承認して下さい。',
    'active_url'           => ':attributeは正しいURLではありません。',
    'after'                => ':attributeは:date以降の日付にして下さい。',
    'alpha'                => ':attributeは英字のみにして下さい。',
    'alpha_dash'           => ':attributeは英数字とハイフンのみにして下さい。',
    'alpha_num'            => ':attributeは英数字のみにして下さい。',
    'array'                => ':attributeは配列にして下さい。',
    'before'               => ':attributeは:date以前の日付にして下さい。',
    'between'              => [
        'numeric' => 'The :attributeは:min〜:maxまでにして下さい。',
        'file'    => 'The :attributeは:min〜:max KBまでのファイルにして下さい。',
        'string'  => 'The :attributeは:min〜:max文字にして下さい。',
        'array'   => 'The :attributeは:min〜:max個までにして下さい。',
    ],
    'boolean'              => ':attributeはtrueかfalseにして下さい。',
    'confirmed'            => ':attributeが確認用:attributeと一致していません。',
    'date'                 => ':attributeは正しい日付を入力して下さい。',
    //'date_format'          => ':attributeは":format"書式と一致していません。',
    'date_format'          => ':attributeは0000-00-00の書式で正しい数値を入力して下さい。',
    'different'            => ':attributeは:otherと違うものにして下さい。',
    'digits'               => ':attributeは:digits桁にして下さい。',
    'digits_between'       => ':attributeは:min〜:max桁にして下さい。',
    'email'                => ':attributeを正しい形式にして下さい。',
    'filled'               => ':attributeは必須です。',
    'exists'               => '登録された:attributeではないようです。',
    'image'                => ':attributeは画像にして下さい。',
    'in'                   => '選択された:attributeは正しくありません。',
    'integer'              => ':attributeは整数にして下さい。',
    'ip'                   => ':attributeを正しいIPアドレスにして下さい。',
    'max'                  => [
        'numeric' => ':attributeは:max以下にして下さい。',
        'file'    => ':attributeは:max KB以下のファイルにして下さい。.',
        'string'  => ':attributeは:max文字以下にして下さい。',
        'array'   => ':attributeは:max個以下にして下さい。',
    ],
    'mimes'                => ':attributeは:valuesタイプのファイルにして下さい。',
    'min'                  => [
        'numeric' => ':attributeは:min以上にして下さい。',
        'file'    => ':attributeは:min KB以上のファイルにして下さい。.',
        'string'  => ':attributeは:min文字以上にして下さい。',
        'array'   => ':attributeは:min個以上にして下さい。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'numeric'              => ':attributeは半角数字にして下さい。',
    'regex'                => ':attributeの書式が正しくありません。',
    'required'             => ':attributeは必須です。',
    'required_if'          => ':otherが:valueの時、:attributeは必須です。',
    'required_with'        => ':valuesの時、:attributeは必須です。',
    'required_with_all'    => ':valuesが存在する時、:attributeは必須です。',
    'required_without'     => ':attributeは必須です。',
    //'required_without'     => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same'                 => ':attributeと:otherは一致していません。',
    'size'                 => [
        'numeric' => ':attributeは:sizeにして下さい。',
        'file'    => ':attributeは:size KBにして下さい。.',
        'string'  => ':attribute:size文字にして下さい。',
        'array'   => ':attributeは:size個にして下さい。',
    ],
    'string'               => ':attributeは文字列にして下さい。',
    'timezone'             => ':attributeは正しいタイムゾーンを指定して下さい。',
    'unique'               => ':attributeが既に存在します。',
    'url'                  => ':attributeを正しい書式にして下さい。',
    'future'			   => ':attributeは現在より先の指定はできません。',
    'date_check'		   => ':attributeは正しい値を入力して下さい。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
            'passwords.user' => 'パスワード',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    	'email' => '「メールアドレス」', //for login register
        'user_id' => '「ユーザーID（メールアドレス）」', //for login
        'password' => '「パスワード」', //for login register
        'password_confirmation' => '「パスワードの確認」', 
        'name' => '「お名前」', // forお問い合わせ
        'email' => '「メールアドレス」',// forお問い合わせ
        
        'user.name' => '「氏名」',
        'user.hurigana' => '「フリガナ」',
        'user.email' => '「メールアドレス」',
        'user.tel_num' => '「電話番号」',
        'user.post_num' => '「郵便番号」',
        'user.prefecture' => '「都道府県」',
        'user.address_1' => '「住所1」',
        'user.address_2' => '「住所2」',
        'user.password' => '「パスワード」',
        'user.password_confirmation' => '「パスワードの確認」',
        
        'receiver.name' => '「配送先氏名」',
        'receiver.hurigana' => '「配送先フリガナ」',
        'receiver.email' => '「配送先メールアドレス」',
        'receiver.tel_num' => '「配送先電話番号」',
        'receiver.post_num' => '「配送先郵便番号」',
        'receiver.prefecture' => '「配送先都道府県」',
        'receiver.address_1' => '「配送先住所1」',
        'receiver.address_2' => '「配送先住所2」',
        
        
        
        
        'ask_category' => '「お問い合わせ種別」',
        //'name' => '「ユーザー名」',
        'email' => '「メールアドレス」',
        'context' => '「コメント」',
        'comment' => '「コメント」',
        'title' => '「タイトル」',
        
        'number' => '「商品番号」',
        'cate_id' => '「カテゴリー」',
        'dg_id' => '「配送区分」',
        'is_once' => '「同梱包可能」',
        'factor' => '「係数」',
        'price' => '「価格」',
        'cost_price' => '「仕入れ値」',
        'stock' => '「在庫」',
        'point_back' => '「ポイント」',
        'slug' => '「スラッグ」',
        'category' => '「カテゴリー」',
        'address' => '「所在地」',
        'sub_title' => '「サブタイトル」',
        'url_name' => '「リンク名」',
        'company_name' => '「企業名」',
        'org_date' => '「日付」',
        'date_y' => '「日付（年）」',
        'date_m' => '「日付（月）」',
        'date_d' => '「日付（日）」',
        'birth' => '「生年月日」',
        'set_date' => '「日付」',
        
        'capacity' => '「容量」',
        'admin_name' => '「管理者名」',
        'admin_email' => '「管理者メールアドレス」',
        'tax_per' => '「消費税率」',
        'sale_per' => '「割引率」',
        'kare_ensure' => '「枯れ保証日数」',
    ],

];
