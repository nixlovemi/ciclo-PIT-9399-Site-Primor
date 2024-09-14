<?php

namespace App\Models;

use App\Helpers\ApiResponse;
use App\Helpers\ModelValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Image;
use Illuminate\Support\Facades\File;

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
    public const DIFFICULTY_MUITO_DIFICIL = 'Muito Difícil';
    public const DIFFICULTIES = [
        self::DIFFICULTY_FACIL,
        self::DIFFICULTY_MODERADA,
        self::DIFFICULTY_DIFICIL,
        self::DIFFICULTY_MUITO_DIFICIL,
    ];

    private const PICTURE_FOLDER = DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR  . 'primor-v1' . DIRECTORY_SEPARATOR  . 'images';

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
        'active',
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
            if (!in_array($value, self::TYPES)) {
                $fail('O tipo da Receita não é válido');
            }
        }], 'Tipo');
        $validation->addField('difficulty', ['required', function ($attribute, $value, $fail) {
            if (!in_array($value, self::DIFFICULTIES)) {
                $fail('A dificuldade da Receita não é válida');
            }
        }], 'Dificuldade');
        $validation->addField('title', ['required', 'string', 'min:2', 'max:120'], 'Título');
        $validation->addField('slug', ['required', 'string', 'max:120', function ($attribute, $value, $fail) {
            if (!preg_match('/^[a-z][-a-z0-9]*$/', $value)) {
                $fail('O slug da Receita não é válido');
            }

            $Recipe = Recipe::where('slug', $value)->first();
            if ($Recipe !== null && $Recipe->id !== $this->id) {
                $fail('O slug da Receita já está em uso');
            }
        }], 'Slug');
        $validation->addField('thumb_url', ['sometimes', 'required', 'string', 'min:3'], 'Thumb URL');
        $validation->addField('banner_url', ['sometimes', 'required', 'string', 'min:3'], 'Banner URL');
        $validation->addField('time_str', ['required', 'string', 'min:2', 'max:12'], 'Tempo');
        $validation->addField('portions_str', ['required', 'string', 'min:2', 'max:12'], 'Porções');
        $validation->addField('active', ['required', 'filled', 'boolean'], 'Ativo');

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
    public static function fSave(Request $request): ApiResponse
    {
        // get model for insert or update
        $codedId = $request->input('f-cid');
        if (!empty($codedId)) {
            $Recipe = Recipe::getModelByCodedId($codedId);
            if ($Recipe === null) {
                return new ApiResponse(true, 'Receita não encontrada para edição');
            }
        } else {
            $Recipe = new Recipe();
        }
        $isEdit = $Recipe->id > 0;

        // validate images - only for new recipes
        if (!$isEdit && false === $request->has(['f-thumb-url', 'f-banner-url'])) {
            return new ApiResponse(true, 'As imagens da Receita são obrigatórias');
        }

        // form + validation
        $form = [
            'type' => $request->input('f-type') ?: '',
            'difficulty' => $request->input('f-difficulty') ?: '',
            'title' => $request->input('f-title') ?: '',
            'slug' => $request->input('f-slug') ?: '',
            'time_str' => $request->input('f-time-str') ?: '',
            'portions_str' => $request->input('f-portions-str') ?: '',
            'active' => ($request->input('f-active') !== '') ? $request->input('f-active'): '',
        ];

        // fill model
        $Recipe->fill($form);
        $validation = $Recipe->validateModel();
        if ($validation->isError()) {
            return $validation;
        }

        // all good, try to upload images
        if (!$isEdit && (!$request->file('f-thumb-url')?->isValid() || !$request->file('f-banner-url')?->isValid())) {
            return new ApiResponse(true, 'Ocorreu um problema no upload das imagens, tente novamente');
        }

        // thumb
        if ($request->file('f-thumb-url')?->isValid()) {
            $filePath = self::saveRecipeImg(
                $_FILES["f-thumb-url"],
                'receita-' . $Recipe->slug . '-thumb' . date('YmdHis')
            );
            if (null === $filePath) {
                return new ApiResponse(true, 'Ocorreu um problema no upload da Thumb, tente novamente');
            }

            $Recipe->thumb_url = $filePath;
        }

        // banner
        if ($request->file('f-banner-url')?->isValid()) {
            $filePath = self::saveRecipeImg(
                $_FILES["f-banner-url"],
                'receita-' . $Recipe->slug . '-banner' . date('YmdHis')
            );
            if (null === $filePath) {
                return new ApiResponse(true, 'Ocorreu um problema no upload da Thumb, tente novamente');
            }

            $Recipe->banner_url = $filePath;
        }

        // save model
        try {
            $Recipe->save();
            $Recipe->refresh();
        } catch (\Exception $e) {
            File::delete(
                public_path($Recipe->thumb_url),
                public_path($Recipe->banner_url)
            );
            return new ApiResponse(true, 'Ocorreu um problema ao salvar a Receita, tente novamente.');
        }

        // all good, return success
        $msg = $isEdit ? 'Receita atualizada com sucesso!' : 'Receita cadastrada com sucesso!';
        return new ApiResponse(false, $msg, [
            'Recipe' => $Recipe
        ]);
    }

    public static function saveRecipeImg(array $file, string $newFileNameWoExt): ?string
    {
        $originalFileName = basename($file["name"]);
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileName = $newFileNameWoExt . '.' . $fileExtension;
        $ret = move_uploaded_file(
            $file["tmp_name"],
            public_path(self::PICTURE_FOLDER) . DIRECTORY_SEPARATOR . $newFileName
        );
        if ($ret) {
            return self::PICTURE_FOLDER . DIRECTORY_SEPARATOR . $newFileName;
        }

        return null;
    }
    // ================
}
