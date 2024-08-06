<?php

namespace Spatie\LaravelPasskeys\Support;

use Spatie\LaravelPasskeys\Exceptions\InvalidActionClass;

class Config
{
    /**
     * @return class-string<\Spatie\LaravelPasskeys\Models\Passkey>
     */
    public static function getPassKeyModel(): string
    {
        // verify it's either our model or it extends it

        return config('passkeys.models.passkey');
    }

    /**
     * @return class-string<\Illuminate\Auth\Authenticatable>
     */
    public static function getAuthenticatableModel(): string
    {
        // TODO verify that the model is an instance of Authenticatable and that it uses the HasPasskeys trait

        return config('passkeys.models.authenticatable');
    }

    public static function getRelyingPartyName(): string
    {
        return config('passkeys.relying_party.name');
    }

    public static function getRelyingPartyId(): string
    {
        return config('passkeys.relying_party.id');
    }

    public static function getRelyingPartyIcon(): ?string
    {
        return config('passkeys.relying_party.icon');
    }

    public static function getAction(string $actionName, string $actionBaseClass): string
    {
        $actionClass = config("passkeys.actions.{$actionName}");

        self::ensureValidActionClass($actionName, $actionBaseClass, $actionClass);

       return config("passkeys.actions.{$actionName}");
    }

    protected static function ensureValidActionClass
    (string $actionName, string $actionBaseClass, string $actionClass): void
    {
        if (! is_a($actionClass, $actionBaseClass, true)) {
            throw InvalidActionClass::make($actionName, $actionBaseClass, $actionClass);
        }
    }
}
