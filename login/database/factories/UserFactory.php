<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 *
 * Clase UserFactory
 *
 * Esta clase se utiliza para generar instancias de la clase User
 * con datos de prueba para facilitar las pruebas y el desarrollo.
 */
class UserFactory extends Factory
{
    /**
     * La contraseña actual utilizada por la fábrica.
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Define el estado predeterminado del modelo.
     *
     * Este método genera un conjunto de atributos por defecto para el modelo User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),  // Genera un nombre aleatorio
            'email' => fake()->unique()->safeEmail(),  // Genera un email único y seguro
            'email_verified_at' => now(),  // Marca la fecha y hora actual como verificada
            'password' => static::$password ??= Hash::make('password'),  // Establece la contraseña, asegurándose de que sea la misma en todas las instancias
            'remember_token' => Str::random(10),  // Genera un token aleatorio para recordar la sesión
        ];
    }

    /**
     * Indica que la dirección de correo electrónico del modelo debe estar sin verificar.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,  // Establece el campo de verificación de email como nulo
        ]);
    }
}
