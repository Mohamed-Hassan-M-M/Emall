<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property mixed expired_at
 * @property mixed offer
 * @property mixed description
 * @property mixed code
 * @property mixed started_at
 * @property mixed max_discount
 * @property mixed min_order
 * @property false|mixed for_only_one_time
 * @property false|mixed for_new_user
 * @method static orderBy(string $string, string $string1)
 * @method static find($id)
 */
class Coupon extends Model
{
    use hasFactory;
    use HasTranslations;
    public $translatable = ['description'];
    protected $fillable = [
        'code','description','is_activate','offer','started_at','expired_at'
    ];
          public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }
        return $attributes;
    }
}
