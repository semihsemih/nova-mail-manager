<?php

namespace BinaryBuilds\NovaMailManager\Actions;

use BinaryBuilds\LaravelMailManager\Managers\MailManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;

class ResendMail extends DestructiveAction
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        foreach ($models as $model) {
            MailManager::resendMail($model);
        }

        return Action::message($models->count().' '.__('Mail(s) retried successfully'));
    }

    public function name()
    {
        return __('Resend Mail');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }
}
