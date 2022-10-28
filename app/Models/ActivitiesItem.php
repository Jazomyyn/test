<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivitiesItem
 *
 * @property int $id
 * @property int $fk_id_activity
 * @property int $fk_id_item
 * @property Activity $activity
 * @property Item $item
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitiesItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitiesItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitiesItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitiesItem whereFkIdActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitiesItem whereFkIdItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitiesItem whereId($value)
 * @mixin \Eloquent
 */
class ActivitiesItem extends Model
{
	protected $table = 'activities_items';
	public $timestamps = false;

	protected $casts = [
		'fk_id_activity' => 'int',
		'fk_id_item' => 'int'
	];

	protected $fillable = [
		'fk_id_activity',
		'fk_id_item'
	];

	public function activity()
	{
		return $this->belongsTo(Activity::class, 'fk_id_activity');
	}

	public function item()
	{
		return $this->belongsTo(Item::class, 'fk_id_item');
	}
}
