<?php

namespace App\Repository;

use App\Entity\Proyect;
use App\Entity\Task;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function createNewTask(object $taskData, Proyect $proyect): bool
    {

        if (!isset($taskData)) {
            return false;
        }
        if (!is_int($taskData->dedicated_hours) || !is_int($taskData->estimated_hours)) {
            return false;
        }
        $dedicatedHours = $taskData->dedicated_hours;
        $estimatedHours = $taskData->estimated_hours;

        $clasificationArr = ['new_tarea', 'to_do', 'in_progress', 'done'];
        $priorityArr = ['urgent', 'hight', 'important', 'moderate', 'low'];
        $clasification = intval($taskData->clasification);
        $priority = intval($taskData->priority);

        $newTask = new Task();
        $newTask
            ->setTitle($taskData->title)
            ->setDescription($taskData->description)
            ->setClasification($clasificationArr[$clasification])
            ->setPriority($priorityArr[$priority])
            ->setEstimatedHours($estimatedHours)
            ->setDedicatedHours($dedicatedHours)
            ->setDateInit(new DateTime('now'))
            ->setProyect($proyect);

        $this->save($newTask, true);
        $created = $this->findOneBy(
            [
                'id' => $newTask->getId(),
                'title' => $newTask->getTitle()
            ]
        );
        if (is_null($created)) {
            return false;
        }
        return true;
    }

    public function getTasksJSON(Proyect $proyect): array
    {
        $tasks = $this->findBy(
            ['proyect' => $proyect],
            ['id' => 'DESC']
        );

        $taskJSON = [];
        foreach ($tasks as $key => $task) {
            $taskJSON[] =
                [
                    'id' => $task->getId(),
                    'title' => $task->getTitle(),
                    'description' => $task->getDescription(),
                    'priority' => $task->getPRiority(),
                    'clasification' => $task->getClasification(),
                    'estimated_hours' => $task->getEstimatedHours(),
                    'dedicated_hours' => $task->getDedicatedHours(),
                    'date_init' => $task->getDateInit()->format('d/m/Y')
                ];
        }
        return $taskJSON;
    }
}
