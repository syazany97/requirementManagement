<?php

namespace App\Console\Commands;

use App\Services\DeleteDemoUsersAction;
use Illuminate\Console\Command;

class DeleteDemoUsers extends Command
{
    protected $signature = 'delete:demo-users';

    protected $description = 'Delete demo users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return DeleteDemoUsersAction::execute();
    }
}
