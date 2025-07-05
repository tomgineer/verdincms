<?php namespace App\Controllers;

use App\Models\ActionsModel;
use CodeIgniter\API\ResponseTrait;

class Cron extends BaseController {

    use ResponseTrait;

/**
 * Executes automated cron tasks labeled as 'Auto'.
 *
 * This method is intended to be triggered from the command line (CLI) only.
 * It calls the `runCron()` method from the `ActionsModel` with the type 'Auto'.
 *
 * Access:
 * - CLI only. Returns a forbidden response if accessed via web.
 *
 * @return void
 */
public function doWork(): void {
    if (is_cli()) {
        (new ActionsModel())->runCron('Auto');
    } else {
        $this->failForbidden('This method can only be run from the command line.');
    }
}

/**
 * Executes the AI processing task from the command line.
 *
 * This method is intended to be triggered via a CLI cron job. It calls the
 * `runAI()` method of the `ActionsModel` to process AI prompts and store results.
 * If accessed through a web request, it returns a 403 Forbidden error.
 *
 * @return void
 */
public function ai(): void {
    if (is_cli()) {
        (new ActionsModel())->runAI();
    } else {
        $this->failForbidden('This method can only be run from the command line.');
    }
}

/**
 * Executes legacy automated cron tasks labeled as 'Legacy'.
 *
 * This method is also intended to be triggered from the command line (CLI) only.
 * It calls the `runCron()` method from the `ActionsModel` with the type 'Legacy'.
 *
 * Access:
 * - CLI only. Returns a forbidden response if accessed via web.
 *
 * @return void
 */
public function doWorkAll(): void {
    if (is_cli()) {
        (new ActionsModel())->runCron('Legacy');
    } else {
        $this->failForbidden('This method can only be run from the command line.');
    }
}

} // ─── End of Class ───

