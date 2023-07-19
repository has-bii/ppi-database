<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status_id' => $this->faker->numberBetween(1, 3),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'whatsapp' => $this->faker->phoneNumber(),
            'no_aktif' => $this->faker->phoneNumber(),
            'tc_kimlik' => $this->faker->randomNumber(9, true),
            'kimlik_exp' => $this->faker->date('Y-m-d', '+5 years'),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-19 years'),
            'kota_turki_id' => $this->faker->numberBetween(1, 3),
            'tahun_kedatangan' => $this->faker->year(),
            'universitas_turki_id' => $this->faker->numberBetween(1, 3),
            'jurusan_id' => $this->faker->numberBetween(1, 132),
            'jenjang_pendidikan' => $this->faker->randomElement(['Lise', 'S1', 'S2', 'S3']),
            'tahun_ke' => $this->faker->randomElement(['TÖMER', '1', '2', '3', '4', '5', '6']),
            'updated_at' => $this->faker->unixTime()
        ];
    }
}
