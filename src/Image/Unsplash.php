<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017, Pierre-Henry Soria. All Rights Reserved.
 * @license        MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

declare(strict_types = 1);

namespace PH7\Image;

class Unsplash
{
    public const DEFAULT_WIDTH = 600;
    public const DEFAULT_HEIGHT = 400;
    public const DEFAULT_QUALITY = 80;
    public const DEFAULT_DPR = 2;
    public const CROP_FIT = 'crop';
    public const MAX_FIT = 'max';
    public const FORMAT_AUTO_OPTION = 'format';
    public const COMPRESS_AUTO_OPTION = 'compress';
    public const ENHANCE_AUTO_OPTION = 'enhance';
    public const REDEYE_AUTO_OPTION = 'redeye';


    protected const API_URL = 'https://images.unsplash.com/';

    private const URL_PARAMS_SEPARATOR = '&amp;';

    private const FIT_FORMATS = [
        self::CROP_FIT,
        self::MAX_FIT
    ];

    private const AUTO_OPTIONS = [
        self::FORMAT_AUTO_OPTION,
        self::COMPRESS_AUTO_OPTION,
        self::ENHANCE_AUTO_OPTION,
        self::REDEYE_AUTO_OPTION
    ];

    /** @var string */
    private $imageId;

    /** @var string */
    private $fit = self::CROP_FIT;

    /** @var string */
    private $auto = self::FORMAT_AUTO_OPTION;

    /** @var int */
    private $width = self::DEFAULT_WIDTH;

    /** @var int */
    private $height = self::DEFAULT_HEIGHT;

    /** @var int */
    private $quality = self::DEFAULT_QUALITY;

    /** @var int */
    private $devicePixelRatio = self::DEFAULT_DPR;

    public function setWidth(int $width): Unsplash
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight(int $height): Unsplash
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @param string $fit
     *
     * @return Unsplash
     *
     * @throws InvalidFitException
     */
    public function setFit(string $fit): Unsplash
    {
        if (!in_array($fit, self::FIT_FORMATS)) {
            throw new InvalidFitException(sprintf('"%s" is an invalid fit. Must be either "crop" or "max".', $fit));
        }

        $this->fit = $fit;

        return $this;
    }

    public function setQuality(int $quality): Unsplash
    {
        $this->quality = $quality;

        return $this;
    }

    public function setDevicePixelRatio(int $devicePixelRatio): Unsplash
    {
        $this->devicePixelRatio = $devicePixelRatio;

        return $this;
    }

    public function setAuto(string $auto): Unsplash
    {
        if (!in_array($auto, self::AUTO_OPTIONS)) {
            throw new InvalidAutoException(sprintf('"%s" is an invalid option. Must be either "auto" or "compress".', $auto));
        }

        $this->auto = $auto;

        return $this;
    }

    public function setImageId(string $imageId): Unsplash
    {
        $this->imageId = $imageId;

        return $this;
    }

    public function getImage(): string
    {
        $imageUrl = self::API_URL . $this->imageId;

        $options = [
            'dpr' => $this->devicePixelRatio,
            'auto' => $this->auto,
            'fit' => $this->fit,
            'w' => $this->width,
            'h' => $this->height,
            'q' => $this->quality
        ];

        return $this->buildUrl($imageUrl, $options);
    }

    private function buildUrl(string $url, array $args): string
    {
        return $url . '?' . http_build_query($args, '', self::URL_PARAMS_SEPARATOR);
    }
}