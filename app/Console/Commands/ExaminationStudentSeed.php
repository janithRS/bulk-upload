<?php

namespace App\Console\Commands;

use App\Http\Controllers\ExaminationStudentsController;
use App\Models\Upload;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExaminationStudentSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'examination:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to seed from  the examination data (csv) to sis deticated examination table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln('###########################################------Inserting file records------###########################################');
//        ExaminationStudentsController::importCsvToDb();
        $files = $this->getFiles();
        $output->writeln('###########################################------Finished inserting file records------###########################################');
    }

    protected function getFiles(){
        $files = DB::table('exam_students_upload')
            ->where('db_status','=',0)
            ->where('nsid_status','=',0)
//            ->where('updated_at', '<=', Carbon::now()->tz('Asia/Colombo')->subHours(3))
            ->limit(1)
            ->get()->toArray();
        if(!empty($files)){
            DB::beginTransaction();
            DB::table('exam_students_upload')
                ->where('id', $files[0]->id)
                ->update(['db_status' => 1,'updated_at' => now()]);
            DB::commit();
        }
        return $files;
    }
}
