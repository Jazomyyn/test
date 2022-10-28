<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @property int $id
 * @property string $name
 * @property Collection|ActivitiesItem[] $activities_items
 * @package App\Models
 * @property-read int|null $activities_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereName($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
	protected $table = 'items';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function activities_items()
	{
		return $this->hasMany(ActivitiesItem::class, 'fk_id_item');
	}
}
