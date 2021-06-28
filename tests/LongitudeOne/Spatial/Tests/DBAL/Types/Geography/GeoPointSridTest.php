<?php
/**
 * This file is part of the doctrine spatial extension.
 *
 * PHP 7.4 | 8.0
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com> 2017 - 2021
 * (c) Longitude One 2020 - 2021
 * (c) 2015 Derek J. Lambert
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace LongitudeOne\Spatial\Tests\DBAL\Types\Geography;

use LongitudeOne\Spatial\Exception\InvalidValueException;
use LongitudeOne\Spatial\PHP\Types\Geography\Point;
use LongitudeOne\Spatial\Tests\Fixtures\GeoPointSridEntity;
use LongitudeOne\Spatial\Tests\Helper\PersistHelperTrait;
use LongitudeOne\Spatial\Tests\OrmTestCase;

/**
 * Doctrine GeographyType tests.
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license https://dlambert.mit-license.org MIT
 *
 * @group srid
 *
 * @internal
 * @coversDefaultClass \LongitudeOne\Spatial\DBAL\Types\Geography\PointType
 */
class GeoPointSridTest extends OrmTestCase
{
    use PersistHelperTrait;

    /**
     * Setup the test.
     */
    protected function setUp(): void
    {
        $this->usesEntity(self::GEO_POINT_SRID_ENTITY);
        parent::setUp();
    }

    /**
     * Test a null geography.
     */
    public function testNullGeography()
    {
        $entity = new GeoPointSridEntity();
        static::assertIsRetrievableById($this->getEntityManager(), $entity);
    }

    /**
     * Test to store a geographic point.
     */
    public function testPointGeography()
    {
        $entity = new GeoPointSridEntity();

        try {
            $entity->setPoint(new Point(11, 11));
        } catch (InvalidValueException $e) {
            static::fail(sprintf('Unable to create a point (11 11): %s', $e->getMessage()));
        }
        $queryEntity = static::assertIsRetrievableById($this->getEntityManager(), $entity);
        static::assertEquals(4326, $queryEntity->getPoint()->getSrid());
    }

    //TODO test to find all null GeoPointSridEntity
}
