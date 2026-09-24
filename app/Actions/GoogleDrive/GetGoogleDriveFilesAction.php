<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Actions\GoogleDrive;

use Exception;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\FileList;
use Google\Service\Drive\Resource\Files as DriveFilesResource;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type GoogleDriveFileRow array{
 *     id: string,
 *     name: string,
 *     mimeType: string,
 *     modifiedTime: string|null,
 *     size: string|null,
 *     webViewLink: string|null
 * }
 */
class GetGoogleDriveFilesAction
{
    use QueueableAction;

    /**
     * @return list<GoogleDriveFileRow>
     */
    public function execute(): array
    {
        $filesResource = (new Drive($this->makeClient()))->files;
        Assert::isInstanceOf($filesResource, DriveFilesResource::class);

        $result = $filesResource->listFiles([
            'fields' => 'files(id, name, mimeType, modifiedTime, size, webViewLink)',
            'q' => "'root' in parents and trashed = false",
        ]);
        Assert::isInstanceOf($result, FileList::class);

        $filesList = $result->getFiles();
        if (! is_array($filesList)) {
            return [];
        }

        $files = [];
        foreach ($filesList as $file) {
            if (! $file instanceof DriveFile) {
                continue;
            }

            $id = $file->getId();
            $name = $file->getName();
            $mimeType = $file->getMimeType();
            Assert::string($id);
            Assert::string($name);
            Assert::string($mimeType);

            $modifiedTime = $file->getModifiedTime();
            $size = $file->getSize();
            $webViewLink = $file->getWebViewLink();

            $files[] = [
                'id' => $id,
                'name' => $name,
                'mimeType' => $mimeType,
                'modifiedTime' => is_string($modifiedTime) ? $modifiedTime : null,
                'size' => is_string($size) ? $size : null,
                'webViewLink' => is_string($webViewLink) ? $webViewLink : null,
            ];
        }

        return $files;
    }

    private function makeClient(): Client
    {
        $client = new Client;
        Assert::string($clientId = config('services.google.client_id'));
        Assert::string($clientSecret = config('services.google.client_secret'));
        Assert::string($redirect = config('services.google.redirect'));
        Assert::isArray($scopes = config('services.google.scopes'));

        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirect);
        $client->setScopes($scopes);
        $client->setAccessType('offline');

        $user = auth()->user();
        if ($user === null) {
            throw new Exception('Utente non autenticato');
        }

        Assert::isInstanceOf($user, UserContract::class);

        if (method_exists($user, 'getProviderField')) {
            $token = $user->getProviderField('google', 'token');
            if (is_string($token) || is_array($token)) {
                $client->setAccessToken($token);
            }
        }

        return $client;
    }
}
