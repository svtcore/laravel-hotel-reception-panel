<?php

namespace Database\Seeders;

use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\CleaningLog;
use App\Models\Guest;
use App\Models\GuestDocument;
use App\Models\Room;
use App\Models\RoomProperty;
use App\Models\Staff;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $config = [
            'user' => 10,
            'rooms' => 100,
            'room_properties' => 10,
            'staff' => 20,
            'cleaning_logs' => 100,
            'guests' => 300,
            'bookings' => 350,
            'additional_services' => 5,
        ];
        $roles_list = ['admin', 'receptionist'];
        //Generate roles
        $admin_role = Role::create(['name' => 'admin']);
        $user_role = Role::create(['name' => 'receptionist']);
        //Generate users
        for ($i = 0; $i < $config['user']; $i++) {
            $user = User::factory()->create();
            $user->assignRole($roles_list[array_rand($roles_list)]);
            if (count($user->getRoleNames()) <= 0) print("Error while assign role with userID " + $i);
        }
        RoomProperty::factory($config['room_properties'])->create();
        //Generate rooms and proprties
        for ($i = 0; $i < $config['rooms']; $i++) {
            $room = Room::factory()->create();
            $room->room_properties()->attach(rand(1, $config['room_properties']));
        }
        //Generate stuff
        Staff::factory($config['staff'])->create();
        for ($i = 0; $i < $config['cleaning_logs']; $i++) {
            CleaningLog::factory()->create(['room_id' => rand(1, $config['rooms']), 'staff_id' => rand(1, $config['staff'])]);
        }
        //Generate guests
        for ($i = 0; $i < $config['guests']; $i++) {
            $guest = Guest::factory()->create();
            GuestDocument::factory()->create(['guest_id' => $guest['id']]);
        }
        //Generate bookings and services
        AdditionalService::factory($config['additional_services'])->create();
        for ($i = 0; $i < $config['bookings']; $i++) {
            $booking = Booking::factory()->create(['room_id' => rand(1, $config['rooms'])]);
            $booking->guests()->attach(rand(1, $config['guests']));
            $booking->additional_services()->attach(rand(1, $config['additional_services']));
        }
    }
}
