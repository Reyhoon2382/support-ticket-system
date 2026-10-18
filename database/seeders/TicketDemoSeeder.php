<?php

namespace Database\Seeders;

use App\Enums\DepartmentEnum;
use App\Enums\TicketStatusEnum;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('email', 'customer@example.com')->first();

        if(!$customer){
            return;
        }

        Ticket::create([
            'ticket_number' => 'TCK-' . strtoupper(Str::random(8)),
            'user_id' => $customer->id,
            'title' => 'Sample issue in prescription module',
            'description' => 'The prescription save button does not work on Safari browser.',
            'department' => DepartmentEnum::TECHNICAL->value,
            'status' => TicketStatusEnum::NEW->value,
            'priority' => 'high',
        ]);

        Ticket::create([
            'ticket_number' => 'TCK-' . strtoupper(Str::random(8)),
            'user_id' => $customer->id,
            'title' => 'Request for new report',
            'description' => 'Please add a daily report for registered prescriptions.',
            'department' => DepartmentEnum::SOFTWARE->value,
            'status' => TicketStatusEnum::UNDER_REVIEW->value,
            'priority' => 'normal',
        ]);
    }

}
