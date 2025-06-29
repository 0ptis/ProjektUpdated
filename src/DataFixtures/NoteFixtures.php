<?php

/**
 * Note fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Note;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class NoteFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class NoteFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        if (!$this->manager instanceof ObjectManager || !$this->faker instanceof Generator) {
            return;
        }

        $this->createMany(100, 'note', function (int $i) {
            $note = new Note();
            $note->setTitle($this->faker->sentence);
            $note->setComment($this->faker->text);
            $note->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $note->setUpdatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $note->setCategory($this->getRandomReference('category', Category::class));
            $note->setAuthor($this->getRandomReference('admin', User::class));

            return $note;
        });
    }

    /**
     * Get dependencies.
     *
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
