<?php

declare(strict_types=1);

namespace App\Presenters;


final class HomepagePresenter extends BasePresenter
{
    /**
     * @return void
     */
    public function actionDefault(): void
    {
        $this->redirect("Brand:default"); // TODO: Use proper page
    }
}
