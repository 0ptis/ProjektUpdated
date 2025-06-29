<?php

/**
 * TaskList fixtures.
 */

namespace App\DataFixtures;

use App\Entity\TaskList;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class TaskListFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class TaskListFixtures extends AbstractBaseFixtures
{
    /**
     * Loads sample data for the application.
     */
    public function loadData(): void
    {
        if (!$this->manager instanceof ObjectManager || !$this->faker instanceof Generator) {
            return;
        }

        $this->createMany(4, 'task_list', function (int $i) {
            $taskList = new TaskList();
            $taskList->setTitle($this->faker->unique()->word);
            $taskList->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $taskList->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            return $taskList;
        });
    }
}
