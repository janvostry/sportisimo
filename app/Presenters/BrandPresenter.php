<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use App\Models\BaseFacade;
use App\Models\BrandFacade;


final class BrandPresenter extends AdminPresenter
{
    /** @var BrandFacade @inject */
    public BrandFacade $brands;
    
    
    /**
     * @return BaseFacade
     */
    public function getFacade(): BaseFacade
    {
        return $this->brands;
    }
    
    
    /**
     * @return Form
     */
    protected function buildForm(): Form
    {
        $form = new Form();
        
        $form->addText("name", "Název:")
            ->setRequired("Zadejte prosím název");
        
        return $form;
    }
    
    
    /**
     * @param Form $form
     * @param object $data
     * @return void
     */
    protected function handleCreate(Form $form, $data): void
    {
        try {
            $this->brands->create($data->name);
            
            $this->flashMessage("Značka přidána", "success");
        } catch (UniqueConstraintViolationException) {
            /** @var \Nette\Forms\Controls\TextInput */
            $name = $form["name"];
            $name->addError("Značka s tímto názvem již existuje");
        } catch (\Exception $error) {
            \Tracy\Debugger::barDump($error);
            
            $form->addError("Nastala neznámá chyba");
        }
    }
    
    
    /**
     * @param Form $form
     * @param object $data
     * @return void
     */
    protected function handleUpdate(Form $form, $data): void
    {
        try {
            $index = intval($data->index);
            $count = $this->brands->update($index, $data->name);
            
            if ($count === 1) {
                $this->flashMessage("Značka upravena", "success");
            } else if ($count === 0) {
                $this->flashMessage("Nebyla upravena žádná značka", "error");
            } else {
                $this->flashMessage("Bylo upraveno více značek", "warning");
            }
        } catch (UniqueConstraintViolationException) {
            /** @var \Nette\Forms\Controls\TextInput */
            $name = $form["name"];
            $name->addError("Značka s tímto názvem již existuje");
        } catch (\Exception $error) {
            \Tracy\Debugger::barDump($error);
            
            $form->addError("Nastala neznámá chyba");
        }
    }
    
    
    /**
     * @param Form $form
     * @param object $data
     * @return void
     */
    protected function handleDelete(Form $form, $data): void
    {
        try {
            $index = intval($data->index);
            $count = $this->brands->delete($index);
            
            if ($count === 1) {
                $this->flashMessage("Značka smazána", "success");
            } else if ($count === 0) {
                $this->flashMessage("Nebyla smazána žádná značka", "error");
            } else {
                $this->flashMessage("Bylo smazáno více značek", "warning");
            }
        } catch (\Exception $error) {
            \Tracy\Debugger::barDump($error);
            
            $form->addError("Nastala neznámá chyba");
        }
    }
    
    
    /**
     * @return void
     */
    protected function redirectAction(): void
    {
        $this->redirect("Brand:default");
    }
}
