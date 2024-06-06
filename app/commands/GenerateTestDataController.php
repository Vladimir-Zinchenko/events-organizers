<?php

namespace app\commands;

use app\models\Event;
use app\models\Organizer;
use app\services\EventService;
use app\services\OrganizerService;
use Exception;
use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use Faker;

/**
 * Generate test data
 *
 * Class GenerateTestDataController
 */
class GenerateTestDataController extends Controller
{
    private readonly OrganizerService $organizerService;

    private readonly EventService $eventService;

    private readonly Faker\Generator $faker;

    /** @var Event[] */
    private array $events = [];

    /** @var Organizer[] */
    private array $organizers = [];

    public function __construct(
        string $id,
        Module $module,
        ?array $config,
        EventService $eventService,
        OrganizerService $organizerService
    ) {
        $this->eventService = $eventService;
        $this->organizerService = $organizerService;
        $this->faker = Faker\Factory::create();

        parent::__construct($id, $module, $config ?? []);
    }

    /**
     * Generate data
     *
     * @param int $eventsQuantity
     * @param int $organizersQuantity
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionIndex(int $eventsQuantity = 15, int $organizersQuantity = 30): int
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->generateEvents($eventsQuantity);
            $this->generateOrganizers($organizersQuantity);
            $this->appendOrganizersToEvent();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();

            throw $e;
        }

        return ExitCode::OK;
    }

    /**
     * @param int $quantity
     *
     * @return void
     *
     * @throws Exception
     */
    private function generateEvents(int $quantity): void
    {
        for ($i = 0; $i < $quantity; $i++) {
            $event = new Event();
            $this->events[] = $event;
            $data = [
                'title' => $this->faker->firstName,
                'date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
                'description' => $this->faker->paragraph,
            ];

            $this->eventService->save($event, $data);
        }
    }

    /**
     * @param int $quantity
     *
     * @return void
     *
     * @throws Exception
     */
    private function generateOrganizers(int $quantity): void
    {
        for ($i = 0; $i < $quantity; $i++) {
            $organizer = new Organizer();
            $this->organizers[] = $organizer;
            $data = [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'phone' => $this->faker->phoneNumber,
            ];

            $this->organizerService->save($organizer, $data);
        }
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    private function appendOrganizersToEvent(): void
    {
        foreach ($this->events as $event) {
            shuffle($this->organizers);

            $count = rand(1, 5);
            $organizers = array_slice($this->organizers, $count);
            $event->setOrganizers($organizers);

            $this->eventService->save($event);
        }
    }
}