<?php

namespace App\Traits;

use Filament\Actions\DeleteAction;

trait NestedEditRecordTrait
{
    protected function configureDeleteAction(DeleteAction $action): void
    {
        $resource = static::getResource();
        $ancestor = $resource::getAncestor();

        if (! $ancestor) {
            parent::configureDeleteAction($action);

            return;
        }

        $ancestorResource = $ancestor->getResource();

        $action
            ->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(
                $resource::hasPage('index')
                    ? $resource::getUrl('index', [
                    ...$ancestor->getNormalizedRouteParameters($this->getRecord()),
                ])
                    : $ancestorResource::getUrl('view', [
                    ...$ancestor->getNormalizedRouteParameters($this->getRecord()),
                ])
            )
        ;
    }
}
