<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Pengaduan;

use DB;

class FixRegistrationNumber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::transaction(function () {
                $data = DB::table('pengaduan')->select([
                    'registration_number', 
                    DB::raw('EXTRACT(YEAR FROM complaint_date) as year'),
                    DB::raw('COUNT(registration_number)'),
                ])
                ->groupBy('registration_number', 'year')
                ->having(DB::raw('count(registration_number)'), '>', 1)
                ->get();
                
                foreach($data as $val){
                    for ($i=1; $i < $val->count; $i++) { 
                        $pengaduan = Pengaduan::where('registration_number', $val->registration_number)->where(
                            DB::raw('EXTRACT(YEAR FROM complaint_date)'),
                            $val->year
                        )->first();
                        $pengaduan->registration_number = DB::table('pengaduan')->where(
                            DB::raw('EXTRACT(YEAR FROM complaint_date)'
                        ), $val->year)->orderByRaw('registration_number::int desc')->pluck('registration_number')->first() + 1;
                        $pengaduan->save();
                    }
                }
            });
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
