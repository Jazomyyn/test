<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use App\Services\FormatPricesService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reservation
 *
 * @property int $id
 * @property float $total_price
 * @property int $quantity_person
 * @property Carbon $reservation_date
 * @property Carbon $activity_date
 * @property int $fk_id_activity
 * @property Activity $activity
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereActivityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereFkIdActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereQuantityPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereReservationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereTotalPrice($value)
 * @mixin \Eloquent
 */
class Reservation extends Model
{
	protected $table = 'reservations';
	public $timestamps = false;

	protected $casts = [
		'total_price' => 'float',
		'quantity_person' => 'int',
		'fk_id_activity' => 'int',
		'reservation_date' => 'date:Y-m-d',
		'activity_date' => 'date:Y-m-d'
	];

	protected $dates = [
		'reservation_date',
		'activity_date'
	];

	protected $fillable = [
		'total_price',
		'quantity_person',
		'reservation_date',
		'activity_date',
		'fk_id_activity'
	];
	protected $appends=[
        'format_total',
    ];


	public function activity()
	{
		return $this->belongsTo(Activity::class, 'fk_id_activity');
	}
	public function getFormatTotalAttribute(){
       return FormatPricesService::formatPrice($this->total_price);
    }
}
