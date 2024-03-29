<?php

namespace App\Repositories;

use App\Models\Gallery;
use App\Models\VcardService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;

class GalleryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gallery::class;
    }

    /**
     * @param $input
     *
     * @return mixed
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();

            if ($input['type'] == Gallery::TYPE_IMAGE) {
                $input['link'] = null;
            }
            if ($input['type'] == Gallery::TYPE_YOUTUBE) {
                $input['image'] = null;
            }

            $gallery = Gallery::create($input);

            if (($input['type'] == Gallery::TYPE_IMAGE) && isset($input['image']) && ! empty($input['image'])) {
                $gallery->addMedia($input['image'])->toMediaCollection(Gallery::GALLERY_PATH,
                    config('app.media_disc'));
            }
            $gallery->update(['gallery_unique_number'=> getUniqueNumberGallery($gallery->id)]);


            DB::commit();

            return $gallery;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param array $input
     * @param int $id
     *
     * @return Builder|Builder[]|Collection|Model
     */
    public function update($input, $id)
    {
        try {
            DB::beginTransaction();

            if ($input['type'] == Gallery::TYPE_IMAGE) {
                $input['link'] = null;
            }
            if ($input['type'] == Gallery::TYPE_YOUTUBE) {
                $input['image'] = null;
            }

            $gallery = Gallery::findOrFail($id);
            if (($input['type'] == Gallery::TYPE_IMAGE)  && isset($input['image']) && ! empty($input['image'])) {
                $gallery->clearMediaCollection(Gallery::GALLERY_PATH);
                $gallery->addMedia($input['image'])->toMediaCollection(Gallery::GALLERY_PATH,
                    config('app.media_disc'));
            }

            $gallery->update($input);

            DB::commit();

            return $gallery;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
