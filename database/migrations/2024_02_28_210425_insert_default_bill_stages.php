<?php

use App\Models\BillStage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private $billStages;

    public function __construct()
    {
        $this->billStages = [

            [
                'label' => 'Draft',
                'color_name' => 'gray',
                'order' => '1',
            ],
            [
                'label' => 'Submitted',
                'color_name' => 'cyan',
                'order' => '2',
            ],
            [
                'label' => 'Approved',
                'color_name' => 'green',
                'order' => '3',
            ],
            [
                'label' => 'Paying',
                'color_name' => 'fuschia',
                'order' => '4',
            ],
            [
                'label' => 'On Hold',
                'color_name' => 'orange',
                'order' => '5',
            ],
            [
                'label' => 'Rejected',
                'color_name' => 'red',
                'order' => '6',
            ],
            [
                'label' => 'Paid',
                'color_name' => 'purple',
                'order' => '7',
            ],

        ];

    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->billStages as $stage) {
            BillStage::create($stage);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('bill_stages')->truncate();
    }
};
