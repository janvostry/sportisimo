<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var string[] */
    private $modals;
    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->modals = array();
    }
    
    
    /**
     * @param string $modal
     * @return void
     */
    public function addModal(string $modal): void
    {
        $this->modals[] = $modal;
    }
    
    
    /**
     * @return string[]
     */
    public function getModals(): array
    {
        return $this->modals;
    }
}
