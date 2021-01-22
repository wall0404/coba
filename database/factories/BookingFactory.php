<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Workstation;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Location;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = new Carbon();
        $date->addDays(-7);
        $user_id = 1;
        $workstation_id = 1;

        $error = true;
        while($error) {
            try {
                $date->addDays(random_int(0, 21));
                $user_id = random_int(1,(User::all()->count()));
                $workstation_id = random_int(1,Workstation::all()->count());
            } catch (\Exception $e) {

            }
            $dayOfWeek = $date->dayOfWeek;

            $error = Booking::where('user_id', $user_id)->where('date', $date)->count() !== 0 || $dayOfWeek == 0 || $dayOfWeek == 6 ;
        }

        return [
            'user_id' => $user_id,
            'workstation_id' => $workstation_id,
            'date' => $date,
            'from' => '9:00',
            'to' => '17:00',
        ];
    }
}
