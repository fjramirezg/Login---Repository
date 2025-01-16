<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * El nombre del modelo asociado al factory.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Contraseña predeterminada
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone_number' => $this->faker->optional()->phoneNumber(),
            'date_of_birth' => $this->faker->optional()->date('Y-m-d', '2005-01-01'),
            'profile_image' => $this->faker->optional()->imageUrl(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'last_login' => null, // Último inicio de sesión comienza como null
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Estado personalizado para usuarios activos.
     */
    public function active()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
}
