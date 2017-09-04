<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

declare(strict_types = 1);

namespace PH7\Tests\Image\Unsplash;

use PH7\Image\Unsplash;
use PHPUnit\Framework\TestCase;

class UnsplashTest extends TestCase
{
    public function testGetImageWithCustomParams(): void
    {
        $unsplash = new Unsplash();
        $unsplash->setWidth(750)
            ->setHeight(450)
            ->setQuality(90)
            ->setFit('max')
            ->setDevicePixelRatio(1)
            ->setAuto('compress')
            ->setImageId('photo-1462045504115-6c1d931f07d1');

        $expectedUrl = 'https://images.unsplash.com/photo-1462045504115-6c1d931f07d1?dpr=1&amp;auto=compress&amp;fit=max&amp;w=750&amp;h=450&amp;q=90';
        $this->assertSame($expectedUrl, $unsplash->getImage());
    }

    public function testGetImageWithDefaultParams(): void
    {
        $unsplash = new Unsplash();
        $unsplash->setImageId('photo-1462045504115-6c1d931f07d1');

        $expectedUrl = 'https://images.unsplash.com/photo-1462045504115-6c1d931f07d1?dpr=2&amp;auto=format&amp;fit=crop&amp;w=600&amp;h=400&amp;q=80';
        $this->assertSame($expectedUrl, $unsplash->getImage());
    }

    /**
     * @expectedException \PH7\Image\InvalidFitException
     */
    public function testGetImageWithInvalidFit(): void
    {
        $unsplash = new Unsplash();
        $unsplash->setFit('I am invalid arg');
    }

    /**
     * @expectedException \PH7\Image\InvalidAutoException
     */
    public function testGetImageWithInvalidAuto(): void
    {
        $unsplash = new Unsplash();
        $unsplash->setAuto('formattt');
    }
}