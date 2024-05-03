<?php

namespace Database\Seeders;

use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Guest;
use App\Models\GuestDocument;
use App\Models\Room;
use App\Models\RoomProperty;
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
        AdditionalService::factory()->create([
            'name' => 'Wi-Fi',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Air Conditioning',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Television',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Hair Dryer',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Iron',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Safe',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Mini-bar',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Kettle',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Extra Pillows or Blankets',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Alarm Clock',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Mini Refrigerator',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Press Conference Service',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Welcome Fruits or Snacks',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Laundry and Dry Cleaning Services',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Massage Chair',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Courier Services',
        ]);
        AdditionalService::factory()->create([
            'name' => 'Taxi or Airport Transfer Services',
        ]);

        RoomProperty::factory()->create([
            'name' => 'View on the Street',
        ]);
        $roles_list = ['admin', 'receptionist'];
        //Generate roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'receptionist']);
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => '',
        ]);
        $user->assignRole('admin');
    }

    /*public function run(): void
    {
        $config = [
            'user' => 10,
            'rooms' => 50,
            'room_properties' => 10,
            'employees' => 20,
            'guests' => 150,
            'bookings' => 100,
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
        //Generate employees
        Employee::factory($config['employees'])->create();
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
    }*/
}
