<?php

namespace App\Models;

use App\Helpers\ApiResponse;
use App\Helpers\ModelValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Recipe extends Model
{
    use HasFactory, Notifiable;
    use \App\Traits\BaseModelTrait;

    public const TYPE_ALMOCO = 'Almoço';
    public const TYPE_SOBREMESA = 'Sobremesa';
    public const TYPE_LANCHE = 'Lanche';
    public const TYPE_JANTAR = 'Jantar';
    public const TYPES = [
        self::TYPE_ALMOCO,
        self::TYPE_SOBREMESA,
        self::TYPE_LANCHE,
        self::TYPE_JANTAR,
    ];

    public const DIFFICULTY_FACIL = 'Fácil';
    public const DIFFICULTY_MODERADA = 'Moderada';
    public const DIFFICULTY_DIFICIL = 'Difícil';
    public const DIFFICULTIES = [
        self::DIFFICULTY_FACIL,
        self::DIFFICULTY_MODERADA,
        self::DIFFICULTY_DIFICIL,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'difficulty',
        'title',
        'slug',
        'thumb_url',
        'banner_url',
        'time_str',
        'portions_str',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'active' => true,
    ];

    protected $appends = [
        'codedId',
    ];

    // relations
    public function ingredients()
    {
        return $this->hasMany(
            RecipeIngredient::class, 'recipe_id',
            'id'
        );
    }

    public function steps()
    {
        return $this->hasMany(
            RecipeStep::class, 'recipe_id',
            'id'
        );
    }
    // =========

    // class functions
    /**
     * https://laravel.com/docs/8.x/validation#available-validation-rules
     */
    public function validateModel(): ApiResponse
    {
        $validation = new ModelValidation($this->toArray());
        $validation->addIdField(self::class, 'Receita', 'id', 'ID');
        $validation->addField('type', ['required', function ($attribute, $value, $fail) {
            if (!in_array($value, Recipes::TYPES)) {
                $fail('O tipo da Receita não é válido');
            }
        }], 'Tipo');
        $validation->addField('difficulty', ['required', function ($attribute, $value, $fail) {
            if (!in_array($value, Recipes::DIFFICULTIES)) {
                $fail('A dificuldade da Receita não é válida');
            }
        }], 'Dificuldade');
        $validation->addField('title', ['required', 'string', 'min:2', 'max:120'], 'Título');
        $validation->addField('slug', ['required', 'string', function ($attribute, $value, $fail) {
            if (!preg_match('/^[a-z][-a-z0-9]*$/', $value)) {
                $fail('O slug da Receita não é válido');
            }
        }], 'Slug');
        $validation->addField('thumb_url', ['required', 'string', 'min:3'], 'Thumb URL');
        $validation->addField('banner_url', ['required', 'string', 'min:3'], 'Banner URL');
        $validation->addField('time_str', ['required', 'string', 'min:2', 'max:12'], 'Tempo');
        $validation->addField('portions_str', ['required', 'string', 'min:2', 'max:12'], 'Porções');

        return $validation->validate();
    }

    public function getThumbFullUrl(): string
    {
        // is not <<local>> file
        $hasHttp = strpos($this->thumb_url, 'https://') !== false || strpos($this->thumb_url, 'http://');
        if ($hasHttp) {
            return $this->thumb_url;
        }

        return url('/') . $this->thumb_url;
    }

    public function getBannerFullUrl(): string
    {
        // is not <<local>> file
        $hasHttp = strpos($this->banner_url, 'https://') !== false || strpos($this->banner_url, 'http://');
        if ($hasHttp) {
            return $this->banner_url;
        }

        return url('/') . $this->banner_url;
    }

    public function getSingleUrl(): string
    {
        return route('site.receitaSingle', ['slug' => $this->slug]);
    }
    // ===============

    // static functions
    // ================
}
