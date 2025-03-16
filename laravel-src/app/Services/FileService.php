<?php

namespace App\Services;

use App\Services\Files\FileInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileService
{
    /**
     * @param $folder
     * @param $file
     * @param array $options
     * @return array
     */
    public static function upload($folder, $file, array $options = []): array
    {
        $fileName = static::generateFileName($file, $options['convert_type_file'] ?? null);
        $filePath = Storage::putFileAs($folder, $file, $fileName, $options['visibility'] ?? null);
        $nameFile = $file->getClientOriginalName();

        // convert mime file
        if (!empty($options['convert_type_file'])) {
            $nameFile = mb_substr($nameFile, 0, mb_strpos($nameFile, '.')) . '.' . $options['convert_type_file'];
        }

        return [
            'name'      => $nameFile,
            'file_path' => $filePath,
        ];
    }

    /**
     * @param string $imagePath
     * @param int $width
     * @param int $height
     * @return bool|int
     * @throws Exception
     */
    protected static function resizeSvgImage(string $imagePath, int $width, int $height): bool|int
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->load($imagePath);
        $svg = $dom->documentElement;

        if (!$svg->hasAttribute('viewBox')) { // viewBox is needed to establish
            // userspace coordinates
            $pattern = '/^(\d*\.\d+|\d+)(px)?$/'; // positive number, px unit optional

            $interpretable = preg_match($pattern, $svg->getAttribute('width'), $width) &&
                preg_match($pattern, $svg->getAttribute('height'), $height);

            if ($interpretable) {
                $view_box = implode(' ', [0, 0, $width[0], $height[0]]);
                $svg->setAttribute('viewBox', $view_box);
            } else { // this gets sticky
                throw new Exception("viewBox is dependent on environment");
            }
        }

        $svg->setAttribute('width', $width);
        $svg->setAttribute('height', $height);

        return $dom->save($imagePath);
    }

    /**
     * @param $folder
     * @param array $files
     * @param array $options
     * @return array
     * @throws Exception
     */
    public static function uploads($folder, array $files = [], array $options = []): array
    {
        $filePathArr = [];
        foreach ($files as $file) {
            $filePathArr[] = static::upload($folder, $file, $options);
        }

        return $filePathArr;
    }

    /**
     * @param $filePath
     * @return string
     */
    public static function url($filePath): string
    {
        return resolve(FileInterface::class)->url($filePath);
    }

    /**
     * @param $file
     * @param null $fileType
     * @return string
     */
    public static function generateFileName($file, $fileType = null): string
    {
        return now()->timestamp . Str::uuid()->getHex() . '.' . ($fileType ?? $file->getClientOriginalExtension());
    }

    /**
     * @param $filePath
     * @return bool
     */
    public static function delete($filePath): bool
    {
        return Storage::delete($filePath);
    }

    public static function download($filePath, $fileName = null): StreamedResponse
    {
        return Storage::download($filePath, $fileName);
    }
}
