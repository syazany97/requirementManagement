<?php

use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementPriority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirement_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $priorities = ['Highest', 'High', 'Low', 'Lowest'];

        foreach($priorities as $priority) {
            RequirementPriority::create([
                'name' => $priority
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirement_priorities');
    }
}
