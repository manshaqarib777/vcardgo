<?php

namespace App\MediaLibrary;

use App\Models\User;
use App\Models\Vcard;
use App\Models\AboutUs;
use App\Models\Enquiry;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Template;
use App\Models\VcardBlog;
use App\Models\Testimonial;
use App\Models\VcardService;
use App\Models\FrontTestimonial;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case User::PROFILE;
                return str_replace('{PARENT_DIR}', User::PROFILE, $path);
            case Setting::PATH:
                return str_replace('{PARENT_DIR}', Setting::PATH, $path);
            case Vcard::PROFILE_PATH:
                return str_replace('{PARENT_DIR}', Vcard::PROFILE_PATH, $path);
            case Vcard::COVER_PATH:
                return str_replace('{PARENT_DIR}', Vcard::COVER_PATH, $path);
            case Vcard::ID_BACK:
                return str_replace('{PARENT_DIR}', Vcard::ID_BACK, $path);
            case Vcard::REGISTRATION_DRIVER_IMAGE:
                return str_replace('{PARENT_DIR}', Vcard::REGISTRATION_DRIVER_IMAGE, $path);
            case Vcard::ID_BACK2:
                return str_replace('{PARENT_DIR}', Vcard::ID_BACK2, $path);
            case Vcard::BARCODE:
                return str_replace('{PARENT_DIR}', Vcard::BARCODE, $path);
            case Vcard::QRCODE:
                return str_replace('{PARENT_DIR}', Vcard::QRCODE, $path);
            case Vcard::CATEGORYA:
                return str_replace('{PARENT_DIR}', Vcard::CATEGORYA, $path);
            case Vcard::CATEGORYB:
                return str_replace('{PARENT_DIR}', Vcard::CATEGORYB, $path);
            case Vcard::CATEGORYC:
                return str_replace('{PARENT_DIR}', Vcard::CATEGORYC, $path);
            case Vcard::CATEGORYD:
                return str_replace('{PARENT_DIR}', Vcard::CATEGORYD, $path);
            case Vcard::CATEGORYE:
                return str_replace('{PARENT_DIR}', Vcard::CATEGORYE, $path);
            case Enquiry::ENQUIRYURL:
                return str_replace('{PARENT_DIR}', Enquiry::ENQUIRYURL, $path);
            case VcardService::SERVICES_PATH:
                return str_replace('{PARENT_DIR}', VcardService::SERVICES_PATH, $path);
            case Gallery::GALLERY_PATH:
                return str_replace('{PARENT_DIR}', Gallery::GALLERY_PATH, $path);
            case Testimonial::TESTIMONIAL_PATH:
                return str_replace('{PARENT_DIR}', Testimonial::TESTIMONIAL_PATH, $path);
            case Template::TEMPLATE_PATH;
                return str_replace('{PARENT_DIR}', Template::TEMPLATE_PATH, $path);
            case Feature::PROFILE;
                return str_replace('{PARENT_DIR}', Feature::PROFILE, $path);
            case Setting::FRONTPATH;
                return str_replace('{PARENT_DIR}', Setting::FRONTPATH, $path);
            case FrontTestimonial::PATH:
                return str_replace('{PARENT_DIR}', FrontTestimonial::PATH, $path);
            case AboutUs::PATH:
                return str_replace('{PARENT_DIR}', AboutUs::PATH, $path);
            case Product::PRODUCT_PATH:
                return str_replace('{PARENT_DIR}', Product::PRODUCT_PATH, $path);
            case VcardBlog::BLOG_PATH:
                return str_replace('{PARENT_DIR}', VcardBlog::BLOG_PATH, $path);
            case 'default';
                return '';
        }
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}

