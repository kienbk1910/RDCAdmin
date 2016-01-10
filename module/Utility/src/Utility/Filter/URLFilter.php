<?php
namespace Utility\Filter;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\StringTrim;
use Zend\Filter\Word\SeparatorToDash;
class URLFilter{
    private $filterChain;
    public function __construct(){
        $this->filterChain = new FilterChain();
            $this->filterChain->attach(new StringToLower(array('encoding' => 'UTF-8')))
               ->attach(new StringTrim())
               ->attach(new SeparatorToDash())
               ->attach(new RemoveCircumflex());
    }
    public function filter($string){
        
        return    $this->filterChain->filter($string);
    }
    
}