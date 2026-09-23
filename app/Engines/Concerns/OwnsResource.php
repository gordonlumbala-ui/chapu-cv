<?php

namespace App\Engines\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait OwnsResource
{
    protected function ensureOwnedBy(Model $resource, User $user, string $message = 'Resource not found.'): void
    {
        if ((int) $resource->user_id !== (int) $user->id) {
            throw new NotFoundHttpException($message);
        }
    }

    protected function ensureCvOwnedBy(User $user, int $cvId): void
    {
        $user->cvs()->findOrFail($cvId);
    }
}
