<?php

declare(strict_types=1);

namespace App\Models;

use Nette\SmartObject;
use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\Utils\Paginator;


abstract class BaseFacade
{
    use SmartObject;
    
    
    /** @var Explorer */
    protected Explorer $explorer;
    
    
    /** @var string */
    private string $tableName;
    
    
    public function __construct(Explorer $explorer, string $tableName)
    {
        $this->explorer = $explorer;
        $this->tableName = $tableName;
    }
    
    
    /**
     * @return Selection
     */
    protected function getTable(): Selection
    {
        return $this->explorer->table($this->tableName);
    }
    
    
    /**
     * @return integer
     */
    public abstract function count(): int;
    
    
    /**
     * @param Paginator $paginator
     * @param boolean $reversed
     * @return Selection
     */
    public abstract function list(Paginator $paginator, bool $reversed): Selection;
}
