<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class SetupMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:setupMeilisearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Meilisearch indexes and fields.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Dispatcher $events)
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $classes = [
            \App\Models\Template::class,
        ];

        foreach ($classes as $class) {
            $obj       = (new $class());
            $indexName = $obj->searchableAs();
            $index     =  $client->index($indexName);
            try {
                $index->fetchInfo();
            } catch (ApiException $e) {
                if (str_contains($e->message, 'not found')) {
                    $client->createIndex($indexName, ['primaryKey' => $obj->getKeyName()]);
                } else {
                    throw $e;
                }
            }
            $index->updateSearchableAttributes($obj->searchable);
            $index->updateFilterableAttributes($obj->filterable);
            $index->updateSortableAttributes($obj->sortable);
        }
    }
}
