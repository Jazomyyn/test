<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use App\Services\FormatPricesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon $init_date
 * @property Carbon $finish_date
 * @property float $unit_price
 * @property int $popularity
 * @property string $image
 * @property bool $active
 * @property int $fk_id_category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Category $category
 * @property Collection|ActivitiesItem[] $activities_items
 * @property Collection|Reservation[] $reservations
 * @package App\Models
 * @property-read int|null $activities_items_count
 * @property-read int|null $reservations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereFinishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereFkIdCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereInitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity wherePopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
	protected $table = 'activities';

	protected $casts = [
		'unit_price' => 'float',
		'popularity' => 'int',
		'active' => 'bool',
		'fk_id_category' => 'int',
		'init_date' => 'date:Y-m-d',
		'finish_date' => 'date:Y-m-d'
		
	];


	protected $dates = [
		'init_date',
		'finish_date'
	];

	protected $fillable = [
		'title',
		'description',
		'init_date',
		'finish_date',
		'unit_price',
		'popularity',
		'image',
		'active',
		'fk_id_category'
	];

	protected $appends=[
        'format_total',
    ];

	public function category()
	{
		return $this->belongsTo(Category::class, 'fk_id_category');
	}

	public function activities_items()
	{
		return $this->hasMany(ActivitiesItem::class, 'fk_id_activity');
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class, 'fk_id_activity');
	}

	public function getFormatTotalAttribute(){
		return FormatPricesService::formatPrice($this->unit_price);
	 }
}
