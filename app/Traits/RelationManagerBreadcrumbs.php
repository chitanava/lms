<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;

trait RelationManagerBreadcrumbs
{

  public static function getBreadcrumbs(Page $page, Model $record = null): array
  {
    $resource = static::class;

    $breadcrumb = $page->getBreadcrumb();
    /** @var Ancestor $ancestor */
    $ancestor = $resource::getAncestor();

    // If no record passed
    if (!($page instanceof ListRecords)) {
      $record ??= $page->getRecord();
    }

    // If page has no record (such as create pages)
    $id = Arr::last($page->getRouteParameterIds());
    if ($ancestor) {
      $recordRouteKeyName = $ancestor->getResource()::getRecordRouteKeyName() ?? 'id';
      $relatedRecord = $record ? $ancestor->getRelatedModel($record) : $ancestor->getResource()::getModel()::firstWhere($recordRouteKeyName, $id);
    }

    // Fix: Generate a link based on the type of the page. See line 44 & 75
    if ($ancestor) {
      $index = $resource::hasPage('index')
        ? [
          $resource::getUrl('index', [
            ...$ancestor->getNormalizedRouteParameters($record ?? $relatedRecord),
          ]) => $resource::getBreadcrumb(),
        ]
        : [
          $ancestor->getResource()::getUrl($page instanceof ViewRecord || $page instanceof CreateRecord ? 'view' : 'edit', [
            ...$ancestor->getNormalizedRouteParameters($record ?? $relatedRecord),
          ]) . '#relation-manager' => $resource::getBreadcrumb(),
        ];
    } else {
      $index = [$resource::getUrl('index') => $resource::getBreadcrumb()];
    }

    $breadcrumbs = [];

    if ($ancestor) {
      $breadcrumbs = [
        ...$ancestor->getResource()::getBreadcrumbs($page, $relatedRecord),
        ...$breadcrumbs,
      ];
    }

    $breadcrumbs = [
      ...$breadcrumbs,
      ...$index,
    ];

    if ($page::getResource() === $resource) {
      $breadcrumbs = [
        ...$breadcrumbs,
        ...(filled($breadcrumb) ? [$breadcrumb] : []),
      ];
    } else {

      $pageTypes = match (true) {
        $page instanceof ViewRecord => ['view', 'edit'],
        $page instanceof CreateRecord => ['view', 'edit'],
        default => ['edit', 'view'],
      };

      foreach ($pageTypes as $pageType) {
        if ($resource::hasPage($pageType) && $resource::can($pageType, $record)) {
          $recordBreadcrumb = [$resource::getUrl($pageType, [
            ...$ancestor ? $ancestor->getNormalizedRouteParameters($record) : [],
            'record' => $record,
          ]) => $record->{$resource::getBreadcrumbTitleAttribute()}];

          break;
        }
      }

      $breadcrumbs = [
        ...$breadcrumbs,
        ...$recordBreadcrumb,
      ];
    }

    return $breadcrumbs;
  }
}
