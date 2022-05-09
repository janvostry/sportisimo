<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\Utils\Paginator;
use App\Models\BaseFacade;


abstract class AdminPresenter extends BasePresenter
{
    /** @var string */
    protected string $sorting;
    
    
    /** @var Paginator */
    protected Paginator $paginator;
    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->paginator = new Paginator();
    }
    
    
    /**
     * @return BaseFacade
     */
    public abstract function getFacade(): BaseFacade;
    
    
    /**
     * @param string $sort
     * @param integer $page
     * @param integer $limit
     */
    public function actionDefault($sort = "asc", $page = 1, $limit = 10): void
    {
        $this->sorting = $sort;
        $this->paginator->setPage($page);
        $this->paginator->setItemsPerPage($limit);
        $this->paginator->setItemCount($this->getFacade()->count());
    }
    
    
    /**
     * @return void
     */
    public function beforeRender(): void
    {
        parent::beforeRender();
        
        $this->template->sorting = $this->sorting;
        $this->template->paginator = $this->paginator;
        $this->template->items = $this->getFacade()->list($this->paginator, $this->sorting === "desc");
    }
    
    
    /**
     * @return Form
     */
    private function buildComponent(): Form
    {
        $form = $this->buildForm();
        
        $form->addProtection();
        
        $form->onError[] = function (Form $form): void {
            foreach ($form->getErrors() as $error) {
                $this->flashMessage($error, "error");
            }
        };
        
        return $form;
    }
    
    
    /**
     * @return Form
     */
    public function createComponentCreate(): Form
    {
        $form = $this->buildComponent();
        
        $form->onSuccess[] = function (Form $form, $data): void {
            $this->handleCreate($form, $data);
            
            if (!$form->hasErrors()) {
                $this->redirectAction();
            }
        };
        
        return $form;
    }
    
    
    /**
     * @return Form
     */
    public function createComponentUpdate(): Form
    {
        $form = $this->buildComponent();
        
        $form->addHidden("index")
            ->setRequired("Zadejte prosím index");
        
        $form->onSuccess[] = function (Form $form, $data): void {
            $this->handleUpdate($form, $data);
            
            if (!$form->hasErrors()) {
                $this->redirectAction();
            }
        };
        
        return $form;
    }
    
    
    /**
     * @return Form
     */
    public function createComponentDelete(): Form
    {
        $form = $this->buildComponent();
        
        $form->addHidden("index")
            ->setRequired("Zadejte prosím index");
        
        $form->onSuccess[] = function (Form $form, $data): void {
            $this->handleDelete($form, $data);
            
            if (!$form->hasErrors()) {
                $this->redirectAction();
            }
        };
        
        return $form;
    }
    
    
    /**
     * @return Form
     */
    protected abstract function buildForm(): Form;
    
    
    /**
     * @param Form $form
     * @param object $data
     * @return void
     */
    protected abstract function handleCreate(Form $form, $data): void;
    
    
    /**
     * @param Form $form
     * @param object $data
     * @return void
     */
    protected abstract function handleUpdate(Form $form, $data): void;
    
    
    /**
     * @param Form $form
     * @param object $data
     * @return void
     */
    protected abstract function handleDelete(Form $form, $data): void;
    
    
    /**
     * @return void
     */
    protected abstract function redirectAction(): void;
}
