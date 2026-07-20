<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Actions\GoogleDrive;

use Exception;
use Google\Client;
use Google\Service\Drive;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetGoogleDriveFilesAction
{
    use QueueableAction;

    /**
     * @return array<int, mixed>
     */
    public function execute(): array
    {
        $driveService = new Drive($this->makeClient());

        $filesResource = $driveService->files;
        if (! is_object($filesResource)) {
            return [];
        }

        if (! method_exists($filesResource, 'listFiles')) {
            return [];
        }

        $result = $filesResource->listFiles([
            'fields' => 'files(id, name, mimeType, modifiedTime, size)',
            'q' => "'root' in parents and trashed = false",
        ]);

        if (! is_object($result) || ! method_exists($result, 'getFiles')) {
            return [];
        }

        $filesList = $result->getFiles();
        if (! is_array($filesList)) {
            return [];
        }

        /** @var array<int, mixed> */
        return $filesList;
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

        $userClass = XotData::make()->getUserClass();
        Assert::isInstanceOf($user, $userClass);

        if (method_exists($user, 'getProviderField')) {
            $token = $user->getProviderField('google', 'token');
            if (is_string($token) || is_array($token)) {
                $client->setAccessToken($token);
            }
        }

        return $client;
    }
}
