<?php

declare(strict_types=1);
// File: Laravel/Modules/CloudStorage/Services/GoogleDriveService.php

namespace Modules\CloudStorage\Services;

use Modules\Xot\Datas\XotData;
use Exception;
use Google\Client;
use Google\Service\Drive;
use Webmozart\Assert\Assert;

class GoogleDriveService
{
    protected Client $client;

    protected Drive $driveService;

    public function __construct()
    {
        // @var mixed client = new Client;
        Assert::string($client_id = config('services.google.client_id'));
        Assert::string($client_secret = config('services.google.client_secret'));
        Assert::string($redirect = config('services.google.redirect'));
        Assert::isArray($scopes = config('services.google.scopes'));

        // @var mixed client->setClientId($client_id;
        // @var mixed client->setClientSecret($client_secret;
        // @var mixed client->setRedirectUri($redirect;
        // @var mixed client->setScopes($scopes;
        // @var mixed client->setAccessType('offline';

        $user = auth()->user();
        if ($user === null) {
            throw new Exception('Utente non autenticato');
        }

        // Usa XotData per ottenere la classe utente corretta
        $userClass = XotData::make()->getUserClass();
        Assert::isInstanceOf($user, $userClass);

        // Type narrowing per il metodo getProviderField
        if (method_exists($user, 'getProviderField')) {
            $token = $user->getProviderField('google', 'token');
            if (is_string($token) || is_array($token)) {
                // @var mixed client->setAccessToken($token;
            }
        }

        // @var mixed driveService = new Drive($this->client;
    }

    /**
     * Summary of getFiles.
     *
     * @return array<int, mixed>
     */
    public function getFiles(): array
    {
        $filesResource = // @var mixed driveService->files;
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
}
