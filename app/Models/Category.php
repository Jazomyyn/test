<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property Collection|Activity[] $activities
 * @package App\Models
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
	const BEACH = 1,
		  FOREST = 2,
		  PARK = 3;

	protected $table = 'categories';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function activities()
	{
		return $this->hasMany(Activity::class, 'fk_id_category');
	}
}
