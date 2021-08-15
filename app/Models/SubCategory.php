<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static find(mixed $get)
 * @property mixed category_id
 * @property mixed description
 * @property mixed title
 */
class SubCategory extends Model {

    use HasFactory;
    use HasTranslations;

    public $translatable = ['title', 'description'];
    protected $fillable = [
        'title', 'description', 'category_id'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Category::class);
    }
     public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }
        return $attributes;
    }

}
