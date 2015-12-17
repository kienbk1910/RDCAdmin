<?php
namespace Application\Service;
use Application\Mapper\IndexMapperInterface;
use Application\Service\IndexServiceInterface;

class IndexService implements IndexServiceInterface
{
    protected $couponMapper;

    /**
     * @param PostMapperInterface $postMapper
     */
    public function __construct(IndexMapperInterface $couponMapper)
    {
        $this->couponMapper = $couponMapper;
    }
   
}
