<?php


namespace App\model\common\utils;


use App\model\dal\metadata\MemberMetadata;
use Nette\Database\Table\ActiveRow;

/**
 * Class MemberUtils
 *
 * Util methods concerning the entity Member
 *
 * @package App\model\common\utils
 */
class MemberUtils
{
    const dummyImageGeneratorUrl = "https://dummyimage.com/512x512/";

    /**
     * Resolves member's name to be displayed in several places throughout the application
     *
     * @param ActiveRow $memberEO member entity object
     * @return string the name to be displayed
     */
    static function resolveDisplayName(ActiveRow $memberEO): string
    {
        return $memberEO[MemberMetadata::$firstName] . " " . $memberEO[MemberMetadata::$lastName];
    }

    /**
     * Resolves url of an image of a member - either google image or a generated dummy image
     *
     * @param ActiveRow $memberEO member entity object
     * @return string url of the member's image
     */
    static function resolveMemberImage(ActiveRow $memberEO): string
    {
        $googleImage = $memberEO[MemberMetadata::$googleImage];
        if(!is_null($googleImage)) {
            return $googleImage;
        }
        $firstLetter = substr($memberEO[MemberMetadata::$firstName], 0, 1);
        $secondLetter = substr($memberEO[MemberMetadata::$lastName], 0, 1);
        $color = sprintf('%02X%02X%02X', mt_rand(125, 256), mt_rand(125, 256), mt_rand(125, 256));
        return self::dummyImageGeneratorUrl . $color . "?text=" . $firstLetter . $secondLetter;
    }
}