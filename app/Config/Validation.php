<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $loginRules = [
        'user_eposta' => [
            'rules' => 'required|valid_email|is_not_unique[user.user_eposta]',
            'errors' => [
                'required' => 'Bu alan boş bırakılamaz.',
                'valid_email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
                'is_not_unique' => 'Kullanıcı e-posta adresi veya şifre hatalı.'
            ]
        ],
        'user_password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Bu alan boş bırakılamaz.',
                'min_length' => 'Şifreniz 8 karakterden fazla olmalıdır.',
            ]
        ]
    ];

    public $signupRules = [
        'user_eposta' => [
            'rules' => 'required|valid_email|is_unique[user.user_eposta]',
            'errors' => [
                'required' => 'Bu alan boş bırakılamaz',
                'valid_email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
                'is_unique' => 'Lütfen sisteme kayıtlı olmayan bir e-posta adresi giriniz.'
            ]
        ],
        'user_password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Bu alan boş bırakılamaz.',
                'min_length' => 'Şifreniz 8 karakterden fazla olmalıdır.'
            ]
        ],
        'password_check' => [
            'rules' => 'required|min_length[8]|matches[user_password]',
            'errors' => [
                'required' => 'Bu alan boş bırakılamaz.',
                'matches' => 'Girilen şifreler eşleşmelidir.'
            ]
        ]
    ];
}
