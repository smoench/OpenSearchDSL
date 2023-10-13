<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Serializer;

use OpenSearchDSL\SearchEndpoint\AbstractSearchEndpoint;
use OpenSearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;

/**
 * Custom serializer which orders data before normalization.
 */
class OrderedSerializer
{
    public function normalize(mixed $data): mixed
    {
        $data = is_array($data) ? $this->order($data) : $data;

        if (is_iterable($data)) {
            foreach ($data as $key => $value) {
                if ($value instanceof AbstractSearchEndpoint) {
                    $normalize = $value->normalize();

                    if ($normalize !== null) {
                        $data[$key] = $normalize;
                    } else {
                        unset($data[$key]);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Orders objects if can be done.
     *
     * @param array $data Data to order.
     *
     * @return array
     */
    private function order(array $data)
    {
        $filteredData = $this->filterOrderable($data);

        if (! empty($filteredData)) {
            uasort(
                $filteredData,
                fn (OrderedNormalizerInterface $a, OrderedNormalizerInterface $b) => $a->getOrder() <=> $b->getOrder()
            );

            return array_merge($filteredData, array_diff_key($data, $filteredData));
        }

        return $data;
    }

    /**
     * Filters out data which can be ordered.
     *
     * @param array $array Data to filter out.
     *
     * @return array
     */
    private function filterOrderable($array)
    {
        return array_filter(
            $array,
            fn ($value) => $value instanceof OrderedNormalizerInterface
        );
    }
}
