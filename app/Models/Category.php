<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static find($id)
 * @property mixed title
 * @property mixed image_url
 * @property mixed description
 */
class Category extends Model {

    use hasFactory;
    use HasTranslations;

    public $translatable = ['title', 'description'];
    protected $fillable = [
        'title', 'description', 'image_url'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function subCategories() {
        return $this->hasMany(SubCategory::class);
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
