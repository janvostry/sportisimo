<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\Utils\Paginator;


final class BrandFacade extends BaseFacade
{
    public function __construct(Explorer $explorer)
    {
        parent::__construct($explorer, "brand");
    }
    
    
    /**
     * @return integer
     */
    public function count(): int
    {
        return $this->getTable()->count();
    }
    
    
    /**
     * @param Paginator $paginator
     * @param boolean $reversed
     * @return Selection
     */
    public function list(Paginator $paginator, bool $reversed): Selection
    {
        $list = $this->getTable();
        if ($reversed) {
            $list = $list->order("name DESC");
        } else {
            $list = $list->order("name ASC");
        }
        $list = $list->limit($paginator->getLength(), $paginator->getOffset());
        return $list;
    }
    
    
    /**
     * @param string $name
     * @return void
     */
    public function create(string $name): void
    {
        $this->getTable()
            ->insert([
                "name" => $name,
            ]);
    }
    
    
    /**
     * @param integer $index
     * @param string $name
     * @return integer
     */
    public function update(int $index, string $name): int
    {
        return $this->getTable()
            ->where("id", $index)
            ->update([
                "name" => $name,
            ]);
    }
    
    
    /**
     * @param integer $index
     * @return integer
     */
    public function delete(int $index): int
    {
        return $this->getTable()
            ->where("id", $index)
            ->delete();
    }
}
