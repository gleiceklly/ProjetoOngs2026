<?php

namespace Core\Library;

class Raw
{
    public function __construct(private readonly string $value) {}

    /**
     * __tostring
     * 
     * Wraper para valores que não devem ser escapados pelo template
     * Use apenas para HTML confiável (ex.: saída de editores), já sanitizados, ou
     * HTML gerado internamnte pela aplicação
     * 
     * @return string
     */
    public function __toString() : string
    {
        return $this->value;
    }
}