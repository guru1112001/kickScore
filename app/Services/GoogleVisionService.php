<?php
namespace App\Services;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Storage;

class GoogleVisionService
{
    public function isSafe($imagePath)
    {
        try {
            // Log the credentials path for debugging
            \Log::info('GOOGLE_APPLICATION_CREDENTIALS: ' . env('GOOGLE_APPLICATION_CREDENTIALS'));

            $client = new ImageAnnotatorClient([
                'credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),
            ]);
            
            // Read the image file
            $imageData = file_get_contents(Storage::disk('public')->path($imagePath));
            if ($imageData === false) {
                \Log::error('Failed to read image file: ' . $imagePath);
                return false;
            }

            // Perform safe search detection
            $response = $client->safeSearchDetection($imageData);
            $safe = $response->getSafeSearchAnnotation();

            // Get safety ratings (1–5 scale)
            $adult = $safe->getAdult();
            $violence = $safe->getViolence();
            $racy = $safe->getRacy();

            // Log the results for debugging
            \Log::info('Safe search results', [
                'adult' => $adult,
                'violence' => $violence,
                'racy' => $racy,
            ]);

            // Close the client
            $client->close();

            // Adjust safety threshold: reject if any rating is 2 or higher
            return !in_array($adult, [2, 3, 4, 5]) && !in_array($violence, [2, 3, 4, 5]) && !in_array($racy, [2, 3, 4, 5]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Google Vision API error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false; // Return false to reject the photo if an error occurs
        }
    }
}