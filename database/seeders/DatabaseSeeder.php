<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
           'name' => 'Test',
            'email' => 'test@example.com',
            'password'=>'test',
        ]);

        $address =  DB::table('addresses')->insert([
          'exterior_number' => '15',
          'interior_number' => '15A',
          'zip'=>'77777',
          'street_name'=>'Street 34',
          'reference'=>'Library OpenBook',
        ]);

        $editorial =  DB::table('editorials')->insert([
          'name' => 'Test',
          'address_id' => $address,
        ]);

        $author =  DB::table('authors')->insert([
          'name' => 'Test',
          'email' => 'test@example.com',
          'last_name' => 'Test',
          'phone' => '1234567',
          'editorial_id' => $editorial,
        ]);

        $book =  DB::table('books')->insert([
          'name' => 'Test',
          'description' => 'Test Book',
          'page_numbers' => 50,
          'editorial_id' => $editorial,
          'author_id' => $author,
        ]);

        $library =  DB::table('libraries')->insert([
          'name' => 'Test',
          'address_id' => $address,
        ]);

        DB::table('libraries_books')->insert([
          'book_id' => $book,
          'library_id' => $library,
        ]);

    }
}
