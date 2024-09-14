<?php

namespace App\Models;

use App\Helpers\ApiResponse;
use App\Helpers\ModelValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RecipeIngredient extends Model
{
    use HasFactory, Notifiable;
    use \App\Traits\BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'recipe_id',
        'quantity',
        'description',
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
    protected $casts = [];

    protected $attributes = [];

    protected $appends = [
        'codedId',
    ];

    // relations
    public function recipe()
    {
        return $this->hasOne(
            Recipe::class, 'id',
            'recipe_id'
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
        $validation->addIdField(self::class, 'Ingredientes', 'id', 'ID');
        $validation->addIdField(Recipe::class, 'Receita', 'recipe_id', 'Receita', ['required']);
        $validation->addField('quantity', ['nullable', 'numeric', 'gt:0'], 'Quantidade');
        $validation->addField('description', ['required', 'string', 'min:1', 'max:80'], 'Ingrediente');

        return $validation->validate();
    }

    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

    public function setCreatedAtAttribute($value)
    {
        // to Disable created_at
    }
    // ===============

    // static functions
    // ================
}
