<?php
// 代码生成时间: 2025-08-18 00:01:45
class Scheduler extends Phalcon\CLI\Task
{
    /**
     * The schedule of tasks.
     *
     * @var array
     */
    protected $schedule = [];

    /**
     * The constructor.
     * It sets up the schedule with tasks and their respective times.
     */
    public function __construct()
    {
        // Define your tasks and their execution times here
        $this->schedule = [
            'task1' => '* * * * *', // Run task1 every minute
            'task2' => '0 * * * *'  // Run task2 every hour at the 0th minute
        ];
    }

    /**
     * Main method to run the scheduler.
     * It checks if the current time matches the scheduled time and executes the task.
     */
    public function mainAction()
    {
        foreach ($this->schedule as $task => $time) {
            if ($this->isDue($time)) {
                $this->runTask($task);
            }
        }
    }

    /**
     * Checks if it's time to run a scheduled task.
     *
     * @param string $time The scheduled time for the task.
     * @return bool Returns true if it's time to run the task, false otherwise.
     */
    protected function isDue($time)
    {
        // Convert the cron expression to a DateTime string
        $cronTime = Cron\CronExpression::factory($time);

        // Get the next due time for the task
        $nextRun = $cronTime->getNextRunDate()->format('Y-m-d H:i:s');

        // Compare the next run time with the current time
        return $nextRun <= date('Y-m-d H:i:s');
    }

    /**
     * Runs a task based on its name.
     *
     * @param string $taskName The name of the task to run.
     */
    protected function runTask($taskName)
    {
        // Check if the task exists and is callable
        if (method_exists($this, $taskName) && is_callable([$this, $taskName])) {
            // Run the task
            $this->$taskName();
        } else {
            // Handle the error if the task doesn't exist or isn't callable
            $this->console->write('Error: Task ' . $taskName . ' does not exist or is not callable.
');
        }
    }

    /**
     * Example task to be scheduled.
     */
    protected function task1()
    {
        // Task logic goes here
        $this->console->write('Task 1 is running...
');
    }

    /**
     * Another example task to be scheduled.
     */
    protected function task2()
    {
        // Task logic goes here
        $this->console->write('Task 2 is running...
');
    }
}
