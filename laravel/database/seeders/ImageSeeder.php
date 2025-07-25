<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public static Collection $picturesHouses;
    public static Collection $picturesRooms;

    private function copyExampleData($type): Collection
    {
        $source = resource_path('seeder_data/image/' . $type);

        $destinationBase = 'images'; // in public disk

        $allFiles = File::allFiles($source); // rekursiv!

        $examplePicturesCollection  = collect();

        foreach ($allFiles as $file) {
            // Pfad relativ zum Quellordner
            $relativePath = str_replace($source . DIRECTORY_SEPARATOR, '', $file->getPathname());

            // Ziel in Storage: public/images/... (inkl. Unterordner)
            Storage::disk('public')->put(
                $destinationBase . '/' . $relativePath,
                File::get($file)
            );
            $size = explode(DIRECTORY_SEPARATOR, $relativePath)[0]; // Größe aus dem Pfad extrahieren
            $filename = explode(DIRECTORY_SEPARATOR, $relativePath)[1]; // Dateiname extrahieren
            // Füge die Datei zur Collection hinzu
            $examplePicturesCollection->push([
                'filename' => $filename,
                'size' => $size,
            ]);
        }

        return $examplePicturesCollection;
    }

    public function run(): void
    {
        //clear the storage folder
        Storage::disk('public')->deleteDirectory('images');
        self::$picturesHouses = $this->copyExampleData('houses');
        self::$picturesRooms = $this->copyExampleData('rooms');
    }
}
