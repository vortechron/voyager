<?php

namespace TCG\Voyager\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasMedia
{
    public function replaceMedia($field, $media, $disk = null)
    {
        if ($media instanceof UploadedFile)
            tap($this->$field, function ($previous) use ($field, $media, $disk) {
                $this->forceFill([
                    $field => $media->storePublicly(
                        $field,
                        ['disk' => $disk]
                    ),
                ])->save();

                if ($previous && $media) {
                    Storage::disk($disk)->delete($previous);
                }
            });
    }

    public function replaceMedias($field, $medias, $disk = null)
    {
        if (!is_array($medias)) return;

        $data = [];
        $fieldData = $this->$field;
        foreach ($medias as $index => $media) {
            $data[] = $media->storePublicly(
                $field,
                ['disk' => $disk]
            );

            if (isset($fieldData[$index])) {
                Storage::disk($disk)->delete($fieldData[$index]);
            }
        }

        if (!empty($medias)) $this->forceFill([$field => $data])->save();
    }

    public function getMediaAsUrl($field, $disk = null)
    {
        return $this->$field
            ? Storage::disk($disk)->url($this->$field)
            : null;
    }

    public function getMediasAsUrl($field, $disk = null)
    {
        $fieldAfter = $this->$field;

        // if null
        if (is_null($this->$field)) {
            return [];
        }

        if (is_string($this->$field)) {
            $fieldAfter = json_decode($this->$field);
        }

        $urls = [];
        foreach ($fieldAfter as $value) {
            $urls[] = $value ? Storage::disk($disk)->url($value)
                : null;
        }

        return $urls;
    }
}
