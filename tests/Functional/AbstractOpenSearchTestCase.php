<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Functional;

use Exception;
use OpenSearch\Client;
use OpenSearch\ClientBuilder;
use OpenSearchDSL\Search;
use PHPUnit\Framework\TestCase;

abstract class AbstractOpenSearchTestCase extends TestCase
{
    /**
     * Test index name in the opensearch.
     */
    public const INDEX_NAME = 'opensearch-dsl-test';

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = ClientBuilder::create()->build();
        $this->deleteIndex();

        $bulkBody = [];
        foreach ($this->getDataArray() as $type => $documents) {
            $index = self::INDEX_NAME . '_' . $type;
            $this->client->indices()->create(
                array_filter(
                    [
                        'index' => $index,
                        'mapping' => $this->getMapping(),
                    ]
                )
            );

            foreach ($documents as $id => $document) {
                $bulkBody[] = [
                    'index' => [
                        '_index' => $index,
                        '_id' => $id,
                    ],
                ];
                $bulkBody[] = $document;
            }
        }

        $this->client->bulk(
            [
                'body' => $bulkBody,
            ]
        );
        $this->client->indices()->refresh();
    }

    /**
     * Defines index mapping for test index.
     * Override this function in your test case and return array with mapping body.
     * More info check here: https://goo.gl/zWBree
     *
     * @return array Mapping body
     */
    protected function getMapping()
    {
        return [];
    }

    /**
     * Can be overwritten in child class to populate opensearch index with the data.
     *
     * Example:
     *      [
     *          'type_name' => [
     *              'custom_id' => [
     *                  'title' => 'foo',
     *              ],
     *              3 => [
     *                  '_id' => 2,
     *                  'title' => 'bar',
     *              ]
     *          ]
     *      ]
     * Document _id can be set as it's id.
     *
     * @return array
     */
    protected function getDataArray()
    {
        return [];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->deleteIndex();
    }

    /**
     * Execute search to the opensearch and handle results.
     *
     * @param Search $search Search object.
     * @param string $type Type to search.
     * @param bool $returnRaw Return raw response from the client.
     * @return array
     */
    protected function executeSearch(Search $search, string $type, bool $returnRaw = false)
    {
        $response = $this->client->search(
            array_filter([
                'index' => self::INDEX_NAME . '_' . $type,
                'body' => $search->toArray(),
            ])
        );

        if ($returnRaw) {
            return $response;
        }

        $documents = [];

        try {
            foreach ($response['hits']['hits'] as $document) {
                $documents[$document['_id']] = $document['_source'];
            }
        } catch (Exception) {
            return $documents;
        }

        return $documents;
    }

    /**
     * Deletes index from opensearch.
     */
    private function deleteIndex()
    {
        try {
            $this->client->indices()->delete([
                'index' => self::INDEX_NAME . '*',
            ]);
        } catch (Exception) {
            // Do nothing.
        }
    }
}
