<?php

/**
 * Lista fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Lista;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class ListaFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class ListaFixtures extends AbstractBaseFixtures
{
    /**
     * Loads sample data for the application.
     *
     * This method utilizes the Faker library to generate random data and populate
     * multiple 'Lista' entities. Each entity is assigned randomly generated
     * attributes including a unique title, creation date, and update date.
     *
     * Ensures the associated manager and Faker instance are properly initialized
     * before proceeding with the data creation.
     */
    public function loadData(): void
    {
        if (!$this->manager instanceof ObjectManager || !$this->faker instanceof Generator) {
            return;
        }

        $this->createMany(4, 'lista', function (int $i) {
            $lista = new Lista();
            $lista->setTitle($this->faker->unique()->word);
            $lista->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $lista->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            return $lista;
        });
    }
}
